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
            'title' => 'required|min:10',
            'content' => 'required|min:20',
            'summary' => 'required|min:1',
            'locale' => 'required',
            'category' => 'required',
            'publish_date' => 'required|after_or_equal:'. Carbon::now()->format('d-m-Y'),
            'thumbnail' => 'image|max:' . config('article.thumbnail.upload.max_size'),
        ];

        if (!$article) {
            $validationRules['thumbnail'] = 'required|image|max:' . config('article.thumbnail.upload.max_size');
        }

        return Validator::make($inputs, $validationRules);
    }

    public static function create($inputs)
    {
        DB::beginTransaction();
        try {
            $articleData = [
                'user_id' => Auth::id(),
                'category_id' => $inputs['category'],
            ];

            if ($article = Article::create($articleData)) {
                $articleLocaleData = [
                    'locale_id' => (int)$inputs['locale'],
                    'article_id' => $article->id,
                    'title' => $inputs['title'],
                    'content' => $inputs['content'],
                    'summary' => $inputs['summary'],
                    'published_at' => $inputs['publish_date'],
                ];

                if (ArticleLocaleService::create($articleLocaleData, $inputs['thumbnail'])) {
                    if (ArticleTagService::create($article, (int)$inputs['locale'], $inputs['tags'] ?? [])) {
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
                ];
                if (isset($inputs['thumbnail'])) {
                    $articleLocaleData['thumbnail'] = $inputs['thumbnail'];
                }
                if (ArticleLocaleService::update($articleLocaleData, $inputs['articleLocaleId'])) {
                    if (ArticleTagService::update($article, (int)$inputs['locale'], $inputs['tags'] ?? [])) {
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
}
