<?php

namespace App\Services\Admin;

use App\Models\Menu;
use App\Models\MenuLocale;
use Illuminate\Support\Facades\Log;
use DB;
use Validator;
use App\Services\ImageService;
use App\Services\Admin\MenuLocaleService;
use Illuminate\Validation\Rule;

class MenuService extends BaseService
{
    public static function validate($inputs, $menu = null)
    {
        $validationRules = [
            'description' => 'required|min:5|max:50',
            'icon' => 'required|image|max:' . config('images.validate.menu_icon.max_size'),
            'link' => 'required_if:type,' . config('menu.parent_type.link'),
        ];

        $validationRules['name'] = [
            'required',
            'max:20',
            Rule::unique('menu')->where(function ($query) use ($inputs) {
                $query->where('locale_id', $inputs['locale_id']);
            }),
        ];

        if ($menu) {
            $validationRules['icon'] = 'image|max:' . config('images.validate.menu_icon.max_size');
            $validationRules['name'] = [
                'required',
                'max:20',
                Rule::unique('menu')->where(function ($query) use ($inputs) {
                    $query->where('locale_id', $inputs['locale_id']);
                })->ignore($menu->id),
            ];
        }

        return Validator::make($inputs, $validationRules)
            ->setAttributeNames(trans('admin/menu.label'));
    }

    public static function validateSubMenu($inputs, $menu = null)
    {
        $validationRules = [
            'description' => 'required|max:50',
            'link' => 'required',
        ];

        $validationRules['name'] = [
            'required',
            'max:20',
            Rule::unique('menu')->where(function ($query) use ($inputs) {
                $query->where('locale_id', $inputs['locale_id']);
            }),
        ];

        if ($menu) {
            $validationRules['name'] = [
                'required',
                'max:20',
                Rule::unique('menu')->where(function ($query) use ($inputs) {
                    $query->where('locale_id', $inputs['locale_id']);
                })->ignore($menu->id),
            ];
        }

        return Validator::make($inputs, $validationRules)
            ->setAttributeNames(trans('admin/menu.label'));
    }

    public static function create($inputs, $parentId = null)
    {
        $inputs['order'] = count(Menu::where('parent_id', $parentId)
            ->where('locale_id', $inputs['locale_id'])->get()) + 1;
        DB::beginTransaction();
        try {
            if ($menu = Menu::create($inputs)) {
                $iconPath = config('images.paths.menu_icon') . '/' . $menu->id;
                $fileName = ImageService::uploadFile($inputs['icon'], 'menu_icon', $iconPath);

                if ($fileName) {
                    $menu->icon = $fileName;
                    $menu->save();
                    DB::commit();

                    return true;
                }

                DB::rollback();

                return false;
            }

            return false;
        } catch (\Exception $e) {
            DB::rollback();

            return false;
        }
    }

    public static function update($inputs, $menu)
    {
        if (isset($inputs['icon'])) {
            $iconPath = config('images.paths.menu_icon') . '/' . $menu->id;
            $fileName = ImageService::uploadFile($inputs['icon'], 'menu_icon', $iconPath, true);

            if ($fileName) {
                $inputs['icon'] = $fileName;
            } else {
                return false;
            }
        }

        return $menu->update($inputs);
    }

    public static function createSubMenu($inputs, $parentId = null)
    {
        $inputs['order'] = count(Menu::where('parent_id', $parentId)
            ->where('locale_id', $inputs['locale_id'])->get()) + 1;
        DB::beginTransaction();
        try {
            if ($menu = Menu::create($inputs)) {
                    DB::commit();

                    return true;
            }
            DB::rollback();

            return false;
        } catch (\Exception $e) {
            DB::rollback();

            return false;
        }
    }

    public static function updateSubMenu($inputs, $menu)
    {
        return $menu->update($inputs);
    }

    public static function delete($menu)
    {
        return $menu->delete();
    }

    public static function listNoParentMenu($localeId)
    {
        return Menu::where('parent_id', null)->where('locale_id', $localeId)->orderBy('order', 'asc')->get();
    }

    public static function updateOrder($inputs)
    {
        $listIds = $inputs['order'];
        $placeholders = implode(',', array_fill(0, count($listIds), '?'));
        $menus = Menu::whereIn('id', $listIds)
            ->orderByRaw("field (id, {$placeholders})", $listIds)
            ->get();
        DB::beginTransaction();
        try {
            foreach ($menus as $key => $menu) {
                $menu->order = $key + 1;
                $menu->save();
            }
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();

            return false;
        }
    }

    public static function getParentTypes()
    {
        $parentTypes = [];
        foreach (config('menu.parent_type') as $key => $type) {
            $parentTypes[$type] = trans('admin/menu.parent_type.' . $key);
        }

        return $parentTypes;
    }
}
