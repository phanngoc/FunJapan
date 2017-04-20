<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\Controller;
use App\Services\Web\CommentService;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentsController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function lists($articleId, $articleLocaleId, Request $request)
    {
        $commentsWithPaginator = CommentService::getCommentsListWithPaginator(
            $articleLocaleId,
            $articleId,
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
            'articleLocaleId',
            'type',
            'parentId'
        );

        if (!auth()->check()) {
            return [
                'success' => false,
                'message' => trans('web/comment.messages.no_permission'),
            ];
        }

        $input['userId'] = auth()->id();

        $validate = CommentService::validate($input);

        if ($validate->fails()) {
            return [
                'success' => false,
                'message' => implode(' ', $validate->errors()->messages()['content']),
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
                    $input['articleLocaleId'],
                    $input['articleId'],
                    config('limitation.comment.per_page')
                );

                $htmlComments = $commentsWithPaginator['htmlComments'];
                $htmlPaginator = $commentsWithPaginator['htmlPaginator'];
            }

            return [
                'success' => true,
                'message' => '',
                'total' => $comment->articleLocale->comment_count,
                'htmlComments' => $htmlComments,
                'htmlPaginator' => $htmlPaginator,
            ];
        }

        return [
            'success' => false,
            'message' => trans('web/comment.messages.create_error'),
        ];
    }

    public function destroy($id)
    {
        $comment = Comment::find($id);

        if ($comment && $comment->canBeDeleted() && $comment->delete()) {
            $commentsWithPaginator = CommentService::getCommentsListWithPaginator(
                $comment->article_locale_id,
                $comment->article_id,
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
