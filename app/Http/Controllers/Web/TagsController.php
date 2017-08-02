<?php

namespace App\Http\Controllers\Web;

use App\Events\LogViewTagEvent;
use App\Models\TagLocale;
use App\Services\Web\TagService;
use App\Models\Tag;

class TagsController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function show($tagName)
    {
        $tagLocale = TagLocale::where('name', $tagName)->first();

        if ($tagLocale) {
            $this->viewData['articles'] = TagService::getArticleByTag($tagLocale->tag, $this->currentLocaleId);
            $this->viewData['tagLocale'] = $tagLocale;

            event(new LogViewTagEvent($tagLocale->tag, $this->currentLocaleId));

            return view('web.tags.show', $this->viewData);
        } else {
            return response(trans('web/global.error'), 404);
        }
    }
}
