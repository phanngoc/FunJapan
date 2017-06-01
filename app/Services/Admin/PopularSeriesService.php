<?php

namespace App\Services\Admin;

use App\Models\PopularSeries;
use App\Models\ArticleLocale;
use App\Models\ArticleTag;
use App\Models\Tag;
use App\Models\Category;
use App\Services\ImageService;
use Validator;
use DB;
use Illuminate\Support\Facades\Log;

class PopularSeriesService extends BaseService
{
    public static function list($conditions)
    {
        $keyword = escape_like($conditions['search']['value']);
        $searchColumns = ['summary', 'type', 'link'];
        $limit = $conditions['length'];
        $page = $conditions['start'] / $conditions['length'] + 1;
        $orderParams = $conditions['order'];
        $orderConditions['column'] = $conditions['columns'][$orderParams[0]['column']]['data'];
        $orderConditions['dir'] = $orderParams[0]['dir'];
        $query = PopularSeries::query();

        if (isset($conditions['locale_id'])) {
            $query = $query->where('locale_id', $conditions['locale_id']);
        }

        $results = static::listItems($query, $keyword, $searchColumns, $orderConditions, $limit, $page);

        return $returnData = [
            'recordsFiltered' => $results->total(),
            'data' => $results->items(),
        ];
    }
    public static function validate($inputs, $popularSeries = null)
    {
        $validateRules = [
            'summary' => 'required|max:255',
            'photo' => 'required|image|max:' . config('images.validate.popular_series_image.max_size'),
            'link' => 'required',
        ];
        if ($popularSeries) {
            $validateRules['photo'] = 'image|max:' . config('images.validate.popular_series_image.max_size');
        }

        return Validator::make($inputs, $validateRules)
            ->setAttributeNames(trans('admin/popular_series.label'));
    }

    public static function create($inputs)
    {
        $popularSeriesData = [
            'locale_id' => $inputs['locale'],
            'summary' => $inputs['summary'],
            'type' => $inputs['type'],
            'link' => $inputs['link'],
        ];
        DB::beginTransaction();
        try {
            if ($popularSeries = PopularSeries::create($popularSeriesData)) {
                $imagePath = config('images.paths.popular_series_image') . '/' . $popularSeries->id;
                $fileName = ImageService::uploadFile($inputs['photo'], 'popular_series_image', $imagePath);

                if ($fileName) {
                    $popularSeries->photo = $fileName;
                    $popularSeries->save();
                    DB::commit();

                    return true;
                }
            }
            DB::rollback();

            return false;
        } catch (\Exception $e) {
            DB::rollback();
            Log::debug($e);

            return false;
        }
    }

    public static function update($inputs, $popularSeries)
    {
        $popularSeriesData = [
            'summary' => $inputs['summary'],
            'type' => $inputs['type'],
            'link' => $inputs['link'],
        ];

        if (isset($inputs['photo'])) {
            $imagePath = config('images.paths.popular_series_image') . '/' . $popularSeries->id;
            $fileName = ImageService::uploadFile($inputs['photo'], 'popular_series_image', $imagePath, true);

            if ($fileName) {
                $popularSeriesData['photo'] = $fileName;
            } else {
                return false;
            }
        }

        return $popularSeries->update($popularSeriesData);
    }

    public static function delete($popularSeries)
    {
        $imagePath = config('images.paths.popular_series_image') . '/' . $popularSeries->id;

        if (ImageService::delete($imagePath)) {
            return $popularSeries->delete();
        }

        return false;
    }

    public static function suggestCategoryOrTags($inputs)
    {
        $results = [];
        $q = escape_like($inputs['q']);
        if ($inputs['type'] == strtolower(config('popular_series.type.category'))) {
            $results = Category::select('id', 'name')
                ->where('locale_id', $inputs['locale_id'])->where('name', 'like', "%$q%")->get()->toArray();
        } else {
            $listArticleIds = ArticleLocale::where('locale_id', $inputs['locale_id'])->pluck('id');
            $listTagIds = ArticleTag::whereIn('article_locale_id', $listArticleIds)->pluck('tag_id');
            $results = Tag::select('id', 'name')->whereIn('id', $listTagIds)
                ->where('name', 'like', "%$q%")->get()->toArray();
        }

        return $results;
    }
}
