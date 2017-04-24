<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\Controller;
use App\Services\Web\CommentService;
use App\Services\Web\ArticleService;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentsController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function lists($articleId, Request $request)
    {
        $commentsWithPaginator = CommentService::getCommentsListWithPaginator(
            $articleId,
            $this->currentLocaleId,
            config('limitation.comment.per_page')
        );

        return [
            'success' => true,
            'message' => '',
            'htmlItems' => $commentsWithPaginator['htmlComments'],
            'htmlPaginator' => $commentsWithPaginator['htmlPaginator'],
        ];
    }

    public function store(Request $request)
    {
        $input = $request->only(
            'content',
            'articleId',
            'type',
            'parentId'
        );

        if (!auth()->check()) {
            return [
                'success' => false,
                'message' => [trans('web/comment.messages.no_permission')],
            ];
        }

        $articleLocale = ArticleService::getArticleLocaleDetails($input['articleId'], $this->currentLocaleId);
        $comment = Comment::where('user_id', auth()->id())
            ->where('article_locale_id', $articleLocale->id)
            ->whereNull('parent_id')
            ->first();

        if ($comment && !$input['parentId']) {
            return [
                'success' => false,
                'message' => [trans('web/comment.messages.only_once')],
            ];
        }

        if (!$articleLocale) {
            return [
                'success' => false,
                'message' => [trans('web/comment.messages.not_found')],
            ];
        }

        $input['userId'] = auth()->id();
        $input['articleLocaleId'] = $articleLocale->id;

        $validate = CommentService::validate($input);

        if ($validate->fails()) {
            return [
                'success' => false,
                'message' => $validate->errors(),
            ];
        }

        if ($comment = CommentService::create($input)) {
            $htmlComments = '';
            $htmlPaginator = '';

            if ($comment->parent_id) {
                $htmlComments = View::make('web.comments._single_comment')
                    ->with('comment', $comment)
                    ->render();
            } else {
                $commentsWithPaginator = CommentService::getCommentsListWithPaginator(
                    $input['articleId'],
                    $this->currentLocaleId,
                    config('limitation.comment.per_page')
                );

                $htmlComments = $commentsWithPaginator['htmlComments'];
                $htmlPaginator = $commentsWithPaginator['htmlPaginator'];
            }

            $total = $comment->parent_id ? $comment->parent->children->count() :
                $comment->articleLocale->comment_count;

            return [
                'success' => true,
                'message' => '',
                'total' => $total,
                'htmlComments' => $htmlComments,
                'htmlPaginator' => $htmlPaginator,
            ];
        }

        return [
            'success' => false,
            'message' => [trans('web/comment.messages.create_error')],
        ];
    }

    public function destroy($id)
    {
        $comment = Comment::find($id);

        if ($comment && $comment->canBeDeleted() && $comment->delete()) {
            $commentsWithPaginator = CommentService::getCommentsListWithPaginator(
                $comment->article_id,
                $this->currentLocaleId,
                config('limitation.comment.per_page')
            );

            return [
                'success' => true,
                'message' => trans('web/comment.messages.delete_success'),
                'total' => $comment->articleLocale->comment_count,
                'htmlComments' => $commentsWithPaginator['htmlComments'],
                'htmlPaginator' => $commentsWithPaginator['htmlPaginator'],
            ];
        }

        return [
            'success' => false,
            'message' => trans('web/comment.messages.no_permission'),
        ];
    }

    public function getEmoji()
    {
        return View::make('web.comments._popup_emoticon')
            ->render();
    }

    public function getGif()
    {
        return View::make('web.comments._popup_gif')
            ->render();
    }

    public function favorite($commentId)
    {
        if (!auth()->check()) {
            return [
                'success' => false,
                'message' => trans('web/comment.messages.no_permission'),
            ];
        }

        if (CommentService::favorite($commentId, auth()->id())) {
            return [
                'success' => true,
                'message' => '',
            ];
        }

        return [
            'success' => false,
            'message' => trans('web/comment.messages.like_error'),
        ];
    }
}
