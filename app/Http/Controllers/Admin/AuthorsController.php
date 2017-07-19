<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Services\Admin\AuthorService;
use App\Services\Admin\LocaleService;
use App\Services\Admin\ArticleService;
use App\Services\Admin\ClientService;
use Gate;
use Session;

class AuthorsController extends Controller
{
    public function show(Request $request, Author $author)
    {
        abort_if(Gate::denies('permission', 'author.article_list'), 403, 'Unauthorized action.');
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
            'author_id' => $author->id,
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
        abort_if(Gate::denies('permission', 'author.add'), 403, 'Unauthorized action.');
        $inputs = $request->all();
        $validator = AuthorService::validate($inputs);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()]);
        } else {
            $author = AuthorService::store($inputs);
            return response()->json([
                'id' => $author->id,
                'photo' => $author->photoUrl['small'],
                'name' => $author->name,
                'description' => $author->description,
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        abort_if(Gate::denies('permission', 'author.edit'), 403, 'Unauthorized action.');
        $inputs = $request->all();
        $validator = AuthorService::validate($inputs);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()]);
        } else {
            $author = AuthorService::update($inputs, $id);

            return response()->json([
                'name' => $author->name,
                'description' => $author->description,
            ]);
        }
    }
}
