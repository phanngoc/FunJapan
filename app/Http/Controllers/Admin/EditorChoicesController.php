<?php
namespace App\Http\Controllers\Admin;

use App\Models\EditorChoice;
use App\Models\ArticleLocale;
use Illuminate\Http\Request;
use App\Services\Admin\EditorChoiceService;
use Gate;
use App\Services\Admin\LocaleService;

class EditorChoicesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('permission', 'editor_choice.list'), 403, 'Unauthorized action.');

        $editorChoices = EditorChoice::all();
        $this->viewData['editorChoices'] = [];
        foreach ($editorChoices as $key => $item) {
            $article = ArticleLocale::find($item->link);
            $this->viewData['editorChoices'][$key]['item'] = $item;
            $this->viewData['editorChoices'][$key]['thumbnail'] = $article->thumbnail_urls;
        }

        return view('admin.editor_choices.index', $this->viewData);
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('permission', 'editor_choice.add'), 403, 'Unauthorized action.');

        $inputs = $request->all();
        $validator = EditorChoiceService::validate($inputs);
        if ($validator->fails()) {
            $response = [
                'status' => 0,
                'message' => $validator->errors()->first(),
            ];

            return response()->json($response);
        }
        $articleLocale = ArticleLocale::find($inputs['url']);
        if ($articleLocale) {
            $editorChoiceData = [
                'link' => $inputs['url'],
                'article_id' => $articleLocale->article->id,
            ];
            if ($editorChoice = EditorChoiceService::create($editorChoiceData)) {
                $newRecord = [
                    'link' => $editorChoice->link,
                    'id' => $editorChoice->id,
                    'thumbnail' => $articleLocale->thumbnail_urls,
                    'number_record' => count(EditorChoice::all()),
                ];
                $response = [
                    'status' => 1,
                    'message' => trans('admin/editor_choices.create_success'),
                    'data' => $newRecord,
                ];

                return response()->json($response);
            }

            $response = [
                'status' => 0,
                'message' => trans('admin/editor_choices.create_errors'),
            ];

            return response()->json($response);
        } else {
            $response = [
                'status' => 0,
                'message' => trans('admin/editor_choices.invalid_article'),
            ];

            return response()->json($response);
        }
    }

    public function update(Request $request)
    {
        abort_if(Gate::denies('permission', 'editor_choice.edit'), 403, 'Unauthorized action.');

        $inputs = $request->all();
        $editorChoice = EditorChoice::find($inputs['id']);
        $validator = EditorChoiceService::validate($inputs, $editorChoice);
        if ($validator->fails()) {
            $response = [
                'status' => 0,
                'message' => $validator->errors()->first(),
            ];

            return response()->json($response);
        }

        $articleLocale = ArticleLocale::find($inputs['url']);
        if ($articleLocale) {
            $editorChoiceData = [
                'id' => $inputs['id'],
                'link' => $inputs['url'],
                'article_id' => $articleLocale->article->id,
            ];
            if (EditorChoiceService::update($editorChoiceData, $editorChoice)) {
                $updatedRecord = [
                    'link' => $editorChoice->link,
                    'id' => $editorChoice->id,
                    'thumbnail' => $articleLocale->thumbnail_urls,
                ];
                $response = [
                    'status' => 1,
                    'message' => trans('admin/editor_choices.update_success'),
                    'data' => $updatedRecord,
                ];

                return response()->json($response);
            }

            $response = [
                'status' => 0,
                'message' => trans('admin/editor_choices.update_errors'),
            ];

            return response()->json($response);
        } else {
            $response = [
                'status' => 0,
                'message' => trans('admin/editor_choices.invalid_article'),
            ];

            return response()->json($response);
        }
    }

    public function destroy(Request $request)
    {
        abort_if(Gate::denies('permission', 'editor_choice.delete'), 403, 'Unauthorized action.');

        $inputs = $request->all();
        $editorChoice = EditorChoice::find($inputs['id']);
        if ($editorChoice->delete()) {
            $response = [
                'status' => 1,
                'message' => trans('admin/editor_choices.delete_success'),
                'number_record' => count(EditorChoice::all()),
            ];

            return response()->json($response);
        }

        $response = [
            'status' => 0,
            'message' => trans('admin/editor_choices.delete_errors'),
        ];

        return response()->json($response);
    }
}
