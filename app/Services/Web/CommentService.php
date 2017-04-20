<?php

namespace App\Services\Web;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;
use App\Models\FavoriteComment;
use App\Models\ArticleLocale;
use App\Models\Comment;
use Exception;
use DB;

class CommentService
{
    public static function validate($input)
    {
        return Validator::make($input, [
            'content' => 'required',
            'type' => 'in:' . implode(',', array_values(config('comment.type'))),
            'articleId' => 'required',
        ]);
    }

    public static function create($input)
    {
        return Comment::create([
            'type' => $input['type'],
            'content' => strip_tags($input['content']),
            'parent_id' => $input['parentId'],
            'article_id' => $input['articleId'],
            'article_locale_id' => $input['articleLocaleId'],
            'user_id' => $input['userId'],
        ]);
    }

    public static function lists($articleLocaleId, $limit = 10)
    {
        return Comment::where('article_locale_id', $articleLocaleId)
            ->with('children', 'children.user', 'user', 'favoriteComments')
            ->whereNull('parent_id')
            ->orderBy('created_at', 'desc')
            ->paginate($limit);
    }

    public static function getCommentsListWithPaginator($articleLocaleId, $articleId, $limit = 10)
    {
        $comments = self::lists($articleLocaleId, $limit);

        $htmlComments = View::make('web.comments._list_comments')
            ->with('comments', $comments)
            ->with('articleId', $articleId)
            ->with('articleLocaleId', $articleLocaleId)
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
