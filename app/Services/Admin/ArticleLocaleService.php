<?php

namespace App\Services\Admin;

use App\Models\ArticleLocale;
use App\Models\ArticleTag;
use App\Models\BannerSetting;
use App\Models\Locale;
use App\Models\User;
use App\Models\Article;
use Image;
use File;
use Illuminate\Support\Facades\Storage;
use DB;
use App\Services\Admin\LocaleService;
use Carbon\Carbon;
use App\Services\ImageService;

class ArticleLocaleService extends BaseService
{
    public static function list($conditions)
    {
        $keyword = escape_like($conditions['search']['value']);
        $searchColumns = ['title'];
        $limit = $conditions['length'];
        $page = $conditions['start'] / $conditions['length'] + 1;
        $orderParams = $conditions['order'];
        $orderConditions['column'] = $conditions['columns'][$orderParams[0]['column']]['data'];
        $orderConditions['dir'] = $orderParams[0]['dir'];
        $query = ArticleLocale::with('article.user');

        if (isset($conditions['locale_id'])) {
            $query = $query->where('locale_id', $conditions['locale_id']);
        }

        if (isset($conditions['tag_id'])) {
            $listArticleLocaleIds = ArticleTag::where('tag_id', $conditions['tag_id'])->pluck('article_locale_id');
            $query = $query->whereIn('id', $listArticleLocaleIds);
        }

        foreach ($conditions['columns'] as $column) {
            if ($column['data'] == 'user_id') {
                $userIds = User::where('name', 'like', '%' . escape_like($column['search']['value']) . '%')
                    ->pluck('id');
                $articleIds = Article::whereIn('user_id', $userIds)->pluck('id');
                $query->whereIn('article_id', $articleIds);
            } elseif ($column['data'] !== 'function') {
                $query->where($column['data'], 'like', '%' . escape_like($column['search']['value']) . '%');
            }
        }

        $results = static::listItems($query, $keyword, $searchColumns, $orderConditions, $limit, $page, true);

        return $returnData = [
            'recordsFiltered' => $results->total(),
            'data' => $results->items(),
        ];
    }

    public static function getListForRank($condition)
    {
        return ArticleLocale::where('locale_id', $condition['locale_id'])
            ->where('title', 'like', '%' . $condition['key_search'] . '%')
            ->where('published_at', '<=', Carbon::now())
            ->where('hide', 0)
            ->select(['id', 'title as text'])
            ->paginate(config('article.per_page'));
    }

    public static function listArticleByTags($tag)
    {
        $articleLocaleIds = ArticleTag::where('tag_id', $tag->id)->pluck('article_locale_id');

        return ArticleLocale::whereIn('id', $articleLocaleIds)->paginate();
    }

    public static function create($inputs, $thumbnail)
    {
        $thumbnailPath = config('images.paths.article_thumbnail') . '/' . $inputs['article_id'] . '/' . $inputs['locale_id'];
        $fileName = ImageService::uploadFile($thumbnail, 'article_thumbnail', $thumbnailPath);

        if ($fileName) {
            $inputs['photo'] = $fileName;

            return ArticleLocale::create($inputs);
        }

        return false;
    }

    public static function update($inputs, $articleLocaleId)
    {
        $articleLocale = ArticleLocale::findOrFail($articleLocaleId);

        if (isset($inputs['thumbnail'])) {
            $thumbnailPath = config('images.paths.article_thumbnail') . '/' . $articleLocale->article_id . '/' . $articleLocale->locale_id;
            $fileName = ImageService::uploadFile($inputs['thumbnail'], 'article_thumbnail', $thumbnailPath, true);

            if ($fileName) {
                $inputs['photo'] = $fileName;
            } else {
                return false;
            }
        }

        $isUpdated = $articleLocale->update($inputs);

        if (!$isUpdated) {
            return false;
        }

        if (!$articleLocale->is_show_able) {
            $articleLocale->save();

            $removeInBanner = BannerSetting::where('article_locale_id', $articleLocale->id);
            if (count($removeInBanner->get()) > 0) {
                $isRemoveBanner = $removeInBanner->update(
                    [
                        'article_locale_id' => 0,
                        'photo' => null,
                    ]
                );

                if (!$isRemoveBanner) {
                    return false;
                }
            }
        }

        return true;
    }
}
