<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\TagService;
use App\Services\Admin\LocaleService;
use App\Services\Admin\HotTagService;
use App\Services\Admin\ArticleLocaleService;
use App\Services\Admin\ArticleService;
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
        $tags = Tag::with('tagLocales')->orderBy('id', 'desc')->paginate(config('limitation.tags.per_page'));
        $this->viewData['tags'] = $tags;
        $tags->withPath(action('Admin\TagsController@ajaxTagList', ['query' => '']));
        $locales = LocaleService::getAllLocales();
        $this->viewData['locales'] = $locales;

        return view('admin.tag.create', $this->viewData);
    }

    public function store(Request $request)
    {
        $inputs = $request->all();

        $validator = TagService::validate($inputs);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $tagData[] = $inputs['name'];

        $locales = LocaleService::getAllLocales();

        $tagLocaleDatas = [];

        foreach ($locales as $key => $value) {
            $tagLocaleDatas[$inputs['name']][] = [
                'name' => $inputs['name' . $key],
                'locale_id' => $key,
            ];
        }

        if (TagService::create($tagData, $tagLocaleDatas)) {
            return response()->json([
                'status' => 1,
                'message' => trans('admin/tag.create_success'),
            ]);
        }

        return response()->json([
            'status' => 0,
            'message' => trans('admin/tag.create_errors'),
        ]);
    }

    public function edit(Tag $tag)
    {
        $this->viewData['tag'] = $tag;

        return view('admin.tag.edit', $this->viewData);
    }

    public function update(Request $request)
    {
        $inputs = $request->all();
        $tag = Tag::find($inputs['id']);

        $validator = TagService::validate($inputs, $tag);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        if (TagService::update($inputs, $tag->id)) {
            return response()->json([
                'status' => 1,
                'message' => trans('admin/tag.update_success'),
            ]);
        }

        return response()->json([
            'status' => 0,
            'message' => trans('admin/tag.update_errors'),
        ]);
    }

    public function destroy(Request $request)
    {
        $inputs = $request->all();
        $tag = Tag::find($inputs['id']);
        if (TagService::delete($tag)) {
            return response()->json([
                'status' => 1,
                'message' => trans('admin/tag.delete_success'),
            ]);
        }

        return response()->json([
            'status' => 0,
            'message' => trans('admin/tag.update_errors'),
        ]);
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
        $localeId = $request->input('localeId');

        $tags = TagService::suggetTags($query, $localeId);

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

    public function settingHotTags(Request $request)
    {
        $localeId = $request->input('locale_id') ?? array_first(array_keys(LocaleService::getAllLocales()));
        $this->viewData['locales'] = LocaleService::getAllLocales();
        $this->viewData['localeId'] = $localeId;

        return view('admin.tag.setting_hot_tags', $this->viewData);
    }

    public function showHotTags(Request $request)
    {
        $localeId = $request->input('locale_id') ?? array_first(array_keys(LocaleService::getAllLocales()));
        $this->viewData['locales'] = LocaleService::getAllLocales();
        $this->viewData['localeId'] = $localeId;

        return view('admin.tag.list_hot_tags', $this->viewData);
    }

    public function updateHotTag(Request $request)
    {
        $inputs = $request->all();

        if (HotTagService::setting($inputs)) {
            return response()->json(['message' => trans('admin/tag.setting_success'), 'status' => 1]);
        }

        return response()->json(['message' => trans('admin/tag.setting_error'), 'status' => 0]);
    }

    public function ajaxTagList(Request $request)
    {
        $inputs = $request->all();
        $page = $inputs['page'];

        $tags = Tag::with('tagLocales')->where('name', 'like', '%' . escape_like($inputs['query']) . '%')
            ->orderBy('id', 'desc')->paginate(config('limitation.tags.per_page'), ['*'], 'page', $page);

        $tags->withPath(action('Admin\TagsController@ajaxTagList', ['query' => '']));
        if (isset($inputs['search'])) {
            $this->viewData['isSearch'] = true;
        }
        $this->viewData['tags'] = $tags;

        return view('admin.tag._tag_list', $this->viewData);
    }
}
