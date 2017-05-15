<?php

namespace App\Services\Web;

use Illuminate\Support\Facades\Validator;
use App\Models\Tag;
use App\Models\ArticleTag;
use App\Models\CategoryLocale;
use App\Models\ArticleLocales;
use DB;
use App\Services\Web\LocaleService;
use Illuminate\Support\Facades\App;
use Carbon\Carbon;
use App\Models\ArticleLocale;

class TagService
{
    public static function getArticleByTag($tag, $localeId)
    {
        return $tag->articlesTags()
            ->with(['articleLocale', 'articleLocale.tags', 'article', 'article.category'])
            ->select('article_tags.*')
            ->join('article_locales as al', 'al.id', '=', 'article_tags.article_locale_id')
            ->where('al.hide_always', 0)
            ->where('al.locale_id', $localeId)
            ->where('published_at', '<=', Carbon::now())
            ->orderBy('al.is_top_article', 'DESC')
            ->orderBy('al.published_at', 'DESC')
            ->orderBy('al.created_at', 'DESC')
            ->orderBy('al.title', 'DESC')
            ->paginate(config('limitation.article_tag.per_page'));
    }

    public static function getHotTags($localeId, $limit = 20)
    {
        $hotTagsId = ArticleTag::select('tag_id', DB::raw('count(tag_id) as total_tags'))
            ->whereIn('article_locale_id', ArticleLocale::where('locale_id', $localeId)
                                                        // ->where('hide_always', 0)
                                                        // ->whereNotNull('published_at')
                                                        // ->where('published_at', '<', Carbon::now())
                                                        ->pluck('id')->toArray())
            ->groupBy('tag_id')
            ->orderBy('total_tags', 'desc')
            ->get();

        $hotTagsId = array_pluck($hotTagsId, 'tag_id');

        if (empty($hotTagsId)) {
            return null;
        }

        return Tag::whereIn('id', $hotTagsId)
            ->orderByRaw(DB::raw('FIELD(id, ' . implode(',', $hotTagsId) . ')'))
            ->limit($limit)
            ->get();
    }
}
