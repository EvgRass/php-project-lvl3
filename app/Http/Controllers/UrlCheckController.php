<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use DiDom\Document;

class UrlCheckController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, int $url_id)
    {
        $url = DB::table('urls')->find($url_id);
        abort_unless($url, 404);

        $host = DB::table('urls')
                    ->select('name')
                    ->where('id', $url_id)
                    ->first();

        $response = Http::get($host->name);
        $document = new Document($response->body());

        $h1 = optional($document->first('h1'))->text();
        $title = optional($document->first('title'))->text();
        $description = optional($document->first('meta[name=description]'))->getAttribute('content');

        DB::table('url_checks')->insert([
            'url_id' => $url_id,
            'created_at' => Carbon::now(),
            'status_code' => $response->status(),
            'h1' => $h1,
            'title' => $title,
            'description' => $description
        ]);
        flash('Страница успешно проверена')->success();
        return redirect()->route('urls.show', $url_id);
    }
}
