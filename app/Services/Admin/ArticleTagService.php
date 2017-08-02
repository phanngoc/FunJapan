<?php

namespace App\Services\Admin;

use App\Models\TagLocale;
use App\Services\Admin\TagService;
use App\Services\Admin\LocaleService;
use App\Models\ArticleTag;
use App\Models\Tag;
use Carbon\Carbon;
use DB;

class ArticleTagService extends BaseService
{
    public static function create($article, $articleLocaleId, $tags)
    {
        if (!$tags) {
            return true;
        }

        $locales = LocaleService::getAllLocales();

        $tagLocaleDatas = [];
        foreach ($tags as $tag) {
            foreach ($locales as $key => $value) {
                $tagLocaleDatas[$tag][] = [
                    'name' => $tag,
                    'locale_id' => $key,
                ];
            }
        }

        $tagsCreated = TagService::create($tags, $tagLocaleDatas);

        if ($tagsCreated) {
            DB::beginTransaction();
            try {
                foreach ($tagsCreated as $tagId) {
                    $articleTag = ArticleTag::create([
                        'article_locale_id' => $articleLocaleId,
                        'article_id' => $article->id,
                        'tag_id' => $tagId,
                    ]);
                }
                DB::commit();

                return true;
            } catch (\Exception $e) {
                DB::rollback();

                return false;
            }
        }

        return false;
    }

    public static function update($articleLocale, $tags)
    {
        $articleTags = ArticleTag::where('article_id', $articleLocale->article_id)->where('article_locale_id', $articleLocale->id);

        DB::beginTransaction();
        try {
            if (!$tags) {
                $articleTags->delete();
                DB::commit();

                return true;
            }

            $tags = array_unique($tags);
            $locales = LocaleService::getAllLocales();

            $tagLocaleDatas = [];
            $tagLocales = TagLocale::whereIn('name', $tags)
                ->where('locale_id', $articleLocale->locale_id)
                ->get();
            $newTags = array_diff($tags, $tagLocales->pluck('name')->toArray());

            foreach ($newTags as $tag) {
                foreach ($locales as $key => $value) {
                    $tagLocaleDatas[$tag][] = [
                        'name' => $tag,
                        'locale_id' => $key,
                    ];
                }
            }

            $tagsCreated = [];
            if ($tagLocaleDatas) {
                $tagsCreated = TagService::create($newTags, $tagLocaleDatas);
            }
            $tagsCreated = array_merge($tagsCreated, $tagLocales->pluck('tag_id')->toArray());

            if ($tagsCreated) {
                $oldTags = $articleTags->get()->pluck('tag_id', 'id')->toArray();
                $newTags = array_diff($tagsCreated, $oldTags);
                $deleteTags = array_diff($oldTags, $tagsCreated);

                $articleTags = [];
                foreach ($newTags as $tagId) {
                    $articleTags[] = [
                        'article_locale_id' => $articleLocale->id,
                        'article_id' => $articleLocale->article_id,
                        'tag_id' => $tagId,
                        'updated_at' => Carbon::now(),
                        'created_at' => Carbon::now(),
                    ];
                }

                if ($articleTags) {
                    ArticleTag::insert($articleTags);
                }

                if ($deleteTags) {
                    ArticleTag::whereIn('tag_id', $deleteTags)
                        ->where('article_locale_id', $articleLocale->id)
                        ->delete();
                }
            }

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();

            return false;
        }
    }
}
