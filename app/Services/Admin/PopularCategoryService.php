<?php
namespace App\Services\Admin;

use App\Models\PopularCategory;
use App\Models\ArticleLocale;
use App\Models\ArticleTag;
use App\Models\Tag;
use App\Models\Category;
use App\Services\ImageService;
use Validator;
use DB;
use Illuminate\Support\Facades\Log;

class PopularCategoryService extends BaseService
{
    public static function list($conditions)
    {
        $keyword = escape_like($conditions['search']['value']);
        $searchColumns = ['name', 'link'];
        $limit = $conditions['length'];
        $page = $conditions['start'] / $conditions['length'] + 1;
        $orderParams = $conditions['order'];
        $orderConditions['column'] = $conditions['columns'][$orderParams[0]['column']]['data'];
        $orderConditions['dir'] = $orderParams[0]['dir'];
        $query = PopularCategory::query();
        if (isset($conditions['locale_id'])) {
            $query = $query->where('locale_id', $conditions['locale_id']);
        }
        $results = static::listItems($query, $keyword, $searchColumns, $orderConditions, $limit, $page);

        return $returnData = [
            'recordsFiltered' => $results->total(),
            'data' => $results->items(),
        ];
    }

    public static function validate($inputs, $popularCategory = null)
    {
        $validateRules = [
            'name' => 'required|max:255',
            'photo' => 'required|image|max:' . config('images.validate.popular_category_image.max_size'),
            'link' => 'required',
        ];
        if ($popularCategory) {
            $validateRules['photo'] = 'image|max:' . config('images.validate.popular_category_image.max_size');
        }

        return Validator::make($inputs, $validateRules)
            ->setAttributeNames(trans('admin/popular_category.label'));
    }

    public static function create($inputs)
    {
        $popularCategoryData = [
            'locale_id' => $inputs['locale'],
            'name' => $inputs['name'],
            'link' => $inputs['link'],
        ];
        DB::beginTransaction();
        try {
            if ($popularCategory = PopularCategory::create($popularCategoryData)) {
                $imagePath = config('images.paths.popular_category_image') . '/' . $popularCategory->id;
                $fileName = ImageService::uploadFile($inputs['photo'], 'popular_category_image', $imagePath);
                if ($fileName) {
                    $popularCategory->photo = $fileName;
                    $popularCategory->save();
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

    public static function update($inputs, $popularCategory)
    {
        $popularCategoryData = [
            'name' => $inputs['name'],
            'link' => $inputs['link'],
        ];
        if (isset($inputs['photo'])) {
            $imagePath = config('images.paths.popular_category_image') . '/' . $popularCategory->id;
            $fileName = ImageService::uploadFile($inputs['photo'], 'popular_category_image', $imagePath, true);
            if ($fileName) {
                $popularCategoryData['photo'] = $fileName;
            } else {
                return false;
            }
        }
        return $popularCategory->update($popularCategoryData);
    }

    public static function delete($popularCategory)
    {
        $imagePath = config('images.paths.popular_category_image') . '/' . $popularCategory->id;
        if (ImageService::delete($imagePath)) {
            return $popularCategory->delete();
        }

        return false;
    }

    public static function suggestCategories($inputs)
    {
        $results = [];
        $q = escape_like($inputs['q']);
        $results = Category::select('id', 'name')
            ->where('locale_id', $inputs['locale_id'])->where('name', 'like', "%$q%")->get()->toArray();

        return $results;
    }
}
