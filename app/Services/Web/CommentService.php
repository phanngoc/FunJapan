<?php

namespace App\Services\Web;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;
use App\Models\FavoriteComment;
use App\Models\ArticleLocale;
use App\Models\Comment;
use App\Services\Web\ArticleService;
use Exception;
use DB;
use App\Services\NotificationService;

class CommentService
{
    public static function validate($input)
    {
        return Validator::make($input, [
            'content' => 'required|max:255',
            'type' => 'in:' . implode(',', array_values(config('comment.type'))),
            'articleId' => 'required',
        ]);
    }

    public static function create($input)
    {
        $comment = Comment::create([
            'type' => $input['type'],
            'content' => $input['content'],
            'parent_id' => $input['parentId'],
            'article_id' => $input['articleId'],
            'article_locale_id' => $input['articleLocaleId'],
            'user_id' => $input['userId'],
        ]);

        try {
            if ($comment && $comment->parent_id) {
                $parentComment = Comment::find($comment->parent_id);

                if ($parentComment && $parentComment->user_id != $input['userId']) {
                    NotificationService::sendNotification(
                        $input['userId'],
                        $input['localeId'],
                        config('notification.type.reply_comment'),
                        $parentComment
                    );
                }
            }
        } catch (Exception $e) {
            Log::debug($e);
        }

        return $comment;
    }

    public static function lists($articleLocaleId, $limit = 10)
    {
        return Comment::where('article_locale_id', $articleLocaleId)
            ->with('children', 'children.user', 'user', 'favoriteComments')
            ->whereNull('parent_id')
            ->orderBy('created_at', 'desc')
            ->paginate($limit);
    }

    public static function getCommentsListWithPaginator($articleId, $localeId, $limit = 10)
    {
        $articleLocale = ArticleService::getArticleLocaleDetails($articleId, $localeId);
        $comments = self::lists($articleLocale->id, $limit);

        $htmlComments = View::make('web.comments._list_comments')
            ->with('comments', $comments)
            ->render();

        $htmlPaginator = View::make('web.comments._pagination')
            ->with('paginator', $comments)
            ->render();

        return [
            'htmlComments' => $htmlComments,
            'htmlPaginator' => $htmlPaginator,
        ];
    }

    public static function favorite($commentId, $userId)
    {
        if (is_null($userId)) {
            return false;
        }

        $comment = Comment::find($commentId);

        if (!$comment) {
            return false;
        }

        $favorite = FavoriteComment::where('comment_id', $commentId)
            ->where('user_id', $userId)
            ->first();

        DB::beginTransaction();

        try {
            if ($favorite) {
                $favorite->delete();
                $comment->decrement('favorite_count');
            } else {
                FavoriteComment::create([
                    'user_id' => $userId,
                    'comment_id' => $commentId,
                ]);

                $comment->increment('favorite_count');

                if ($comment->user_id != $userId) {
                    NotificationService::sendNotification(
                        $userId,
                        $comment->articleLocale->locale_id,
                        config('notification.type.like_comment'),
                        $comment
                    );
                }
            }

            DB::commit();

            return true;
        } catch (Exception $e) {
            Log::debug($e);
            DB::rollback();

            return false;
        }
    }
}
