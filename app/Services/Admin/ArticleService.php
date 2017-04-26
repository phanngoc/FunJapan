<?php

namespace App\Services\Admin;

use App\Models\Article;
use Validator;
use DB;
use Carbon\Carbon;
use Auth;

class ArticleService extends BaseService
{
    public static function validate($inputs, $article = null)
    {
        $validationRules = [
            'title' => 'required|min:10|max:255',
            'content' => 'required|min:20',
            'summary' => 'required|min:1|max:1000',
            'locale' => 'required',
            'category' => 'required',
            'thumbnail' => 'image|max:' . config('article.thumbnail.upload.max_size'),
            'tags.*' => 'min:3|max:15',
            'type' => 'in:' . implode(',', array_values(config('article.type'))),
            'start_campaign' => 'required|date_format:"Y-m-d H:i"',
            'end_campaign' => 'date_format:"Y-m-d H:i"|after:start_campaign',
        ];

        if (!$article) {
            $validationRules['thumbnail'] = 'required|image|max:' . config('article.thumbnail.upload.max_size');
        }

        return Validator::make($inputs, $validationRules)
            ->setAttributeNames(trans('admin/article.label'));
    }

    public static function validateGlobal($input)
    {
        $rules = [
            'category_id' => 'required',
            'type' => 'in:' . implode(',', array_values(config('article.type'))),
        ];

        return Validator::make($input, $rules)
            ->setAttributeNames(trans('admin/article.label'));
    }

    public static function create($inputs)
    {
        DB::beginTransaction();
        try {
            $articleData = [
                'user_id' => Auth::id(),
                'category_id' => $inputs['category'],
                'type' => $inputs['type'],
                'auto_approve_photo' => $inputs['auto_approve_photo'],
            ];

            if ($article = Article::create($articleData)) {
                $articleLocaleData = [
                    'locale_id' => (int)$inputs['locale'],
                    'article_id' => $article->id,
                    'title' => $inputs['title'],
                    'content' => $inputs['content'],
                    'summary' => $inputs['summary'],
                    'published_at' => $inputs['publish_date'] ?? Carbon::now(),
                    'start_campaign' => $inputs['start_campaign'],
                    'end_campaign' => $inputs['end_campaign'],
                ];
                if (isset($inputs['is_top_article'])) {
                    $articleLocaleData['is_top_article'] = $inputs['is_top_article'];
                }

                if ($articleLocale = ArticleLocaleService::create($articleLocaleData, $inputs['thumbnail'])) {
                    if (ArticleTagService::create($article, $articleLocale->id, $inputs['tags'] ?? [])) {
                        DB::commit();

                        return $article;
                    }
                }
            }
            DB::rollback();

            return false;
        } catch (\Exception $e) {
            DB::rollback();

            return false;
        }
    }

    public static function update($article, $inputs)
    {
        DB::beginTransaction();
        try {
            $articleData = [
                'category_id' => $inputs['category'],
            ];
            if ($article->update($articleData)) {
                $articleLocaleData = [
                    'title' => $inputs['title'],
                    'content' => $inputs['content'],
                    'summary' => $inputs['summary'],
                    'published_at' => $inputs['publish_date'],
                    'is_top_article' => isset($inputs['is_top_article']) ? $inputs['is_top_article'] : 0,
                    'start_campaign' => $inputs['start_campaign'],
                    'end_campaign' => $inputs['end_campaign'],
                ];
                if (isset($inputs['thumbnail'])) {
                    $articleLocaleData['thumbnail'] = $inputs['thumbnail'];
                }
                if (ArticleLocaleService::update($articleLocaleData, $inputs['articleLocaleId'])) {
                    if (ArticleTagService::update($article, $inputs['articleLocaleId'], $inputs['tags'] ?? [])) {
                        DB::commit();

                        return true;
                    }
                }
            }

            return false;
        } catch (\Exception $e) {
            DB::rollback();

            return false;
        }
    }

    public static function getArticleTypes()
    {
        $result = [];

        foreach (config('article.type') as $key => $value) {
            $result[$value] = trans('admin/article.type.' . $key);
        }

        return $result;
    }
}
