<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Menu;
use App\Page;
use App\MenuLocation;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
       $this->middleware('auth')->except(['api_index', 'api_show']);
    }

    public function index()
    {
        $menus = Menu::paginate(30);
        return view('menus.index',compact('menus'));
    }

    public function api_index()
    {
        $menus = Menu::paginate(30);
        return $menus;
    }

    public function api_show(Menu $menu)
    {
        $menu->links;
        $menu->menu_location;
        return $menu;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menus = Menu::All();
        $locations = MenuLocation::All();
        $pages = Page::All();
        return view('menus.create', compact(
            'menus',
            'pages',
            'locations'
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
            'name' => 'required|string|max:255',
            'global' => 'required|boolean',
            'page_id' => 'nullable',
            'menu_location_id' => 'nullable|integer'
        ]);    
        
        $menu = new Menu([
            'name' => $request->get('name'),
            'global' => $request->get('global'),
            'page_id' => $request->get('page_id'),
            'menu_location_id' => $request->get('menu_location_id')
        ]);
            $menu->save();
            return redirect()->route('menus.index')->with('success', 'Menu er opprettet' );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        $menu->links;
        $menu->menu_location;
        return view('menus.show',compact('menu'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $menu = Menu::find($id);
        $locations = MenuLocation::All();
        $pages = Page::All();
        return view('menus.edit', compact(
            'menu',
            'pages',
            'locations'
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
            'name' => 'required|string|max:255',
            'global'=> 'required|boolean',
            'page_id' => 'nullable',
            'menu_location_id'=> 'nullable|integer'
        ]);

            $menu = Menu::find($id);
            $menu->name = $request->get('name');
            $menu->global = $request->get('global');
            $menu->page_id = $request->get('page_id');
            $menu->menu_location_id = $request->get('menu_location_id');
            $menu->save();
            return redirect()->route('menus.index')->with('success', 'Menu er oppdatert');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $menu = Menu::find($id);
        $menu->delete();
        return redirect()->route('menus.index')->with('success', 'Menu er slettet');
    }
}
