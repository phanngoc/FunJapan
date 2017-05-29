<?php

namespace App\Http\Controllers\Web;

use App\Services\Web\ArticleService;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Models\PostPhoto;
use App\Services\Web\PhotoService;

class ArticlePhotosController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function store($articleId, Request $request)
    {
        $input = $request->all();
        $articleLocale = ArticleService::getArticleLocaleDetails($articleId, $this->currentLocaleId);
        $input['articleLocale'] = $articleLocale;
        $input['userId'] = auth()->id();

        if (!$articleLocale) {
            return [
                'success' => false,
                'message' => [trans('web/post_photo.messages.not_found')],
            ];
        }

        // will be used latter
        // $postPhoto = PostPhoto::where('article_locale_id', $articleLocale->id)
        //     ->where('user_id', auth()->id())
        //     ->first();

        // if ($postPhoto) {
        //     return [
        //         'success' => false,
        //         'message' => [trans('web/post_photo.messages.only_once')],
        //     ];
        // }

        if (!auth()->check() || $articleLocale->article->type != config('article.type.photo')) {
            return [
                'success' => false,
                'message' => [trans('web/post_photo.messages.no_permission')],
            ];
        }

        $validate = ArticleService::validatePostPhoto($input);

        if ($validate->fails()) {
            return [
                'success' => false,
                'message' => $validate->errors(),
            ];
        }

        $input['status'] = $articleLocale->article->auto_approve_photo ?
            config('post_photo.status.approved') :
            config('post_photo.status.waiting');

        if ($postPhoto = ArticleService::postPhoto($input)) {
            $html = '';

            if ($articleLocale->article->auto_approve_photo) {
                $postPhotos = ArticleService::getPostPhotosList(
                    $articleId,
                    $this->currentLocaleId,
                    null,
                    PostPhoto::ORDER_BY_CREATED_DESC,
                    config('limitation.post_photo.per_page')
                );

                $html = View::make('web.articles._list_post_photos')
                    ->with('postPhotos', $postPhotos)
                    ->render();
            }

            return [
                'success' => true,
                'message' => [trans('web/post_photo.messages.upload_success')],
                'html' => $html,
                'postPhotos' => isset($postPhotos) ? $postPhotos : '',
            ];
        }
    }

    public function lists($articleId, $orderBy, Request $request)
    {
        $searchCondition['user_name'] = $request->get('keywords', null);

        $postPhotos = ArticleService::getPostPhotosList(
            $articleId,
            $this->currentLocaleId,
            $searchCondition,
            $orderBy,
            config('limitation.post_photo.per_page')
        );

        $html = View::make('web.articles._list_post_photos')
            ->with('postPhotos', $postPhotos)
            ->render();

        return [
            'success' => true,
            'message' => [],
            'html' => $html,
            'postPhotos' => $postPhotos,
        ];
    }

    public function favorite($photoId)
    {
        if (!auth()->check()) {
            return [
                'success' => false,
                'message' => trans('web/articles.messages.no_permission'),
            ];
        }

        if (PhotoService::favorite($photoId, auth()->id())) {
            return [
                'success' => true,
                'message' => '',
            ];
        }

        return [
            'success' => false,
            'message' => trans('web/articles.messages.like_error'),
        ];
    }
}
