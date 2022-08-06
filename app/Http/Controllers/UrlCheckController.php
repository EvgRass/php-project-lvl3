<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

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
        DB::table('url_checks')->insert([
            'url_id' => $url_id,
            'created_at' => Carbon::now()
        ]);
        flash('Страница успешно проверена')->success();
        return redirect()->route('urls.show', $url_id);
    }
}
