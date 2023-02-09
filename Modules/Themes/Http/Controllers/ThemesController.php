<?php

namespace Modules\Themes\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Settings\Entities\ContentManagement;
use Modules\User\Entities\User;
use Illuminate\Support\Facades\App;
use JoeDixon\Translation\Drivers\Translation;

class ThemesController extends Controller
{
    public function __construct(Translation $translation)
    {
        $this->translation = $translation;
    }

    public function getLandingPage(Request $request)
    {
        $skin = config('app.SITE_LANDING');
        $currency_symbol = config('app.CURRENCY_SYMBOL');
        $currency_code = config('app.CURRENCY_CODE');
        $user = $request->user();
        $content = ContentManagement::where('page', 'landing_page')->latest()->first();
        if (!empty($content)) {
            $content->description = unserialize($content->description);
        }

        return view('themes::' . $skin . '.home', compact(
            'user', 'currency_symbol', 'currency_code', 'content'
        ));

    }

    public function localize($locale)
    {

        $languages = $this->translation->allLanguages();
        $locale = $languages->has($locale) ? $locale : config('app.fallback_locale');

        App::setLocale($locale);

        session()->put('locale', $locale);

        return redirect()->back();
    }
}
