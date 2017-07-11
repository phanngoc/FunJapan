<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\ClientService;
use App\Services\Admin\AuthorService;
use Illuminate\Support\Facades\View;

class IdsController extends Controller
{
    public function index(Request $request)
    {
        $this->viewData['authors'] = AuthorService::getAll();
        $this->viewData['selectClients'] = ClientService::getList();
        $limit = $request->input('perPage', config('limitation.articles.default_per_page'));
        $keyword = $request->input('keyword', '');
        $sortBy = $request->input('sortBy', 'id.desc');
        $tab = $request->input('tab');

        $this->viewData['filter'] = [
            'limit' => $limit,
            'sortBy' => $sortBy,
        ];

        $this->viewData['clients'] = ClientService::filterClients([
            'limit' => $limit,
            'keyword' => $keyword,
            'orderBy' => $sortBy,
        ]);

        $this->viewData['authors'] = AuthorService::filterAuthors([
            'limit' => $limit,
            'keyword' => $keyword,
            'orderBy' => $sortBy,
        ]);

        if ($request->ajax() && $tab == 'client') {
            $this->viewData['results'] = $this->viewData['clients'];
            return response()->json([
                'htmlClients' => View::make('admin/clients/_table', $this->viewData)->render(),
                'htmlClientsPaginator' => View::make('admin/elements/_paginate', $this->viewData)->render(),
            ]);
        }

        if ($request->ajax() && $tab == 'author') {
            $this->viewData['results'] = $this->viewData['authors'];
            return response()->json([
                'htmlAuthors' => View::make('admin/authors/_table', $this->viewData)->render(),
                'htmlAuthorsPaginator' => View::make('admin/elements/_paginate', $this->viewData)->render(),
            ]);
        }

        return view('admin.ids.index', $this->viewData);
    }
}
