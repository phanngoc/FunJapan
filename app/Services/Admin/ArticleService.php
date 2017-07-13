<?php

namespace App\Services\Admin;

use App\Models\Article;
use App\Models\ArticleLocale;
use App\Models\TopArticle;
use Illuminate\Validation\Rule;
use Validator;
use DB;
use Carbon\Carbon;
use Auth;

class ArticleService extends BaseService
{
    public static function validate($inputs, $article = null)
    {
        $validationRules = [
            'locale' => 'required',
            'summary' => 'required|min:1|max:1000',
            'title' => 'required|min:10|max:255',
            'content' => 'required|min:20',
            'category' => 'required',
            'thumbnail' => 'image|max:' . config('images.validate.article_thumbnail.max_size'),
            'tags.*' => 'min:3|max:15',
            'type' => 'in:' . implode(',', array_values(config('article.type'))),
        ];

        if ($inputs['type'] == config('article.type.photo')
            || $inputs['type'] == config('article.type.campaign')
            || $inputs['type'] == config('article.type.coupon')) {
            $validationRules['start_campaign'] = 'required|date_format:"Y-m-d H:i"';
            $validationRules['end_campaign'] = 'date_format:"Y-m-d H:i"|after:start_campaign';
        }

        if (!$article) {
            $validationRules['thumbnail'] = 'required|image|max:' . config('images.validate.article_thumbnail.max_size');
        }

        return Validator::make($inputs, $validationRules)
            ->setAttributeNames(trans('admin/article.label'));
    }

