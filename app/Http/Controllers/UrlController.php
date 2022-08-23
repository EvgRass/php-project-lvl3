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
                        ->select('urls.id', 'urls.name', DB::raw('max(url_checks.created_at) as last_check'),
                            DB::raw('max(url_checks.status_code) as status_code'))
                            ->leftJoin('url_checks', 'urls.id', '=', 'url_checks.url_id')
                            ->groupBy('urls.name', 'urls.id')
                            ->orderBy('urls.id')
                            ->get();

        return view('urls.index', compact('urls'));
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
        $checks = DB::table('url_checks')->where('url_id', $id)->get();
        return view('urls.show', compact('url', 'checks'));
    }
}
