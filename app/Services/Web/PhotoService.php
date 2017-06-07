<?php

namespace App\Services\Web;

use Illuminate\Support\Facades\Log;
use App\Models\FavoritePhoto;
use App\Models\PostPhoto;
use DB;

class PhotoService
{
    public static function favorite($photoId, $userId)
    {
        if (is_null($userId)) {
            return false;
        }

        $photo = PostPhoto::find($photoId);

        if (!$photo) {
            return false;
        }

        $favorite = FavoritePhoto::where('post_photo_id', $photoId)
            ->where('user_id', $userId)
            ->first();

        DB::beginTransaction();

        try {
            if ($favorite) {
                $favorite->forceDelete();
                $photo->decrement('favorite_count');
            } else {
                FavoritePhoto::create([
                    'user_id' => $userId,
                    'post_photo_id' => $photoId,
                ]);

                $photo->increment('favorite_count');
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
