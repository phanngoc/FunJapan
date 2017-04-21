<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\TagService;
use App\Services\Admin\ArticleLocaleService;
use App\Models\Tag;

class TagsController extends Controller
{
    public function index()
    {
        return view('admin.tag.index');
    }

    public function show(Tag $tag)
    {
        $this->viewData['articlesOfTag'] = ArticleLocaleService::listArticleByTags($tag);
        $this->viewData['tag'] = $tag;

        return view('admin.tag.articles_of_tag', $this->viewData);
    }

    public function getListTags(Request $request)
    {
        $params = $request->input();
        $draw = $params['draw'];
        $tagsData = TagService::list($params);
        $tagsData['draw'] = (int)$draw;

        return $tagsData;
    }

    public function suggest(Request $request)
    {
        $query = $request->input('query');
        $tags = TagService::suggetTags($query);

        return $tags;
    }
}
