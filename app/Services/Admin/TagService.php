<?php

namespace App\Services\Admin;

use App\Models\Tag;
use Illuminate\Support\Facades\Log;
use DB;
use Validator;
use Illuminate\Validation\Rule;

class TagService extends BaseService
{

    public static function list($conditions)
    {
        $keyword = $conditions['search']['value'];
        $searchColumns = ['name'];
        $limit = $conditions['length'];
        $page = $conditions['start'] / $conditions['length'] + 1;
        $orderParams = $conditions['order'];
        $orderConditions['column'] = $conditions['columns'][$orderParams[0]['column']]['data'];
        $orderConditions['dir'] = $orderParams[0]['dir'];
        $query = Tag::query();
        $results = static::listItems($query, $keyword, $searchColumns, $orderConditions, $limit, $page);

        return $returnData = [
            'recordsFiltered' => $results->total(),
            'data' => $results->items(),
        ];
    }

    public static function create($tags)
    {
        $tagIds = [];
        DB::beginTransaction();
        try {
            foreach ($tags as $tag) {
                $newTag = Tag::firstOrCreate([
                    'name' => $tag,
                ]);

                if ($newTag && $newTag->id) {
                    $tagIds[] = $newTag->id;
                }
            }
            DB::commit();

            return $tagIds;
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());

            return false;
        }
    }

    public static function suggetTags($q)
    {
        $tags = Tag::where('name', 'like', "%$q%")
            ->where('status', config('tag.status.un_block'))->pluck('name')->toArray();

        return $tags;
    }

    public static function validate($inputs, $tag = null)
    {
        $validationRules = [
            'name' => 'required|min:3|max:15|unique:tags,name',
        ];

        if ($tag) {
            $validationRules = [
                'name' => [
                    'required',
                    'min:3',
                    'max:15',
                    Rule::unique('tags')->ignore($tag->id),
                ],
            ];
        }

        return Validator::make($inputs, $validationRules)
            ->setAttributeNames(trans('admin/tag.label'));
    }

    public static function update($inputs, $tagId)
    {
        $tag = Tag::findOrFail($tagId);

        return $tag->update($inputs);
    }

    public static function delete($tag)
    {
        return $tag->delete();
    }
}
