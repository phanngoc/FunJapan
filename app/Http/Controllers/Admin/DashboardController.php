<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->viewData['title'] = trans('admin/global.title');
        return view('admin/dashboard.index', $this->viewData);
    }
}
