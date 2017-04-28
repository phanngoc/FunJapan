<?php

namespace App\Services\Admin;

use App\Models\ArticleLocale;
use App\Models\ArticleTag;
use App\Models\Locale;
use Image;
use File;
use Illuminate\Support\Facades\Storage;
use DB;
use App\Services\Admin\LocaleService;
use Carbon\Carbon;

class ArticleLocaleService extends BaseService
{
    public static function list($conditions)
    {
        $keyword = $conditions['search']['value'];
        $searchColumns = ['id', 'title'];
        $limit = $conditions['length'];
        $page = $conditions['start'] / $conditions['length'] + 1;
        $orderParams = $conditions['order'];
        $orderConditions['column'] = $conditions['columns'][$orderParams[0]['column']]['data'];
        $orderConditions['dir'] = $orderParams[0]['dir'];
        $query = ArticleLocale::query();
        foreach ($conditions['columns'] as $column) {
            if ($column['data'] !== 'locale_id' && $column['data'] !== 'function') {
                $query->where($column['data'], 'like', '%' . $column['search']['value'] . '%');
            } elseif ($column['data'] === 'locale_id') {
                $locales = Locale::where('name', 'like', '%' . $column['search']['value'] . '%')->pluck('id');
                $query->whereIn($column['data'], $locales);
            }
        }

        $results = static::listItems($query, $keyword, $searchColumns, $orderConditions, $limit, $page);

        return $returnData = [
            'recordsFiltered' => $results->total(),
            'data' => $results->items(),
        ];
    }

    public static function listArticleByTags($tag)
    {
        $articleLocaleIds = ArticleTag::where('tag_id', $tag->id)->pluck('article_locale_id');

        return ArticleLocale::whereIn('id', $articleLocaleIds)->paginate();
    }

    public static function create($inputs, $thumbnail)
    {
        $articleLocale = ArticleLocale::create($inputs);

        if ($articleLocale) {
            $fileName = static::uploadImage($thumbnail, $articleLocale);
            $articleLocale->photo = $fileName;
            $articleLocale->save();
        }

        return $articleLocale;
    }

    public static function update($inputs, $articleLocaleId)
    {
        $articleLocale = ArticleLocale::findOrFail($articleLocaleId);

        if ($articleLocale->update($inputs)) {
            if (isset($inputs['thumbnail'])) {
                Storage::exists(config('article.thumbnail.upload.upload_path') . $articleLocale->id)
                    ? '' : Storage::makeDirectory(config('article.thumbnail.upload.upload_path') . $articleLocale->id);
                if (Storage::deleteDirectory(config('article.thumbnail.upload.upload_path') . $articleLocale->id)) {
                    $fileName = static::uploadImage($inputs['thumbnail'], $articleLocale);
                    $articleLocale->photo = $fileName;
                    $articleLocale->save();

                    return true;
                }
            }

            return true;
        }

        return false;
    }

    public static function uploadImage($thumbnail, $articleLocale)
    {
        $fileExtension = $thumbnail->getClientOriginalExtension();
        $fileName  = time() . '.' . $fileExtension;
        $path = config('article.thumbnail.upload.upload_path') . $articleLocale->id . '/';
        $demensions = config('article.thumbnail.upload.demensions');
        foreach ($demensions as $key => $demension) {
            $fullFileName = $key . $fileName;
            if ($key === 'original_') {
                $file = Image::make($thumbnail)->encode($fileExtension);
                Storage::put($path . $fullFileName, $file->__toString());
                continue;
            }
            $file = Image::make($thumbnail)
            ->resize($demension['width'], $demension['height'])
            ->encode($fileExtension);
            Storage::put($path . $fullFileName, $file->__toString());
        }

        return $fileName;
    }

    public static function createArticleOtherLanguage($article, $inputs)
    {
        $articleLocaleData = [
            'locale_id' => (int)$inputs['locale'],
            'article_id' => $article->id,
            'title' => $inputs['title'],
            'content' => $inputs['content'],
            'summary' => $inputs['summary'],
            'published_at' => $inputs['publish_date'] ? $inputs['publish_date'] . ':00' : Carbon::now(),
            'start_campaign' => $inputs['start_campaign'] ? $inputs['start_campaign'] . ':00' : null,
            'end_campaign' => $inputs['end_campaign'] ? $inputs['end_campaign'] . ':00' : null,
        ];

        if (isset($inputs['is_top_article'])) {
            $articleLocaleData['is_top_article'] = $inputs['is_top_article'];
        }

        if (isset($inputs['is_alway_hide'])) {
            $articleLocaleData['hide_alway'] = $inputs['is_alway_hide'];
        }

        if (isset($inputs['is_member_only'])) {
            $articleLocaleData['is_member_only'] = $inputs['is_member_only'];
        }

        DB::beginTransaction();
        try {
            if ($articleLocale = static::create($articleLocaleData, $inputs['thumbnail'])) {
                if (ArticleTagService::create($article, $articleLocale->id, $inputs['tags'] ?? [])) {
                    DB::commit();

                    return true;
                }
            }
            DB::rollback();

            return false;
        } catch (\Exception $e) {
            DB::rollback();

            return false;
        }
    }
}
