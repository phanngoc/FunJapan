<?php
namespace App\Services\Web;

use App\Models\Menu;
use App\Models\Category;
use App\Models\Tag;
use App\Services\Web\TagService;
use DB;

class MenuService
{
    public static function getMenu($localeId)
    {
        $menu = Menu::with('children')
            ->whereNull('parent_id')
            ->where('locale_id', $localeId)
            ->orderBy('order')
            ->get();

        foreach ($menu as $key => $m) {
            if ($m->type == config('menu.parent_type.category')) {
                $categoriesId = $m->children()->orderBy('order', 'asc')->pluck('link')->toArray();

                if ($categoriesId) {
                    $menu[$key]->categories = Category::whereIn('id', $categoriesId)
                        ->orderByRaw(DB::raw('FIELD(id, ' . implode(',', $categoriesId) . ')'))
                        ->get();
                } else {
                    $menu[$key]->categories = null;
                }
            } elseif ($m->type == config('menu.parent_type.tag')) {
                $menu[$key]->tags = TagService::getHotTags($m->locale_id, config('limitation.tags.hot_tags'));
            }
        }

        return $menu;
    }
}
