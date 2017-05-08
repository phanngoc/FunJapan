<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\ArticleService;
use App\Services\Admin\ArticleLocaleService;
use App\Services\Admin\ArticleTagService;
use App\Services\Admin\LocaleService;
use App\Services\Admin\CategoryLocaleService;
use App\Services\Admin\CategoryService;
use App\Models\Article;
use App\Models\ArticleTag;
use Carbon\Carbon;

class ArticlesController extends Controller
{
    public function index()
    {
        $this->viewData['locales'] = json_encode(LocaleService::getAllLocales());

        return view('admin.article.index', $this->viewData);
    }

    public function show(Request $request, Article $article)
    {
        $this->viewData['tab'] = $request->input('locale');

        $this->viewData['article'] = $article;
        $this->viewData['locales'] = LocaleService::getAllLocales();
        $this->viewData['types'] = ArticleService::getArticleTypes();

        return view('admin.article.detail', $this->viewData);
    }

    public function getListArticles(Request $request)
    {
        $params = $request->input();
        $draw = $params['draw'];
        $articlesData = ArticleLocaleService::list($params);
        $articlesData['draw'] = (int)$draw;

        return $articlesData;
    }

    public function create()
    {
        $this->viewData['locales'] = LocaleService::getAllLocales();
        $this->viewData['categories'] = CategoryService::getAllCategories();
        $this->viewData['types'] = ArticleService::getArticleTypes();

        return view('admin.article.create', $this->viewData);
    }

    public function store(Request $request)
    {
        $inputs = $request->all();

        $inputs['auto_approve_photo'] = isset($inputs['auto_approve_photo']) && $inputs['auto_approve_photo'] ?
            $inputs['auto_approve_photo'] : false;

        $inputs['summary'] = str_replace(["\r\n", "\n\r"], "\n", $inputs['summary']);

        $validator = ArticleService::validate($inputs);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($inputs);
        }

        if ($article = ArticleService::create($inputs)) {
            return redirect()->action('Admin\ArticlesController@show', [$article->id, 'locale' => $inputs['locale']])
                ->with(['message' => trans('admin/article.create_success')]);
        }

        return redirect()->back()->withErrors(['errors' => trans('admin/article.create_error')]);
    }

    public function edit(Request $request, Article $article)
    {
        $locales = LocaleService::getAllLocales();
        if (($localeId = (int)$request->input('locale'))
            && count($article->articleLocales->where('locale_id', (int)$request->input('locale'))) > 0 ) {
            $this->viewData['localeId'] = $localeId;
            $this->viewData['article'] = $article;
            $articleLocale = $article->articleLocales->where('locale_id', $localeId)->first();
            $this->viewData['articleLocale'] = $articleLocale;
            $this->viewData['categories'] = CategoryService::getAllCategories();
            $tagLocales = $article->articleTags->where('article_locale_id', $articleLocale->id);
            $this->viewData['tags'] = [];
            foreach ($tagLocales as $tagLocale) {
                $this->viewData['tags'][$tagLocale->tag->name] = $tagLocale->tag->name;
            }

            return view('admin.article.edit', $this->viewData);
        }

        return redirect()->action('Admin\ArticlesController@show', [$article->id])
            ->withErrors(['errors' => trans('admin/article.locale_not_exist')]);
    }

    public function update(Request $request, Article $article)
    {
        $inputs = $request->all();

        $inputs['summary'] = str_replace(["\r\n", "\n\r"], "\n", $inputs['summary']);

        $validator = ArticleService::validate($inputs, $article);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($inputs);
        }

        if (ArticleService::update($article, $inputs)) {
            return redirect()->action('Admin\ArticlesController@show', [$article->id, 'locale' => $inputs['locale']])
                ->with(['message' => trans('admin/article.update_success')]);
        }

        return redirect()->back()->withErrors(['errors' => trans('admin/article.update_error')]);
    }

    public function setOtherLanguage(Article $article)
    {
        $existLanguages = [];
        foreach ($article->articleLocales as $key => $value) {
            $existLanguages[] = $value->locale->name;
        }
        $this->viewData['locales'] = array_diff(LocaleService::getAllLocales(), $existLanguages);
        $this->viewData['article'] = $article;

        return view('admin.article.set_other_language', $this->viewData);
    }

    public function updateOtherLanguage(Request $request, Article $article)
    {
        $inputs = $request->all();

        $inputs['summary'] = str_replace(["\r\n", "\n\r"], "\n", $inputs['summary']);

        $validator = ArticleService::validate($inputs);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($inputs);
        }

        if ($articleLocale = ArticleLocaleService::createArticleOtherLanguage($article, $inputs)) {
            return redirect()->action('Admin\ArticlesController@show', [$article->id, 'locale' => $inputs['locale']])
                ->with(['message' => trans('admin/article.add_success')]);
        }

        return redirect()->back()->withErrors(['errors' => trans('admin/article.add_error')]);
    }

    public function editGlobalInfo(Request $request, Article $article)
    {
        $this->viewData['article'] = $article;
        $this->viewData['categories'] = CategoryService::getAllCategories();
        $this->viewData['types'] = ArticleService::getArticleTypes();
        $this->viewData['localeId'] = $request->get('locale');

        return view('admin.article.edit_global', $this->viewData);
    }

    public function updateGlobalInfo(Request $request, Article $article)
    {
        $inputs = $request->all();
        $inputs['auto_approve_photo'] = isset($inputs['auto_approve_photo']) && $inputs['auto_approve_photo'] ?
            $inputs['auto_approve_photo'] : false;

        $validator = ArticleService::validateGlobal($inputs);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($inputs);
        }

        if ($article->update($inputs)) {
            return redirect()->action('Admin\ArticlesController@show', [$article->id, 'locale' => $inputs['locale']])
                ->with(['message' => trans('admin/article.update_success')]);
        }

        return redirect()->back()->withErrors(['errors' => trans('admin/article.add_error')]);
    }
}
