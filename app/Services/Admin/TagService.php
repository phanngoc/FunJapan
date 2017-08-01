<?php

namespace App\Services\Admin;

use App\Models\Tag;
use App\Models\TagLocale;
use Illuminate\Support\Facades\Log;
use DB;
use Validator;
use Illuminate\Validation\Rule;
use App\Models\ArticleLocale;
use App\Models\ArticleTag;
use App\Models\HotTag;
use App\Services\Admin\LocaleService;
use App\Services\Admin\TagLocaleService;

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
        if (isset($conditions['locale_id'])) {
            $localeId = $conditions['locale_id'];
            if (isset($conditions['is_hot_tag'])) {
                $listTagIds = HotTag::where('locale_id', $localeId)->pluck('tag_id');
                $query = $query->where('status', config('tag.status.un_block'))->whereIn('id', $listTagIds);
            } else {
                $query = Tag::with([
                    'hotTags' => function ($currentQuery) use ($localeId) {
                        $currentQuery->where('locale_id', $localeId);
                    },
                ]);
                $listArticleLocaleIds = ArticleLocale::where('locale_id', $localeId)->pluck('id');
                $listTagIds = ArticleTag::whereIn('article_locale_id', $listArticleLocaleIds)->pluck('tag_id');
                $query = $query->where('status', config('tag.status.un_block'))->whereIn('id', $listTagIds);
            }
        }

        $results = static::listItems($query, $keyword, $searchColumns, $orderConditions, $limit, $page);

        return $returnData = [
            'recordsFiltered' => $results->total(),
            'data' => $results->items(),
        ];
    }

    public static function create($tags, $tagLocales = null)
    {
        $tagIds = [];
        DB::beginTransaction();
        try {
            foreach ($tags as $tag) {
                $newTag = Tag::firstOrCreate([
                    'name' => $tag,
                ]);

                if ($newTag && $newTag->id) {
                    foreach ($tagLocales[$tag] as $key => $tagLocale) {
                        $tagLocale['tag_id'] = $newTag->id;
                        if (!TagLocaleService::create($tagLocale)) {
                            DB::rollback();

                            return false;
                        }
                    }
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
        $q = escape_like($q);
        $tags = Tag::where('name', 'like', "%$q%")
            ->where('status', config('tag.status.un_block'))->pluck('name')->toArray();

        return $tags;
    }

    public static function validate($inputs, $tag = null)
    {
        $locales = LocaleService::getAllLocales();
        $validationRules = [
            'name' => 'required|min:3|max:15|unique:tags,name',
        ];
        foreach ($locales as $key => $value) {
            $validationRules['name' . $key] = [
                'required',
                'min:3',
                'max:15',
                Rule::unique('tag_locales', 'name')->where(function ($query) use ($key) {
                    $query->where('locale_id', $key);
                }),
            ];
        }

        if ($tag) {
            $validationRules = [
                'name' => [
                    'required',
                    'min:3',
                    'max:15',
                    Rule::unique('tags')->ignore($tag->id),
                ],
            ];

            foreach ($locales as $key => $value) {
                $tagLocale = TagLocale::where('tag_id', $tag->id)->where('locale_id', $key)->first();
                $validationRules['name' . $key] = [
                    'required',
                    'min:3',
                    'max:15',
                    Rule::unique('tag_locales', 'name')->where(function ($query) use ($key, $tagLocale) {
                        $query->where('locale_id', $key);
                    })->ignore($tagLocale->id ?? null),
                ];
            }
        }

        return Validator::make($inputs, $validationRules)
            ->setAttributeNames(trans('admin/tag.label'));
    }

    public static function update($inputs, $tagId)
    {
        $tag = Tag::findOrFail($tagId);
        $locales = LocaleService::getAllLocales();
        DB::beginTransaction();
        try {
            if ($tag->update(['name' => $inputs['name']])) {
                foreach ($locales as $key => $value) {
                    if (!TagLocale::updateOrCreate(['tag_id' => $tag->id, 'locale_id' => $key], ['name' => $inputs['name' . $key]])) {
                        DB::rollback();

                        return false;
                    }
                }
                DB::commit();

                return true;
            }
            DB::rollback();

            return false;
        } catch (Exception $e) {
            DB::rollback();
            Log::debug($e);

            return false;
        }
    }

    public static function delete($tag)
    {
        return $tag->delete();
    }

    public static function getTagsByQuery($q)
    {
        $tags = Tag::select('id', 'name')->where('name', 'like', "%$q%")->get();

        return $tags;
    }

    public static function getTag($tagId)
    {
        $tag = Tag::select('id', 'name')->where('id', $tagId)->first();

        return $tag;
    }
}
