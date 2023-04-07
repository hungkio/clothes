<?php

namespace App\Http\Controllers\Shop;

use App\Domain\Post\Models\Post;
use App\Enums\PostState;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\SchemaOrg\Schema;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth:web');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

    }

    public function search(Request $request)
    {

    }

    public function schemaMarkup()
    {
        return Schema::organization()
            ->url(config('app.url'))
            ->contactPoint(Schema::contactPoint()
                ->name(setting('store_name', null))
                ->description(setting('store_description', null))
                ->telephone(setting('store_phone', null))
                ->email(setting('store_email', null))
                ->image(Schema::imageObject()
                    ->url(\Storage::url(setting('store_logo')))
                    ->width('60')
                    ->height('60'))
            );
    }
}
