<?php

namespace App\Models;

use Illuminate\Support\Facades\App;
use App\Services\Web\LocaleService;

class Religion extends BaseModel
{

    protected $table = 'religions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'place_holder',
    ];

    protected $appends = ['locale'];

    public function getLocaleAttribute()
    {
        $locales = [
            'id' => 0,
            'name' => 'No data in this language',
        ];

        $locale = LocaleService::getLocaleByIsoCode(App::getLocale());

        $data = ReligionLocale::where('locale_id', $locale->id)
            ->where('religion_id', $this->id)
            ->first();

        if ($data) {
            $locales['name'] = $data->name;
            $locales['id'] = $data->id;
        }

        return $locales;
    }
}
