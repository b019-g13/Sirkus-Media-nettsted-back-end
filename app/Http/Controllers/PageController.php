<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;

use App\Page;
use App\Image;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use HasRoles;

    public function __construct()
    {     
        $this->middleware('auth')->except(['api_index' , 'api_show']);
        $this->middleware(['role:superadmin|admin|moderator']);
    }

    public function index()
    {
        $pages = Page::paginate(30);
        return view('pages.index',compact('pages'));
    }

    public function api_index()
    {
        $pages = Page::paginate(30);
        return $pages;
    }

    public function api_show(Page $page){
        $page->menu;
        $components = $page->components;
        foreach($components as $component){
            $component->fields;
        }
        return $page;
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
        $components = Component::All();
        return view('pages.create', compact(
            'pages',
            'images',
            'components'
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
            'title'=>'required|string|max:255',
            'image_id'=> 'nullable'
        ]);
        $page = new Page([
            'title' => $request->get('title'),
            'image_id'=> $request->get('image_id')
        ]);
          $page->save();
          return redirect()->route('pages.index')->with('success', 'Page er opprettet');
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Gate::allows('web')){
            abort(404, "Access denied");
        }
        $page = Page::find($id);
        $images = Image::All();
        $components = Component::All();
        return view('pages.edit', compact(
            'page',
            'images',
            'components'
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
            'title'=>'required|string|max:255',
            'image_id'=> 'nullable',
          ]);
    
          $page = Page::find($id);
          $page->title = $request->get('title');
          $page->image_id = $request->get('image_id');
          $page->component_id = $request->get('name');
          $page->save();
    
          return redirect()->route('pages.index')->with('success', 'Page er oppdatert');
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

     return redirect()->route('pages.index')->with('success', 'Page er slettet');
    }
}
 