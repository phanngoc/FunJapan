<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use App\Services\Admin\CategoryService;
use Illuminate\Support\Facades\Log;

class CategoriesController extends Controller
{
    public function index()
    {
        $this->viewData['categories'] = CategoryService::listCategory();
        return view('admin.category.index', $this->viewData);
    }
}
