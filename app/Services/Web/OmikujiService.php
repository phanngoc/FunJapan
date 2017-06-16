<?php

namespace App\Services\Web;

use Illuminate\Support\Facades\App;
use Carbon\Carbon;
use wataridori\BiasRandom\BiasRandom;
use App\Models\OmikujiUser;
use App\Models\Omikuji;
use App\Models\OmikujiItem;
use Illuminate\Support\Facades\Log;
use DB;

class OmikujiService
{
    public static function create($inputs, $point)
    {
        DB::beginTransaction();
        try {
            $omikujiId = $inputs['omikujiId'];
            $omikuji = self::getOmikuji($omikujiId);
            if (!$omikuji) {
                return false;
            }

            $omikujiUser = new OmikujiUser();
            $omikujiUser->omikuji_play_time = Carbon::now();
            $omikujiUser->user_id = auth()->id();
            $omikujiUser->omikuji_id = $omikujiId;
            $omikujiUser->recover_time = $omikuji->recover_time;
            $omikujiUser->save();

            // update point user
            $user = auth()->user();
            $user->update([
                'point' => $user->point + $point,
            ]);
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e);

            return false;
        }
    }

    public static function getRandomItem($omikujiId)
    {
        $omikujiItem = OmikujiItem::where('omikuji_id', $omikujiId)->pluck('point', 'id')->toArray();
        if ($omikujiItem) {
            $biasRandom = new BiasRandom();
            foreach ($omikujiItem as $key => $value) {
                $biasRandom->addElement($key, $value);
            }
            $data = $biasRandom->random();

            return $data[0];
        }

        return '';
    }

    public static function getOmikuji($omikujiId)
    {
        return Omikuji::find($omikujiId);
    }

    public static function getOmikujiItem($omikujiItemId)
    {
        return OmikujiItem::find($omikujiItemId);
    }

    public static function getRecoverTime($omikujiId)
    {
        $now = Carbon::now();
        $omikujiUser = OmikujiUser::where('omikuji_id', $omikujiId)
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'DESC')->first();
        $omikuji = Omikuji::find($omikujiId);
        if ($omikujiUser && $omikuji) {
            $playTime = Carbon::parse($omikujiUser->omikuji_play_time);
            $nextTime = $playTime->addHours($omikujiUser->recover_time);
            if ($nextTime->gt($now)) {
                $recoverTimeSecond = $nextTime->diffInSeconds($now);
                $minsec = gmdate('i:s', $recoverTimeSecond);
                $hours = $nextTime->diffInHours($now);

                return $hours.':'.$minsec;
            }
        }

        return false;
    }
}
