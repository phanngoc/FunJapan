<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\ArticleService;
use App\Services\Admin\ArticleLocaleService;
use App\Services\Admin\ArticleTagService;
use GrahamCampbell\Markdown\Facades\Markdown;
use App\Services\Admin\LocaleService;
use App\Services\Admin\CategoryLocaleService;
use App\Services\Admin\CategoryService;
use App\Models\Article;
use Gate;
use Illuminate\Support\Facades\Input;
use App\Models\Author;
use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Services\ImageService;

class ArticlesController extends Controller
{
    public function index(Request $request)
    {
        $searchColumns = [
            'id',
            'article_id',
            'client_id',
            'title',
            'published_at',
        ];

        $searchColumn = $request->input('searchColumn', 'client_id');

        $filter = [
            'limit' => $request->input('perPage', config('limitation.articles.default_per_page')),
            'keyword' => $request->input('keyword', ''),
            'sortBy' => $request->input('sortBy', 'id.desc'),
            'searchColumn' => in_array($searchColumn, $searchColumns) ? $searchColumn : 'client_id',
            'dateFilter' => $request->input('dateFilter', null),
            'searchColumns' => $searchColumns,
        ];

        $this->viewData['filter'] = $filter;
        $this->viewData['articles'] = ArticleService::listArticles($filter);
        $this->viewData['locales'] = LocaleService::getAllIsoCodeLocales();

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

    public function getCategoryLocale(Request $request)
    {
        $params = $request->input();

        $response = CategoryService::getCategoryLocaleDropList($params['locale_id']);

        return response()->json($response);
    }

    public function create()
    {
        $this->viewData['locales'] = LocaleService::getLocaleSort();
        $this->viewData['authors'] = Author::get()->pluck('name', 'id')->toArray();
        $this->viewData['clients'] = Client::get()->pluck('name', 'id')->toArray();
        $this->viewData['subCategories'] = CategoryService::getSubCategories();

        return view('admin.article.create', $this->viewData);
    }

    public function validateInput(Request $request)
    {
        $input = $request->input();
        $input['content'] = $input['switch_editor'] == config('article.content_type.medium') ?
            $input['contentMedium'] : $input['contentMarkdown'];
        $input['published_at'] = $input['publish_date'] ?
            ($input['publish_time'] ? $input['publish_date'] . ' ' . $input['publish_time'] . ':00' :
            $input['publish_date'] . ' 00:00:00') : '';
        $input['end_published_at'] = $input['end_publish_date'] ?
            ($input['end_publish_time'] ? $input['end_publish_date'] . ' ' . $input['end_publish_time'] . ':00' :
            $input['end_publish_date'] . ' 00:00:00') : '';

        $validator = ArticleService::validate($input);

        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => $validator->errors(),
            ];
        }

