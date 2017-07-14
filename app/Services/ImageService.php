<?php

namespace App\Services;

use Illuminate\Contracts\Filesystem\Filesystem;
use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Http\Request;
use Exception;
use Storage;
use Log;
use Image;

class ImageService
{
    public static function uploadFile($image, $type, $path, $delete = false)
    {
        try {
            $storage = Storage::disk(config('filesystems.default'));

            if ($delete) {
                $storage->deleteDirectory($path);
            }

            $hashTime = sha1(time() . clean($image->getClientOriginalName()));
            $extension = $image->getClientOriginalExtension();

            if (in_array($type, config('images.not_resize'))) {
                $imageFileName = $hashTime . '.' . $extension;
                $filePath = $path . '/' . $imageFileName;
                $makeImage = Image::make($image)->orientate()->stream();
                $result = $storage->put($filePath, $makeImage->__toString(), 'public');

                if ($result) {
                    return $imageFileName;
                }

                return false;
            }

            foreach (config('images.dimensions.' . $type) as $key => $dimension) {
                if ($key == 'original') {
                    $fileName = $hashTime . '.' . $extension;
                } else {
                    $fileName = $key . '_' . $hashTime . '.' . $extension;
                }

                $filePath = $path . '/' . $fileName;

                if (is_array($dimension)) {
                    $makeImage = Image::make($image)->orientate()->resize($dimension[0], $dimension[1])->stream();
                } elseif (!empty($dimension)) {
                    $makeImage = Image::make($image)->orientate()->resize($dimension, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->stream();
                } else {
                    $makeImage = Image::make($image)->orientate()->stream();
                }

                $result = $storage->put($filePath, $makeImage->__toString(), 'public');
            }

            return $hashTime . '.' . $extension;
        } catch (Exception $e) {
            Log::debug($e);

            return false;
        }
    }

    public static function delete($path, $image = null)
    {
        try {
            $storage = Storage::disk(config('filesystem.default'));

            if ($image) {
                $storage->delete($path . '/' . $image);
            } else {
                $storage->deleteDirectory($path);
            }

            return true;
        } catch (Exception $e) {
            Log::debug($e);

            return false;
        }
    }

    public static function deleteAll($type, $path, $image = null)
    {
        try {
            $storage = Storage::disk(config('filesystem.default'));

            foreach (config('images.dimensions.' . $type) as $key => $dimension) {
                if ($key == 'original') {
                    $fileName = $image;
                } else {
                    $fileName = $key . '_' . $image;
                }
                $filePath = $path . '/' . $fileName;
                $storage->delete($filePath);
            }

            return true;
        } catch (Exception $e) {
            Log::debug($e);

            return false;
        }
    }

    public static function imageUrl($filePath)
    {
        return Storage::disk(config('filesystem.default'))->url($filePath);
    }

    public static function getImageFromHtml($content)
    {
        try {
            $doc = new \DOMDocument();
            libxml_use_internal_errors(true);
            $doc->loadHTML($content);

            $xpath = new \DOMXPath($doc);
            $imgs = $xpath->query('//img');

            $results = [];

            for ($i = 0; $i < $imgs->length; $i++) {
                $img = $imgs->item($i);
                $results[] = $img->getAttribute('src');
            }
        } catch (Exception $e) {
            $results = [];
        }

        return $results;
    }

    public static function getImageFromMarkdown($content)
    {
        $content = Markdown::convertToHtml($content);

        return self::getImageFromHtml($content);
    }
}
