<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\ClientService;
use App\Services\Admin\ArticleService;
use App\Services\Admin\LocaleService;
use App\Models\Client;
use Gate;
use Session;

class ClientsController extends Controller
{
    public function show(Request $request, Client $client)
    {
        abort_if(Gate::denies('permission', 'client.article_list'), 403, 'Unauthorized action.');
        $limit = $request->input('perPage', config('limitation.articles.default_per_page'));
        $keyword = $request->input('keyword', '');
        $sortBy = $request->input('sortBy', 'id.desc');
        $searchColumn = $request->input('searchColumn', 'article_id');

        $this->viewData['filter'] = [
            'limit' => $limit,
            'keyword' => $keyword,
            'sortBy' => $sortBy,
            'searchColumn' => $searchColumn,
        ];

        $this->viewData['articles'] = ArticleService::listArticles([
            'client_id' => $client->id,
            'limit' => $limit,
            'keyword' => $keyword,
            'orderBy' => $sortBy,
            'searchColumn' => $searchColumn,
        ]);

        $this->viewData['locales'] = LocaleService::getAllIsoCodeLocales();

        return view('admin.article.index', $this->viewData);
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('permission', 'client.add'), 403, 'Unauthorized action.');
        $inputs = $request->all();
        $validator = ClientService::validate($inputs);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()]);
        } else {
            $client = ClientService::store($inputs);
            return response()->json([
                'id' => $client->id,
                'name' => $client->name,
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        abort_if(Gate::denies('permission', 'client.edit'), 403, 'Unauthorized action.');
        $inputs = $request->all();
         $validator = ClientService::validate($inputs);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()]);
        } else {
            $client = ClientService::update($inputs, $id);

            return response()->json(['name' => $client->name]);
        }
    }
}
