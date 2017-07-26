<?php

namespace App\Services\Admin;

use App\Models\Article;
use App\Models\Author;
use App\Models\Category;
use App\Models\Client;
use App\Models\ArticleLocale;
use App\Models\EditorChoice;
use App\Models\BannerSetting;
use App\Models\Locale;
use App\Models\TopArticle;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Validator;
use DB;
use Carbon\Carbon;
use Exception;
use Auth;

class ArticleService extends BaseService
{
    public static function validate($inputs, $preview = false)
    {
        $inputs['content'] = str_replace('&nbsp;', '', trim(strip_tags($inputs['content'])));
        $inputs['description'] = trim($inputs['description']);

        $validationRules = [
            'locale_id' => 'required',
            'description' => 'required|min:1|max:1000',
            'title' => 'required|min:10|max:255',
            'content' => 'required|min:20',
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'author_id' => 'required',
            'client_id' => 'required',
            'tags' => 'required',
            'tags.*' => 'min:3|max:15',
            'end_published_at' => 'required|date_format:"Y-m-d H:i:s"|after:published_at',
        ];

        if ($preview) {
            $validationRules['thumbnail'] = 'required';
        }

        if (!isset($inputs['editMode'])) {
            $validationRules['published_at'] = 'required|date_format:"Y-m-d H:i:s"|after:' . Carbon::now();
        }

        if (isset($inputs['editMode']) && $inputs['editMode']) {
            $articleLocale = ArticleLocale::find($inputs['articleLocaleId']);

            if ($articleLocale->status_by_locale == config('article.status_by_locale.schedule')) {
                $validationRules['published_at'] = 'required|date_format:"Y-m-d H:i:s"|after:' . Carbon::now();
            } else {
                $inputs['published_at'] = $articleLocale->published_at;
            }
        }

        $messages = [
            'published_at.date_format' => trans('admin/article.messages.published_date_format'),
            'end_published_at.date_format' => trans('admin/article.messages.end_published_date_format'),
            'published_at.required' => trans('admin/article.messages.published_date_required'),
            'end_published_at.required' => trans('admin/article.messages.end_published_date_required'),
            'end_published_at.after' => trans('admin/article.messages.end_published_date_after'),
            'locale_id.required' => trans('admin/article.messages.locale_required'),
            'author_id.required' => trans('admin/article.messages.author_required'),
            'category_id.required' => trans('admin/article.messages.category_required'),
            'sub_category_id.required' => trans('admin/article.messages.sub_category_required'),
        ];

        return Validator::make($inputs, $validationRules, $messages)
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
            if (isset($inputs['articleId']) && $inputs['articleId']) {
                if ($article = Article::find($inputs['articleId'])) {
                    $firstArticleLocale = $article->articleLocales->first();
                    $category = Category::where('locale_id', $inputs['locale_id'])
                        ->where('mapping', $article->category->mapping)->first();

                    $articleLocale = ArticleLocale::create([
                        'locale_id' => (int)$inputs['locale_id'],
                        'article_id' => $article->id,
                        'category_id' => $category->id,
                        'sub_category_id' => $firstArticleLocale->sub_category_id,
                        'title' => $inputs['title'],
                        'content' => $inputs['content'],
                        'summary' => $inputs['description'],
                        'published_at' => $inputs['published_at'] ? $inputs['published_at'] : Carbon::now(),
                        'end_published_at' => $inputs['end_published_at'] ? $inputs['end_published_at'] : null,
                        'content_type' => $inputs['switch_editor'] ?? null,
                        'title_bg_color' => $inputs['titleBgColor'] ?? null,
                        'is_member_only' => $firstArticleLocale->is_member_only,
                        'photo' => $inputs['thumbnail'] ?? null,
                        'hide' => $firstArticleLocale->hide,
                        'status' => $inputs['status'] ?? config('article.status.published'),
                    ]);

                    if ($articleLocale) {
                        //will be remove latter after changing tags construct
                        if (ArticleTagService::create($article, $articleLocale->id, $inputs['tags'] ?? [])) {
                            DB::commit();

                            return $article;
                        }
                    }

                    DB::rollback();

                    return false;
                }

                return false;
            }

            $articleData = [
                'user_id' => Auth::id(),
                'category_id' => $inputs['category_id'],
                'author_id' => $inputs['author_id'],
                'client_id' => $inputs['client_id'],
            ];

            if ($article = Article::create($articleData)) {
                $articleLocaleData = [
                    'locale_id' => (int)$inputs['locale_id'],
                    'article_id' => $article->id,
                    'category_id' => $inputs['category_id'],
                    'sub_category_id' => $inputs['sub_category_id'],
                    'title' => $inputs['title'],
                    'content' => $inputs['content'],
                    'summary' => $inputs['description'],
                    'published_at' => $inputs['published_at'] ? $inputs['published_at'] : Carbon::now(),
                    'end_published_at' => $inputs['end_published_at'] ? $inputs['end_published_at'] : null,
                    'content_type' => $inputs['switch_editor'] ?? null,
                    'title_bg_color' => $inputs['titleBgColor'] ?? null,
                    'is_member_only' => $inputs['is_member_only'],
                    'photo' => $inputs['thumbnail'] ?? null,
                    'hide' => $inputs['hide'],
                    'status' => $inputs['status'] ?? config('article.status.published'),
                ];

                if ($articleLocale = ArticleLocale::create($articleLocaleData)) {
                    if (ArticleTagService::create($article, $articleLocale->id, $inputs['tags'] ?? [])) {
                        DB::commit();

                        return $article;
                    }
                }
            }

            DB::rollback();

            return false;
        } catch (\Exception $e) {
            Log::debug($e);
            DB::rollback();

            return false;
        }
    }

    public static function update($inputs, $articleLocaleId)
    {
        if ($articleLocale = ArticleLocale::find($articleLocaleId)) {
            DB::beginTransaction();
            try {
                $articleData = [
                    'category_id' => $inputs['category_id'],
                    'author_id' => $inputs['author_id'],
                    'client_id' => $inputs['client_id'],
                ];
                if ($articleLocale->article->update($articleData)) {
                    $articleLocaleData = [
                        'locale_id' => (int)$inputs['locale_id'],
                        'category_id' => $inputs['category_id'],
                        'sub_category_id' => $inputs['sub_category_id'],
                        'title' => $inputs['title'],
                        'content' => $inputs['content'],
                        'summary' => $inputs['description'],
                        'end_published_at' => $inputs['end_published_at'] ? $inputs['end_published_at'] : null,
                        'content_type' => $inputs['switch_editor'] ?? null,
                        'title_bg_color' => $inputs['titleBgColor'] ?? null,
                        'is_member_only' => $inputs['is_member_only'],
                        'photo' => $inputs['thumbnail'] ?? null,
                        'status' => $inputs['status'] ?? config('article.status.published'),
                    ];

                    if ($articleLocale->status_by_locale == config('article.status_by_locale.schedule')) {
                        $articleLocaleData['published_at'] = $inputs['published_at'] ? $inputs['published_at'] : Carbon::now();
                    }

                    if (isset($inputs['hide'])) {
                        $articleLocaleData['hide'] = $inputs['hide'];
                    }

                    if ($articleLocale->update($articleLocaleData)) {
                        if (ArticleTagService::update($articleLocale->article, $inputs['articleLocaleId'], $inputs['tags'] ?? [])) {
                            DB::commit();

                            return $articleLocale;
                        }
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

        return false;
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
        $query = ArticleLocale::select(['id', 'title', 'locale_id', 'article_id', 'summary', 'published_at'])
            ->whereIn('article_id', function ($subQuery) use ($condition) {
                $subQuery->select('id')
                    ->from('articles')
                    ->where('id', 'like', '%' . $condition['key_word'] . '%');
            })
            ->where('published_at', '<=', Carbon::now())
            ->where('status', config('article.status.published'));

        if (!$condition['is_not_locale']) {
            $query = $query->where('locale_id', $condition['locale_id']);
        }

        return $query->paginate(config('banner.article_suggest'))->toArray();
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
            try {
                $dateFilter = Carbon::createFromFormat('Y M', $options['dateFilter']);
            } catch (Exception $e) {
                $dateFilter = Carbon::now();
            }

            $articles = $articles->where(function ($currentQuery) use ($dateFilter) {
                $currentQuery->whereIn(
                    'id',
                    ArticleLocale::whereMonth('published_at', $dateFilter->month)
                        ->whereYear('published_at', $dateFilter->year)
                        ->pluck('article_id')->toArray()
                );
            });
        }

        $orderBy = $options['sortBy'] ?? null;
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

        $limit = in_array($options['limit'], config('limitation.lists')) ? $options['limit'] : config('limitation.articles.default_per_page');

        $articles = $articles->paginate($limit);

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
            'end_date' => 'required|date|after_or_equal:start_date|after_or_equal:' . Carbon::today()->toDateString(),
            'article_locale_id' => 'required|exists:article_locales,id',
        ];

        $messages = [
            'end_date.after_or_equal' => trans('admin/article.always_on_top.validate.after_end_date'),
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

    public static function stopOrStart($articleLocaleId)
    {
        $articleLocale = ArticleLocale::find($articleLocaleId);

        if (!$articleLocale) {
            return false;
        }

        switch ($articleLocale->status_by_locale) {
            case config('article.status_by_locale.stop'):
                if ($articleLocale->published_at <= Carbon::now() &&
                    ($articleLocale->end_published_at >= Carbon::now() ||
                    is_null($articleLocale->end_published_at))) {
                    if ($articleLocale->update(['status' => config('article.status.published')])) {
                        return [
                            'type' => 'start',
                            'success' => true,
                            'status' => 'published',
                        ];
                    }

                    return [
                        'type' => 'start',
                        'success' => false,
                        'status' => '',
                    ];
                }

                return [
                    'type' => 'start',
                    'success' => false,
                    'status' => '',
                ];
            case config('article.status_by_locale.published'):
            case config('article.status_by_locale.schedule'):
                if ($articleLocale->update(['status' => config('article.status.stop')])) {
                    return [
                        'type' => 'stop',
                        'success' => true,
                        'status' => 'stop',
                    ];
                }

                return [
                    'type' => 'stop',
                    'success' => false,
                ];
            default:
                return false;
        }
    }

    public static function getAuthorOptions()
    {
        $authors = Author::orderBy('id', 'asc')->pluck('name', 'id')->toArray();

        return ['' => trans('admin/article.label.select_author')] + $authors;
    }

    public static function getLocaleOptions()
    {
        $locales = Locale::orderBy('id', 'asc')->pluck('name', 'id')->toArray();

        return ['' => trans('admin/article.label.select_locale')] + $locales;
    }

    public static function getClientOptions()
    {
        $clients = Client::orderBy('id', 'asc')->get();
        $result = [];

        foreach ($clients as $client) {
            $result[$client->id] = $client->id . ' - ' . $client->name;
        }

        return ['' => trans('admin/article.label.select_client')] + $result;
    }

    public static function notEditHideAttribute($articleLocale)
    {
        $topArticle = TopArticle::where('article_locale_id', $articleLocale->id)->first();
        $bannerArticle = BannerSetting::where('article_locale_id', $articleLocale->id)->first();
        $editorChoiceArticle = EditorChoice::where('article_id', $articleLocale->article_id)->first();

        return $topArticle || $bannerArticle || $editorChoiceArticle;
    }
}
