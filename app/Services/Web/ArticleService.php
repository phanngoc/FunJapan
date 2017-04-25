<?php

namespace App\Services\Web;

use App\Models\Article;
use Illuminate\Support\Facades\Validator;
use App\Services\ImageService;
use App\Models\ArticleLocale;
use App\Models\FavoriteArticle;
use App\Services\Web\LocaleService;
use Illuminate\Support\Facades\App;
use Carbon\Carbon;
use App\Models\PostPhoto;
use DB;

class ArticleService
{
    public static function getArticleLocaleDetails($id, $localeId)
    {
        return ArticleLocale::where('article_id', $id)
            ->where('locale_id', $localeId)
            ->whereNotNull('published_at')
            ->where('published_at', '<', Carbon::now())
            ->first();
    }

    public static function getFavoriteArticleDetails($userId, $articleId, $articleLocaleId)
    {
        return FavoriteArticle::where('user_id', $userId)
            ->where('article_id', $articleId)
            ->where('article_locale_id', $articleLocaleId)
            ->first();
    }

    public static function countLike($userId, $articleId, $localeId)
    {
        $articleLocale = ArticleService::getArticleLocaleDetails($articleId, $localeId);
        $favorite = ArticleService::getFavoriteArticleDetails($userId, $articleId, $articleLocale->id);
        if ($favorite == null) {
            $data = [
                'user_id' => $userId,
                'article_id' => $articleId,
                'article_locale_id' => $articleLocale->id,
            ];
            FavoriteArticle::create($data);
            $articleLocale->increment('like_count');
        } else {
            $favorite->delete();
            $articleLocale->decrement('like_count');
        }

        return response()->json([
            'count' => $articleLocale->like_count,
            'check' => !$favorite ? true : false,
        ]);
    }

    public static function getNextArticleId($id, $publishedAt, $localeId)
    {
        $article = DB::table('articles as a')
            ->join('article_locales as al', 'a.id', '=', 'al.article_id')
            ->where('al.locale_id', $localeId)
            ->where('a.id', '<', $id)
            ->where('al.published_at', '<', Carbon::now())
            ->orderBy('al.published_at', 'desc')
            ->orderBy('a.is_top_article', 'desc')
            ->first();

        return $article->article_id ?? 0;
    }

    public static function getArticleDetail($id, $localeId)
    {
        $article = Article::find($id);
        if (!$article) {
            return false;
        }

        $article->locale = self::getArticleLocaleDetails($id, $localeId);
        if (!$article->locale) {
            return false;
        }

        $relates = $article->getRelateArticle();
        $relateArticle = [];

        foreach ($relates as $relateType) {
            if (count($relateType)) {
                foreach ($relateType as $articleRelate) {
                    $articleRelate['locale'] = self::getArticleLocaleDetails($articleRelate['id'], $localeId);
                    $relateArticle[] = $articleRelate;
                }
            }
        }

        $article->relateArticle = $relateArticle;

        return $article;
    }

    public static function validatePostPhoto($input)
    {
        $mimes = config('images.validate.post_photo.mimes');
        $maxSize = config('images.validate.post_photo.max_size');

        return Validator::make($input, [
            'description' => 'required|max:100',
            'file' => 'required|mimes:' . $mimes . '|max:' . $maxSize,
        ]);
    }

    public static function postPhoto($data)
    {
        $photoUploadPath = config('images.paths.post_photo') . '/' . $data['articleLocale']->id . '/' . $data['userId'];
        $photo = ImageService::uploadFile($data['file'], 'post_photo', $photoUploadPath);

        if ($photo) {
            return PostPhoto::create([
                'article_id' => $data['articleLocale']->article_id,
                'article_locale_id' => $data['articleLocale']->id,
                'photo' => $photo,
                'content' => strip_tags($data['description']),
                'user_id' => $data['userId'],
            ]);
        }

        return false;
    }

    public static function getPostPhotosList($articleId, $localeId, $searchCondition = null, $orderBy = null, $limit = 10)
    {
        $articleLocale = self::getArticleLocaleDetails($articleId, $localeId);
        $postPhotos = PostPhoto::with('user')
            // ->where('status', config('post_photo.status.approved')) //will be used latter
            ->where('article_locale_id', $articleLocale->id);

        if ($searchCondition) {
            $postPhotos = $postPhotos->whereHas('user', function ($query) use ($searchCondition) {
                $query->where('name', 'like', '%' . $searchCondition['user_name'] . '%');
            });
        }

        switch ($orderBy) {
            case PostPhoto::ORDER_BY_CREATED_DESC:
                $postPhotos = $postPhotos->orderBy('created_at', 'desc');
                break;
            case PostPhoto::ORDER_BY_CREATED_ASC:
                $postPhotos = $postPhotos->orderBy('created_at', 'asc');
                break;
            case PostPhoto::ORDER_BY_MOST_POPULAR:
                //TO DO
                break;

            default:
                $postPhotos = $postPhotos->orderBy('created_at', 'desc');
                break;
        }

        return $postPhotos->paginate($limit);
    }
}
