<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class UrlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $urls = DB::table('urls')
                        ->orderBy('id')
                        ->get();
        // $checks = DB::table('url_checks')->orderBy('url_id', 'asc')->orderBy('created_at', 'desc')->distinct('url_id')->get();
        // $lastCheck = $checks->keyBy('url_id');
        return view('urls.index', compact('urls'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $url = $request->input('url');

        $validator = Validator::make($url, [
                        'name' => 'required|url|max:255'
                    ]);
        
        if ($validator->fails()) {
            flash('Некорректный адрес сайта!')->error();
            return redirect()->route('main');
        }

        $urlData = parse_url(strtolower($url['name']));
        $newUrl = "{$urlData['scheme']}://{$urlData['host']}";
        
        $url = DB::table('urls')
                    ->where('name', $newUrl)
                    ->first();

        if (!is_null($url)) {
            flash("Страница уже существует")->info();
            $id = $url->id;
        } else {
            $id = DB::table('urls')
                        ->insertGetId([
                            'name' => $newUrl,
                            'created_at' => Carbon::now()
                        ]);
            flash('Сайт успешно добавлен!')->success();
        }

        return redirect()->route('urls.show', $id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $url = DB::table('urls')->find($id);
        return view('urls.show', compact('url'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