        return [
            'success' => true,
            'message' => '',
        ];
    }

    public function preview(Request $request)
    {
        $input = $request->input();

        if (isset($input['saveDraft']) && $input['saveDraft'] == 'true') {
            $input['status'] = config('article.status.draft');

            return self::save($input);
        }

        $this->viewData['input'] = $input;
        $this->viewData['images'] = $input['switch_editor'] == config('article.content_type.medium') ?
            ImageService::getImageFromHtml($input['contentMedium']) :
            ImageService::getImageFromMarkdown($input['contentMarkdown']);
        $this->viewData['content'] = $input['switch_editor'] == config('article.content_type.medium') ?
            $input['contentMedium'] :
            Markdown::convertToHtml($input['contentMarkdown']);
        $this->viewData['category'] = Category::find($input['category_id']);
        $this->viewData['author'] = Author::find($input['author_id']);

        return view('admin.article.preview', $this->viewData);
    }

    public function confirm(Request $request)
    {
        $input = $request->all();

        $this->viewData['input'] = $input;
        $this->viewData['subCategories'] = CategoryService::getSubCategories();
        $this->viewData['authors'] = Author::get()->pluck('name', 'id')->toArray();
        $this->viewData['clients'] = Client::get()->pluck('name', 'id')->toArray();
        $this->viewData['locales'] = LocaleService::getLocaleSort();
        $this->viewData['categories'] = CategoryService::getCategoryLocaleDropList($input['locale_id']);

        return view('admin.article.confirm', $this->viewData);
    }

    public function cancelConfirm(Request $request)
    {
        $input = $request->input();

        return redirect()->action('Admin\ArticlesController@create')
            ->withInput($input);
    }

    public function uploadImage(Request $request)
    {
        $input = $request->all();

        $fileName = ImageService::uploadFile(
            $input['files'][0],
            'article_content',
            config('images.paths.article_content')
        );

        return [
            'files' => [
                [
                    'url' => ImageService::imageUrl(config('images.paths.article_content') . '/' . $fileName),
                    'imagePath' => config('images.paths.article_content') . '/' . $fileName,
                ],
            ],
        ];
    }

    public function deleteImage(Request $request)
    {
        $input = $request->all();
        $imgUrl = explode('/', $input['file']);
        $image = array_values(array_slice($imgUrl, -1))[0];
        ImageService::delete(config('images.paths.article_content'), $image);

        return [
            'success' => true,
        ];
    }

    public function store(Request $request)
    {
        $input = $request->all();

        return self::save($input);
    }

    private function save($input)
    {
        $input['content'] = ($input['switch_editor'] == config('article.content_type.medium')) ?
            $input['contentMedium'] : $input['contentMarkdown'];
        $input['published_at'] = $input['publish_date'] ?
            ($input['publish_time'] ? $input['publish_date'] . ' ' . $input['publish_time'] . ':00' :
            $input['publish_date'] . ' 00:00:00') : '';
        $input['end_published_at'] = $input['end_publish_date'] ?
            ($input['end_publish_time'] ? $input['end_publish_date'] . ' ' . $input['end_publish_time'] . ':00' :
            $input['end_publish_date'] . ' 00:00:00') : '';

        if (isset($input['thumbnail']) && $input['thumbnail']) {
            $fileName = explode('/', $input['thumbnail']);
            $input['thumbnail'] = array_values(array_slice($fileName, -1))[0];
        }

        $validator = ArticleService::validate($input);

        if ($validator->fails()) {
            return redirect()->action('Admin\ArticlesController@index')
                ->withErrors(['errors' => trans('admin/article.create_error')]);
        }

        if ($article = ArticleService::create($input)) {
            return redirect()->action('Admin\ArticlesController@show', [$article->id, 'locale' => $input['locale_id']])
                ->with(['message' => trans('admin/article.create_success')]);
        }

        return redirect()->action('Admin\ArticlesController@index')
            ->withErrors(['errors' => trans('admin/article.create_error')]);
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
            $this->viewData['categories'] = CategoryService::getCategoryLocaleDropList($localeId);
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

    public function setOtherLanguage(Request $request, Article $article)
    {
        $existLanguages = [];
        foreach ($article->articleLocales as $key => $value) {
            $existLanguages[] = $value->locale->name;
        }
        $locales = array_diff(LocaleService::getAllLocales(), $existLanguages);

        $this->viewData['locales'] = $locales;
        $localeId = key($locales);
        if (old('locale')) {
            $localeId = old('locale');
        }
        $this->viewData['categories'] = CategoryService::getCategoryLocaleDropList($localeId);

        $this->viewData['article'] = $article;
        $this->viewData['tags'] = [];
        if ($request->input('clone')) {
            $this->viewData['cloneInputs'] = $article->articleLocales->first();
            $tagLocales = $article->articleTags->where('article_locale_id', $article->articleLocales->first()->id);
            foreach ($tagLocales as $tagLocale) {
                $this->viewData['tags'][$tagLocale->tag->name] = $tagLocale->tag->name;
            }
        } else {
            $this->viewData['cloneInputs'] = null;
        }

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

    public function alwaysOnTop()
    {
        abort_if(Gate::denies('permission', 'article.edit'), 403, 'Unauthorized action.');

        $currentLocale = Input::get('locale_id');
        $isSuccess = Input::get('isSuccess');
        $isDeleted = Input::get('isDeleted');

        $this->viewData['locales'] = LocaleService::getAllLocales();
        $this->viewData['currentLocale'] = array_key_exists($currentLocale, $this->viewData['locales']) ? $currentLocale : key($this->viewData['locales']) ;
        $this->viewData['tops'] = ArticleService::getArticleAlwayOnTop();

        if ($isSuccess) {
            session()->flash('message', trans('admin/article.always_on_top.label_update_success'));
        }

        if ($isDeleted) {
            session()->flash('message', trans('admin/article.always_on_top.label_delete_success'));
        }

        return view('admin.article.always_on_top', $this->viewData);
    }

    public function setAlwaysOnTop(Request $request)
    {
        abort_if(Gate::denies('permission', 'article.edit'), 403, 'Unauthorized action.');

        $input = $request->only([
            'article_locale_id',
            'locale_id',
            'start_date',
            'end_date',
        ]);

        $validate = ArticleService::validateSetAlwaysOnTop($input);
        if (count($validate)) {
            return response()->json(['message' => $validate], 400);
        }

        $isSuccess = ArticleService::setAlwaysOnTop($input);
        if ($isSuccess) {
            return response()->json(['isSuccess' => $isSuccess]);
        }

        return response()->json(
            [
                'message' => ['article_locale_id' => [trans('admin/banner.validate.article_banner')]],
            ],
            400
        );
    }

    public function deleteAlwaysOnTop($topArticleId)
    {
        abort_if(Gate::denies('permission', 'article.edit'), 403, 'Unauthorized action.');

        if (!auth()->check()) {
            return response()->json(['message' => trans('admin/banner.validate.unauthorized')], 401);
        }

        $isSuccess = ArticleService::deleteAlwaysOnTop($topArticleId);

        if ($isSuccess) {
            return response()->json(['success' => true]);
        }

        return response()->json(
            [
                'message' => 'Something went wrong',
            ],
            400
        );
    }

    public function stop(Request $request)
    {
        $articleId = $request->get('articleId');
        if (ArticleService::stop($articleId)) {
            return [
                'success' => true,
                'message' => trans('admin/article.messages.stop_success'),
            ];
        }

        return [
            'success' => false,
            'message' => trans('admin/article.messages.stop_error'),
        ];
    }
}
