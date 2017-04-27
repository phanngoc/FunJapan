<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\MenuService;
use App\Services\Admin\LocaleService;
use App\Services\Admin\MenuLocaleService;
use App\Models\Menu;
use App\Models\MenuLocale;

class MenusController extends Controller
{
    public function index(Request $request)
    {
        $localeId = $request->input('locale') ?? array_first(array_keys(LocaleService::getAllLocales()));
        $this->viewData['menus'] = MenuService::listNoParentMenu($localeId);
        $this->viewData['menuTypes'] = MenuService::getParentTypes();
        $this->viewData['locales'] = LocaleService::getAllLocales();
        $this->viewData['localeId'] = $localeId;

        return view('admin.menu.index', $this->viewData);
    }

    public function create()
    {
        $this->viewData['menuTypes'] = MenuService::getParentTypes();
        $this->viewData['locales'] = LocaleService::getAllLocales();

        return view('admin.menu.create', $this->viewData);
    }

    public function store(Request $request)
    {
        $inputs = $request->all();
        $validator = MenuService::validate($inputs);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($inputs);
        }
        if (MenuService::create($inputs)) {
            return redirect()->action('Admin\MenusController@index')
                ->with(['message' => trans('admin/menu.create_success')]);
        }

        return redirect()->back()->withErrors(['errors' => trans('admin/menu.create_errors')]);
    }

    public function show(Request $request, Menu $menu)
    {
        $this->viewData['menu'] = $menu;

        return view('admin.menu.detail', $this->viewData);
    }

    public function showSubMenu(Menu $menu)
    {
        if ($menu->parent_id !== null || $menu->type !== config('menu.parent_type.mix')) {
            return redirect('admin/')->with(['error' => trans('admin/menu.create_errors')]);
        }
        $this->viewData['menuItems'] = $menu->children()->orderBy('order')->get();
        $this->viewData['menu'] = $menu;
        $this->viewData['locales'] = LocaleService::getAllLocales();

        return view('admin.menu.list_menu_item', $this->viewData);
    }

    public function edit(Menu $menu)
    {
        $this->viewData['menu'] = $menu;

        return view('admin.menu.edit', $this->viewData);
    }

    public function update(Request $request, Menu $menu)
    {
        $inputs = $request->all();

        $validator = MenuService::validate($inputs, $menu);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($inputs);
        }

        if (MenuService::update($inputs, $menu)) {
            return redirect()->action('Admin\MenusController@index')
                ->with(['message' => trans('admin/menu.update_success')]);
        }

        return redirect()->back()->withErrors(['errors' => trans('admin/menu.update_errors')]);
    }

    public function destroy(Menu $menu)
    {
        if (MenuService::delete($menu)) {
            return redirect()->back()->with(['message' => trans('admin/menu.delete_success')]);
        }

        return redirect()->back()->withErrors(['error' => trans('admin/menu.delete_errors')]);
    }

    public function createSubMenu(Menu $menu)
    {
        if ($menu->type !== config('menu.parent_type.mix')) {
            return redirect()->back()->withErrors(['error' => trans('admin/menu.create_errors')]);
        }

        $this->viewData['menu'] = $menu;
        $this->viewData['type'] = config('menu.parent_type.link');

        return view('admin.menu.create_sub_menu', $this->viewData);
    }

    public function storeSubMenu(Request $request, Menu $menu)
    {
        $inputs = $request->all();

        $validator = MenuService::validateSubMenu($inputs);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($inputs);
        }
        $inputs['parent_id'] = $menu->id;

        if (MenuService::createSubMenu($inputs, $menu->id)) {
            return redirect()->action('Admin\MenusController@showSubMenu', $menu->id)
                ->with(['message' => trans('admin/menu.create_success')]);
        }

        return redirect()->back()->withErrors(['errors' => trans('admin/menu.create_errors')]);
    }

    public function editSubMenu(Menu $menu)
    {
        $this->viewData['menu'] = $menu;

        return view('admin.menu.edit_sub_menu', $this->viewData);
    }

    public function updateSubMenu(Request $request, Menu $menu)
    {
        $inputs = $request->all();

        $validator = MenuService::validateSubMenu($inputs, $menu);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($inputs);
        }

        if (MenuService::updateSubMenu($inputs, $menu)) {
            return redirect()->action('Admin\MenusController@showSubMenu', $menu->parent_id)
                ->with(['message' => trans('admin/menu.update_success')]);
        }

        return redirect()->back()->withErrors(['errors' => trans('admin/menu.update_errors')]);
    }

    public function setLanguageSubMenu(Menu $menu)
    {
        $existLanguage = [];
        foreach ($menu->menuLocales as $key => $menuLocale) {
            $existLanguage[$menuLocale->locale_id] = $menuLocale->locale->name;
        }
        $this->viewData['menu'] = $menu;
        $this->viewData['type'] = config('menu.parent_type.link');
        $this->viewData['locales'] = array_diff(LocaleService::getAllLocales(), $existLanguage);

        return view('admin.menu.set_sub_menu_other_language', $this->viewData);
    }

    public function storeLanguageSubMenu(Request $request, Menu $menu)
    {
        $inputs = $request->all();

        $validator = MenuService::validateSubMenu($inputs, $menu);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($inputs);
        }
        $inputs['name'] = [$inputs['locale'] => $inputs['name']];
        if (MenuLocaleService::create($inputs, $menu->id)) {
            return redirect()->action('Admin\MenusController@showSubMenu', $menu->parent_id)
                ->with(['message' => trans('admin/menu.create_success')]);
        }

        return redirect()->back()->withErrors(['errors' => trans('admin/menu.create_errors')]);
    }

    public function updateOrder(Request $request)
    {
        $inputs = $request->all();
        if (MenuService::updateOrder($inputs)) {
            return response()->json(['message' => trans('admin/menu.order_success')]);
        }

        return response()->json(['message' => trans('admin/menu.order_errors')]);
    }
}
