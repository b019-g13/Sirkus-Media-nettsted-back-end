<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Page;
use App\Image;
use Auth;
use Session;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth')->except('api_index', 'api_show');
    }

    public function index()
    {
        $pages = Page::paginate(30);
        return view('pages.index',compact('pages'));
    }

    public function api_index()
    {
        return Page::paginate(30);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pages = Page::All();
        $images = Image::All();
        return view('pages.create', compact(
            'pages',
            'images'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required|string',
            'image_id'=> 'nullable'
        ]);
        $page = new Page([
            'title' => $request->get('title'),
            'image_id'=> $request->get('image_id')
        ]);
          $page->save();
          return redirect('/pages')->with('success', 'Page er opprettet');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        $page->menu;
        $components = $page->components;
        foreach($components as $component){
            $component->fields;
        }
        return view('pages.show',compact('page'));
    }

    public function api_show(Page $page)
    {
        $page->menu;
        $components = $page->components;

        foreach($components as $component){
            $component->fields;
        }

        return $page;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = Page::find($id);
        $images = Image::All();
        return view('pages.edit', compact(
            'page',
            'images'
        ));
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
        $request->validate([
            'title'=>'required|string',
            'image_id'=> 'nullable',
          ]);

          $page = Page::find($id);
          $page->title = $request->get('title');
          $page->image_id = $request->get('image_id');
          $page->save();

          return redirect('/pages')->with('success', 'Page er oppdatert');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $page = Page::find($id);
        $page->delete();

     return redirect('/pages')->with('success', 'Page er slettet');
    }
}
