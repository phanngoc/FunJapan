<?php

namespace App\Services\Admin;

use App\Models\Author;
use Illuminate\Support\Facades\Log;
use Validator;
use App\Services\ImageService;
use DB;

class AuthorService extends BaseService
{
    public static function validate($inputs)
    {
        $validationRules = [
            'name' => 'required|max:255',
            'description' => 'max:255',
        ];

        return Validator::make($inputs, $validationRules)->setAttributeNames([
            'name' => 'Name',
            'description' => 'Description',
        ]);
    }

    public static function getAll()
    {
        return Author::orderBy('created_at', 'desc')->get();
    }

    public static function filterAuthors($options)
    {
        $authors = new Author();

        if (isset($options['keyword']) && $options['keyword']) {
            $keyword = escape_like($options['keyword']);

            $authors = $authors->whereIn(
                'id',
                Author::where('name', 'like', "%$keyword%")
                    ->pluck('id')
                    ->toArray()
            );
        }
        $orderBy = $options['orderBy'] ?? null;
        $optionSort = [
            'id.desc',
            'id.asc',
            'name.desc',
            'name.asc',
        ];

        if (!in_array($orderBy, $optionSort)) {
            $orderBy = 'id.desc';
        }

        $orders = explode('.', $orderBy);
        $authors = $authors->orderBy($orders[0], $orders[1]);

        $authors = $authors->paginate(config('limitation.articles.default_per_page'));

        return $authors;
    }

    public static function store($inputs)
    {
        if ($inputs) {
            DB::beginTransaction();
            try {
                $author =  Author::create([
                    'name' => trim($inputs['name']),
                    'description' => trim($inputs['description']) ?? null,
                ]);

                if ($author) {
                    if (isset($inputs['photo'])) {
                        $photoUploadPath = config('images.paths.author') . '/' . $author->id;
                        $photo = ImageService::uploadFile(
                            $inputs['photo'],
                            'author',
                            $photoUploadPath
                        );

                        $author->update([
                            'photo' => $photo,
                        ]);
                    }
                }

                DB::commit();

                return $author;
            } catch (\Exception $e) {
                DB::rollback();
                Log::error($e);

                return false;
            }
        }
    }

    public static function update($inputs, $id)
    {
        if ($inputs) {
            $author = Author::find($id);
            if ($author) {
                DB::beginTransaction();
                try {
                    $author->update([
                        'name' => trim($inputs['name']),
                        'description' => trim($inputs['description']),
                    ]);
                    if (isset($inputs['photo'])) {
                        $photoUploadPath = config('images.paths.author') . '/' . $author->id;
                        $photo = ImageService::uploadFile(
                            $inputs['photo'],
                            'author',
                            $photoUploadPath
                        );

                        $author->update([
                            'photo' => $photo,
                        ]);
                    }

                    DB::commit();

                    return $author;
                } catch (\Exception $e) {
                    DB::rollback();
                    Log::error($e);

                    return false;
                }
            }

            return false;
        }
    }
}
