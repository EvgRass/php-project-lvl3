<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

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
        $host = DB::table('urls')
                    ->select('name')
                    ->where('id', $url_id)
                    ->first();

        $status = Http::get($host->name)->status();

        DB::table('url_checks')->insert([
            'url_id' => $url_id,
            'created_at' => Carbon::now(),
            'status_code' => $status
        ]);
        flash('Страница успешно проверена')->success();
        return redirect()->route('urls.show', $url_id);
    }
}
