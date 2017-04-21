<?php

namespace App\Services\Admin;

use App\Models\ArticleLocale;
use App\Models\ArticleTag;
use Image;
use File;
use Illuminate\Support\Facades\Storage;
use DB;

class ArticleLocaleService extends BaseService
{
    public static function list()
    {
        return ArticleLocale::paginate();
    }

    public static function listArticleByTags($tag)
    {
        $articleLocaleIds = ArticleTag::where('tag_id', $tag->id)->pluck('article_locale_id');

        return ArticleLocale::whereIn('id', $articleLocaleIds)->paginate();
    }

    public static function create($inputs, $thumbnail)
    {
        $articleLocale = ArticleLocale::create($inputs);

        if ($articleLocale) {
            $fileName = static::uploadImage($thumbnail, $articleLocale);
            $articleLocale->photo = $fileName;
            $articleLocale->save();
        }

        return $articleLocale;
    }

    public static function update($inputs, $articleLocaleId)
    {
        $articleLocale = ArticleLocale::findOrFail($articleLocaleId);

        if ($articleLocale->update($inputs)) {
            if (isset($inputs['thumbnail'])) {
                Storage::exists(config('article.thumbnail.upload.upload_path') . $articleLocale->id)
                    ? '' : Storage::makeDirectory(config('article.thumbnail.upload.upload_path') . $articleLocale->id);
                if (Storage::deleteDirectory(config('article.thumbnail.upload.upload_path') . $articleLocale->id)) {
                    $fileName = static::uploadImage($inputs['thumbnail'], $articleLocale);
                    $articleLocale->photo = $fileName;
                    $articleLocale->save();

                    return true;
                }
            }

            return true;
        }

        return false;
    }

    public static function uploadImage($thumbnail, $articleLocale)
    {
        $fileExtension = $thumbnail->getClientOriginalExtension();
        $fileName  = time() . '.' . $fileExtension;
        $path = config('article.thumbnail.upload.upload_path') . $articleLocale->id . '/';
        $demensions = config('article.thumbnail.upload.demensions');
        foreach ($demensions as $key => $demension) {
            $fullFileName = $key . $fileName;
            if ($key === 'original_') {
                $file = Image::make($thumbnail)->encode($fileExtension);
                Storage::put($path . $fullFileName, $file->__toString());
                continue;
            }
            $file = Image::make($thumbnail)
            ->resize($demension['width'], $demension['height'])
            ->encode($fileExtension);
            Storage::put($path . $fullFileName, $file->__toString());
        }

        return $fileName;
    }

    public static function createArticleOtherLanguage($article, $inputs)
    {
        $articleLocaleData = [
            'locale_id' => (int)$inputs['locale'],
            'article_id' => $article->id,
            'title' => $inputs['title'],
            'content' => $inputs['content'],
            'summary' => $inputs['summary'],
            'published_at' => $inputs['publish_date'],
        ];
        DB::beginTransaction();
        try {
            if ($articleLocale = static::create($articleLocaleData, $inputs['thumbnail'])) {
                if (ArticleTagService::create($article, $articleLocale->id, $inputs['tags'] ?? [])) {
                    DB::commit();

                    return true;
                }
            }
            DB::rollback();

            return false;
        } catch (\Exception $e) {
            DB::rollback();

            return false;
        }
    }
}
