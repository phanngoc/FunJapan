<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\ImageService;
use Illuminate\Support\Facades\Log;

class Menu extends BaseModel
{

    protected $table = 'menu';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description',
        'parent_id',
        'link',
        'locale_id',
        'icon',
        'icon_class',
        'name',
        'type',
        'order',
    ];

    protected $appends = [
        'icon_url',
    ];

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'id')->orderBy('order');
    }

    public function locale()
    {
        return $this->belongsTo(Locale::class);
    }

    public function getIconUrlAttribute()
    {
        if ($this->icon) {
            $result = [];
            try {
                foreach (config('images.dimensions.menu_icon') as $key => $value) {
                    $filePath = config('images.paths.menu_icon') . '/' . $this->id . '/' . $key . '_' . $this->icon;

                    $result[$key] = ImageService::imageUrl($filePath);
                }

                return $result;
            } catch (\Exception $e) {
                Log::debug($e);
            }
        }
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($menu) {
            $menu->children()->delete();
        });
    }
}
