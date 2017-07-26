<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use App;
use App\Services\Web\LocaleService;
use App\Services\Web\EditorChoicesService;

class EditorChoicesComposer
{
    public function compose(View $view)
    {
        $currentLocale = LocaleService::getLocaleByIsoCode(App::getLocale());
        $editorChoices = EditorChoicesService::getEditorChoices($currentLocale->id);

        $view->with('editorChoices', $editorChoices);
    }
}
