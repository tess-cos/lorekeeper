<?php

namespace App\Http\Controllers;

use Auth;
use DB;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\SitePage;

class PageController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Page Controller
    |--------------------------------------------------------------------------
    |
    | Displays site pages, editable from the admin panel.
    |
    */

    /**
     * Shows the page with the given key.
     *
     * @param  string  $key
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getPage($key)
    {
        $page = SitePage::where('key', $key)->where('is_visible', 1)->first();
        if(!$page) abort(404);

        // replace <p>@dialogue(int)</p> with view('components.dialogue', ['id' => 'int'])
        $text = preg_replace('/<p>@dialogue\(([0-9]+)\)<\/p>/', ''.view("components.dialogue", ["id" => "$1"]).'', $page->parsed_text);

        return view('pages.page', ['page' => $page, 'text' => $text]);
    }
    

    /**
     * Shows the credits page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getCreditsPage()
    {
        return view('pages.credits', [
            'credits' => SitePage::where('key', 'credits')->first(),
            'extensions' => DB::table('site_extensions')->get()
        ]);
    }
    
}