    public static function validateGlobal($input)
    {
        $rules = [
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
                // delete after
                'category_id' => $inputs['category'],
                'type' => $inputs['type'],
                'auto_approve_photo' => $inputs['auto_approve_photo'],
            ];
            if ($article = Article::create($articleData)) {
                $articleLocaleData = [
                    'locale_id' => (int)$inputs['locale'],
                    'article_id' => $article->id,
                    'category_id' => $inputs['category'],
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
                    $articleLocaleData['hide_always'] = $inputs['is_alway_hide'];
                }

                if (isset($inputs['is_member_only'])) {
                    $articleLocaleData['is_member_only'] = $inputs['is_member_only'];
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
                // delete after
                'category_id' => $inputs['category'],
            ];
            if ($article->update($articleData)) {
                $articleLocaleData = [
                    'title' => $inputs['title'],
                    'content' => $inputs['content'],
                    'summary' => $inputs['summary'],
                    'category_id' => $inputs['category'],
                    'is_top_article' => isset($inputs['is_top_article']) ? $inputs['is_top_article'] : 0,
                    'hide_always' => isset($inputs['is_alway_hide']) ? $inputs['is_alway_hide'] : 0,
                    'is_member_only' => isset($inputs['is_member_only']) ? $inputs['is_member_only'] : 0,
                    'start_campaign' => $inputs['start_campaign'] ? $inputs['start_campaign'] . ':00' : null,
                    'end_campaign' => $inputs['end_campaign'] ? $inputs['end_campaign'] . ':00' : null,
                ];

                if (isset($inputs['thumbnail'])) {
                    $articleLocaleData['thumbnail'] = $inputs['thumbnail'];
                }

                if (isset($inputs['publish_date'])) {
                    $articleLocaleData['published_at'] = $inputs['publish_date'] . ':00';
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

    public static function getListArticleForPopularPost($input)
    {
        return ArticleLocale::where('locale_id', $input['locale_id'] ?? $input['default_locale_id'])
            ->where(function ($query) use ($input) {
                $query->where('title', 'like', '%' . $input['keyword'] . '%')
                    ->orWhere('article_id', $input['keyword']);
            })
            ->where('published_at', '<=', Carbon::now())
            ->where('hide_always', 0)
            ->paginate(config('limitation.popular_article.per_page'));
    }

    public static function getPopularPost($localeId, $limit = null)
    {
        $query = ArticleLocale::where('is_popular', true)
            ->where('locale_id', $localeId);

        if ($limit) {
            $query->limit($limit);
        }

        return $query->get();
    }

    public static function addPopularPost($articleLocaleId)
    {
        $articleLocale = ArticleLocale::find($articleLocaleId);

        if (!$articleLocale) {
            return [
                'success' => false,
                'message' => trans('admin/popular_article.messages.not_found'),
            ];
        }

        if (!$articleLocale->is_show_able) {
            return [
                'success' => false,
                'message' => trans('admin/popular_article.messages.not_show'),
            ];
        }

        if (!$articleLocale->is_popular && config('limitation.popular_article.limit') > 0) {
            $countPopular = ArticleLocale::where('is_popular', true)
                ->where('locale_id', $articleLocale->locale_id)
                ->count();

            if ($countPopular >= config('limitation.popular_article.limit')) {
                return [
                    'success' => false,
                    'message' => trans('admin/popular_article.messages.max_setting'),
                ];
            }
        }

        $articleLocale->timestamps = false;
        $articleLocale->is_popular = true;
        $updated = $articleLocale->save();

        return [
            'success' => $updated,
            'message' => $updated ? trans('admin/popular_article.messages.success') : trans('admin/popular_article.messages.fail'),
        ];
    }

    public static function deletePopularPost($articleLocaleId)
    {
        $articlesLocale = ArticleLocale::find($articleLocaleId);

        if (!$articlesLocale || !$articlesLocale->is_popular) {
            return [
                'success' => false,
                'message' => trans('admin/popular_article.messages.not_found'),
            ];
        }

        $articlesLocale->timestamps = false;
        $articlesLocale->is_popular = false;
        $updated = $articlesLocale->save();

        return [
            'success' => $updated,
            'message' => $updated ? trans('admin/popular_article.messages.success') : trans('admin/popular_article.messages.fail'),
        ];
    }

    public static function getListForBanner($condition)
    {
        return ArticleLocale::where('locale_id', $condition['locale_id'])
            ->where('title', 'like', '%' . $condition['key_word'] . '%')
            ->where('published_at', '<=', Carbon::now())
            ->where('hide_always', 0)
            ->select(['id', 'title', 'locale_id', 'article_id', 'summary', 'published_at'])
            ->paginate(config('banner.article_suggest'))
            ->toArray();
    }
    
    public static function listArticles($options)
    {
        $articles = Article::with([
            'articleLocales' => function ($query) {
                $query->orderBy('created_at', 'asc');
            },
        ], 'articleLocales.locale');

        if (isset($options['client_id'])) {
            $articles = $articles->where('client_id', $options['client_id']);
        }

        if (isset($options['author_id'])) {
            $articles = $articles->where('author_id', $options['author_id']);
        }

        if (isset($options['keyword']) && $options['keyword']) {
            $keyword = escape_like($options['keyword']);
            $searchColumn = $options['searchColumn'] ?? 'title';

            if (in_array($searchColumn, ['client_id', 'id'])) {
                $articles = $articles->where($searchColumn, 'like', "%$keyword%");
            } elseif (in_array($searchColumn, $options['searchColumns'])) {
                $articles = $articles->where(function ($currentQuery) use ($keyword, $searchColumn, $options) {
                    $currentQuery->whereIn(
                        'id',
                        ArticleLocale::where($searchColumn, 'like', "%$keyword%")
                            ->pluck('article_id')->toArray()
                    );
                });
            }
        }

        if (isset($options['dateFilter']) && $options['dateFilter']) {
            $dateFilter = Carbon::createFromFormat('Y M', $options['dateFilter']);
            $articles = $articles->where(function ($currentQuery) use ($dateFilter) {
                $currentQuery->whereIn(
                    'id',
                    ArticleLocale::whereMonth('published_at', $dateFilter->month)
                        ->whereYear('published_at', $dateFilter->year)
                        ->pluck('article_id')->toArray()
                );
            });
        }

        $orderBy = $options['orderBy'] ?? null;
        $optionsSort = [
            'id.desc',
            'id.asc',
            'title.desc',
            'title.asc',
            'client_id.desc',
            'client_id.asc',
        ];

        if (!in_array($orderBy, $optionsSort)) {
            $orderBy = 'id.desc';
        }

        $orders = explode('.', $orderBy);
        if ($orders[0] == 'title') {
            //
        } else {
            $articles = $articles->orderBy($orders[0], $orders[1]);
        }

        $articles = $articles->paginate($options['limit'] ?? config('limitation.articles.default_per_page'));

        foreach ($articles as $key => $article) {
            $articleLocales = [];
            $i = 1;
            foreach ($article->articleLocales as $articleLocale) {
                if ($articleLocale->locale->iso_code == config('app.locale')) {
                    $articleLocales[0] = $articleLocale;
                } else {
                    $articleLocales[$i] = $articleLocale;
                    $i++;
                }
            }

            ksort($articleLocales);
            $articleLocales = array_values($articleLocales);
            $articles[$key]->arrangedArticleLocales = $articleLocales;
        }

        return $articles;
    }

    public static function getArticleAlwayOnTop()
    {
        return TopArticle::all();
    }

    public static function validateSetAlwaysOnTop($input)
    {
        $validationRules = [
            'locale_id' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date|after:' . Carbon::today()->toDateString(),
            'article_locale_id' => 'required|exists:article_locales,id',
        ];

        $messages = [
            'end_date.after' => trans('admin/article.always_on_top.validate.after_end_date'),
        ];

        return Validator::make($input, $validationRules, $messages)->messages()->toArray();
    }

    public static function setAlwaysOnTop($input)
    {
        $topArticle = TopArticle::where('locale_id', $input['locale_id'])->first();

        try {
            if ($topArticle) {
                if ($topArticle->article_locale_id == $input['article_locale_id']) {
                    $topArticle->update($input);
                } else {
                    $topArticle->delete();
                    TopArticle::create($input);
                }
            } else {
                TopArticle::create($input);
            }

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function deleteAlwaysOnTop($topArticleId)
    {
        $topArticle = TopArticle::find($topArticleId);

        return $topArticle->delete();
    }

    public static function stop($articleId)
    {
        $article = Article::with('articleLocales')->find($articleId);

        if (!$article) {
            return false;
        }

        return $article->articleLocales()->update(['status' => config('article.status.stop')]);
    }
}
