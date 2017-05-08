<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ArticleLocale;
use App\Services\Admin\LocaleService;
use App\Services\Admin\ArticleLocaleService;
use Illuminate\Support\Facades\View;
use Validator;

class RecommendedArticlesController extends Controller
{
    public function index(Request $request)
    {
        $input = $request->only('locale_id');
        $locales = LocaleService::getAllLocales();
        reset($locales);
        $input['default_locale_id'] = key($locales);

        $this->viewData['input'] = $input;
        $this->viewData['locales'] = $locales;

        return view('admin.recommend_articles.index', $this->viewData);
    }

    public function recommendedLists(Request $request)
    {
        $input = $request->only('locale_id');
        $locales = LocaleService::getAllLocales();
        reset($locales);
        $input['default_locale_id'] = key($locales);

        $this->viewData['input'] = $input;
        $this->viewData['locales'] = $locales;

        return view('admin.recommend_articles.show', $this->viewData);
    }

    public function lists(Request $request)
    {
        $params = $request->input();
        $draw = $params['draw'];
        $params['recommended'] = true;
        $articlesData = ArticleLocaleService::list($params);
        $articlesData['draw'] = (int)$draw;

        return $articlesData;
    }

    public function store(Request $request)
    {
        //check login and permission (latter)
        if (!auth()->check()) {
            return [
                'success' => false,
                'message' => trans('admin/recommend_article.messages.not_permission'),
            ];
        }

        $articleLocaleId = $request->get('articleLocaleId');
        $articleLocale = ArticleLocale::find($articleLocaleId);

        if (!$articleLocale) {
            return [
                'success' => false,
                'message' => trans('admin/recommend_article.messages.not_found'),
            ];
        }

        if (!$articleLocale->recommended && config('limitation.recommended_article.limit') > 0) {
            $recommendedArticlesCount = ArticleLocale::with('article')
                ->where('recommended', true)
                ->where('locale_id', $articleLocale->locale_id)
                ->count();

            if ($recommendedArticlesCount >= config('limitation.recommended_article.limit')) {
                return [
                    'success' => false,
                    'message' => trans('admin/recommend_article.messages.max_setting'),
                ];
            }
        }

        $updated = $articleLocale->update([
            'recommended' => $articleLocale->recommended ? false : true,
        ]);

        return [
            'success' => $updated,
            'message' => $updated ? trans('admin/recommend_article.messages.success') : trans('admin/recommend_article.messages.fail'),
            'recommended' => $articleLocale->recommended,
        ];
    }

    public function destroy($id)
    {
        //check login and permission (latter)
        if (!auth()->check()) {
            return [
                'success' => false,
                'message' => trans('admin/recommend_article.messages.not_permission'),
            ];
        }

        $articlesLocale = ArticleLocale::find($id);

        if (!$articlesLocale || !$articlesLocale->recommended) {
            return [
                'success' => false,
                'message' => trans('admin/recommend_article.messages.not_found'),
            ];
        }

        $updated = $articlesLocale->update([
            'recommended' => false,
        ]);

        return [
            'success' => $updated,
            'message' => $updated ? trans('admin/recommend_article.messages.success') : trans('admin/recommend_article.messages.fail'),
        ];
    }
}
