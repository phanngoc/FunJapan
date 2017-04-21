<?php

namespace App\Services\Admin;

use App\Services\Admin\TagService;
use App\Models\ArticleTag;
use DB;

class ArticleTagService extends BaseService
{
    public static function create($article, $articleLocaleId, $tags)
    {
        if (!$tags) {
            return true;
        }
        $tagsCreated = TagService::create($tags);

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

    public static function getArticleTagsByArticleAndLocale($articleId, $localeId)
    {
        return ArticleTag::where('article_id', $articleId)->where('article_locale_id', $localeId);
    }

    public static function update($article, $localeId, $tags)
    {
        $articleTags = static::getArticleTagsByArticleAndLocale($article->id, $localeId);
        DB::beginTransaction();
        try {
            if (!$tags) {
                $articleTags->delete();
                DB::commit();

                return true;
            }

            $tagsCreated = TagService::create($tags);

            if ($tagsCreated) {
                $oldTags = $articleTags->get()->pluck('tag_id', 'id')->toArray();
                $newTags = array_diff($tagsCreated, $oldTags);
                $deleteTags = array_diff($oldTags, $tagsCreated);
                foreach ($newTags as $tagId) {
                    $articleTag = ArticleTag::create([
                        'article_locale_id' => $localeId,
                        'article_id' => $article->id,
                        'tag_id' => $tagId,
                    ]);
                }

                foreach ($deleteTags as $tagId) {
                    $articleTag = ArticleTag::where('tag_id', $tagId)->where('article_locale_id', $localeId)->first();
                    $articleTag->delete();
                }
                DB::commit();

                return true;
            }

            return false;
        } catch (\Exception $e) {
            DB::rollback();

            return false;
        }
    }
}
