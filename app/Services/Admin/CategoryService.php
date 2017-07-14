<?php

namespace App\Services\Admin;

use App\Models\Category;
use App\Models\PostPhoto;
use App\Models\FavoriteComment;
use App\Models\FavoriteArticle;
use App\Models\Comment;
use App\Models\ArticleTag;
use App\Models\ArticleLocale;
use App\Models\CategoryLocale;
use App\Models\Article;
use App\Models\InterestUser;
use App\Models\Locale;
use App\Services\ImageService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Validator;
use DB;
use Image;
use Auth;

class CategoryService extends BaseService
{
    public static function listCategory()
    {
        $categories = Category::all();

        return $categories;
    }

    public static function listCategoryLocale($localeID)
    {
        $categories = Category::where('locale_id', $localeID)->get();

        return $categories;
    }

    public static function getCategoryLocaleDropList($localeID)
    {
        $categories = Category::where('locale_id', $localeID)->pluck('name', 'id')->toArray();

        return $categories;
    }

    public static function getAllCategories()
    {
        $add = trans('admin/article.select_category');
        $categories = Category::pluck('name', 'id')->prepend($add, '')->toArray();

        return $categories;
    }

    public static function validate($inputs, $key = null)
    {
        $validationRules = [
            'name' => 'required|max:255|unique_name_category:'.$inputs['locale_id'] ?? '',
            'short_name' => 'required|max:20',
            'image' => 'required|image|max:' . config('images.validate.category_icon.max_size'),
            'locale_id' => 'required',
        ];
        if ($key) {
            $validationRules = [
                'name' => 'required|max:255|unique_name_category:' . $inputs['locale_id'] . ',' . $inputs['id'],
                'short_name' => 'required|max:20',
                'image' => 'image|max:' . config('images.validate.category_icon.max_size'),
            ];
        }

        return Validator::make($inputs, $validationRules)
            ->setAttributeNames(trans('admin/category.label'));
    }

    public static function update($inputs)
    {
        try {
            $category = Category::find($inputs['id']);
            if ($category) {
                $icon = '';
                if (isset($inputs['image'])) {
                    $iconPath = config('images.paths.category_icon') . '/' . $category->id;
                    if ($category->icon) {
                        ImageService::delete($iconPath);
                    }
                    $icon = ImageService::uploadFile($inputs['image'], 'category_icon', $iconPath);
                }
                if ($icon) {
                    return $category->update([
                        'name' => $inputs['name'],
                        'short_name' => $inputs['short_name'],
                        'icon' => $icon,
                    ]);
                }

                return $category->update([
                        'name' => $inputs['name'],
                        'short_name' => $inputs['short_name'],
                    ]);
            }

            return false;
        } catch (\Exception $e) {
            Log::error($e);

            return false;
        }
    }

    public static function create($inputs)
    {
        DB::beginTransaction();
        try {
            $category = new Category();
            $category->name = $inputs['name'];
            $category->short_name = $inputs['short_name'];
            $category->user_id = Auth::user()->id;
            $category->locale_id = $inputs['locale_id'];
            $category->save();

            if ($category->id) {
                if (isset($inputs['image'])) {
                    $photoUploadPath = config('images.paths.category_icon') . '/' . $category->id;
                    $icon = ImageService::uploadFile($inputs['image'], 'category_icon', $photoUploadPath);
                    if ($icon) {
                        $category->update([
                            'icon' => $icon,
                        ]);
                    } else {
                        DB::rollback();

                        return false;
                    }
                }
            } else {
                DB::rollback();

                return false;
            }
            DB::commit();

            return $category->id;
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e);

            return false;
        }
    }

    public static function find($id)
    {
        return Category::find($id);
    }

    public static function delete($categoryId)
    {
        $category = Category::find($categoryId);
        if ($category) {
            DB::beginTransaction();
            try {
                $articles = Article::where('category_id', '=', $category->id)->get();
                foreach ($articles as $article) {
                    $comments = Comment::where('article_id', '=', $article->id)->get();
                    if (!empty($comments)) {
                        foreach ($comments as $comment) {
                            $comment->delete();
                        }
                    }
                    $article->articleLocales()->delete();
                    $article->articleTags()->delete();
                    $article->favoriteArticles()->delete();
                    $article->postPhotos()->delete();
                    $article->delete();
                }
                //$category->categoryLocales()->delete();
                $category->interestUsers()->delete();
                $category->delete();
                DB::commit();

                return true;
            } catch (\Exception $e) {
                DB::rollback();
                Log::error($e);

                return false;
            }
        }
        Log::error("Category doesn't exist");

        return false;
    }

    public static function checkCategoryUsed($categoryId)
    {
        return Article::where('category_id', '=', $categoryId)->count();
    }

    public static function getCategory($categoryId)
    {
        return Category::select('id', 'name', 'short_name')->where('id', $categoryId)->first();
    }

    public static function getSubCategories()
    {
        $result = [];

        foreach (config('category.sub_categories') as $key => $value) {
            $result[$value] = trans('admin/category.sub_categories.' . $key);
        }

        return $result;
    }
}
