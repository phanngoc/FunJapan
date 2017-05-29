<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\TagService;
use App\Services\Admin\ArticleLocaleService;
use App\Services\Admin\ArticleService;
use App\Services\Admin\LocaleService;
use App\Models\Tag;

class TagsController extends Controller
{
    public function index()
    {
        return view('admin.tag.index');
    }

    public function show(Request $request, Tag $tag)
    {
        $localeId = $request->input('locale_id') ?? array_first(array_keys(LocaleService::getAllLocales()));
        $this->viewData['locales'] = LocaleService::getAllLocales();
        $this->viewData['localeId'] = $localeId;
        $this->viewData['tagId'] = $tag->id;
        $this->viewData['types'] = json_encode(ArticleService::getArticleTypes());

        return view('admin.tag.articles_of_tag', $this->viewData);
    }

    public function create()
    {
        return view('admin.tag.create');
    }

    public function store(Request $request)
    {
        $inputs = $request->all();

        $validator = TagService::validate($inputs);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($inputs);
        }
        $tagData[] = $inputs['name'];
        if (TagService::create($tagData)) {
            return redirect()
                ->action('Admin\TagsController@index')->with(['message' => trans('admin/tag.create_success')]);
        }

        return redirect()
            ->back()->withErrors(['errors' => trans('admin/tag.create_error')]);
    }

    public function edit(Tag $tag)
    {
        $this->viewData['tag'] = $tag;

        return view('admin.tag.edit', $this->viewData);
    }

    public function update(Request $request, Tag $tag)
    {
        $inputs = $request->all();

        $validator = TagService::validate($inputs, $tag);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($inputs);
        }
        if (TagService::update($inputs, $tag->id)) {
            return redirect()
                ->action('Admin\TagsController@index')->with(['message' => trans('admin/tag.update_success')]);
        }

        return redirect()
            ->back()->withErrors(['errors' => trans('admin/tag.update_error')]);
    }

    public function destroy(Tag $tag)
    {
        if (TagService::delete($tag)) {
            return redirect()
                ->action('Admin\TagsController@index')->with(['message' => trans('admin/tag.delete_success')]);
        }

        return redirect()
            ->back()->withErrors(['errors' => trans('admin/tag.delete_error')]);
    }

    public function getListTags(Request $request)
    {
        $params = $request->all();
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

    public function block(Tag $tag)
    {
        if ($tag->status == config('tag.status.blocked')) {
            $inputs = [
                'status' => config('tag.status.un_block'),
            ];
            $message = ['message' => trans('admin/tag.unblock_success'), 'status' => 1];
        } else {
            $inputs = [
                'status' => config('tag.status.blocked'),
            ];
            $message = ['message' => trans('admin/tag.block_success'), 'status' => 1];
        }

        if (TagService::update($inputs, $tag->id)) {
            return response()
                ->json($message);
        }

        return respons()
            ->json(['errors' => trans('admin/tag.block_error'), 'status' => 0]);
    }

    public function getTags(Request $request)
    {
        $query = $request->input('q');
        $dataReturn = [];
        $dataReturn['items'] = TagService::getTagsByQuery($query);

        return $dataReturn;
    }
}
