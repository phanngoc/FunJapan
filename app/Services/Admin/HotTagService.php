<?php

namespace App\Services\Admin;

use App\Models\HotTag;

class HotTagService extends BaseService
{
    public static function setting($inputs)
    {
        $hotTag = HotTag::where('locale_id', $inputs['locale_id'])->where('tag_id', $inputs['tag_id'])->first();
        if (count($hotTag) > 0) {
            return $hotTag->delete();
        }

        return HotTag::create($inputs);
    }
}
