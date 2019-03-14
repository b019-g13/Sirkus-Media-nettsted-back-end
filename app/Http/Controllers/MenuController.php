<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Menu;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
       $this->middleware('auth:api')->except('index','show');
    }

    public function index()
    {
        $menus = Menu::paginate(30);
        return $menus;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menus = Menu::All();
        return $menus;
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
            'name' => 'required|string',
            'global' => 'required|boolean',
            'page_id' => 'nullable|uuid',
            'menu_location_id' => 'required|integer'
        ]);    
        
        $menu = new Menu([
            'name' => $request->get('name'),
            'global' => $request->get('global'),
            'page_id' => $request->get('page_id'),
            'menu_location_id' => $request->get('menu_location_id')
        ]);
            $menu->save();
            return redirect('/menus')->with('Success', 'Menu is created successfully' );
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
        return $menu;
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
        return $menu;
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
            'name' => 'required|string',
            'global'=> 'required|boolean',
            'page_id' => 'nullable|uuid',
            'menu_location_id'=> 'required|integer'
        ]);

            $menu = Menu::find($id);
            $menu->name = $request->get('name');
            $menu->global = $request->get('global');
            $menu->page_id = $request->get('page_id');
            $menu->menu_location_id = $request->get('menu_location_id');
            $menu->save();
            return redirect('/menus')->with('Success', 'Menu is updated successfully');
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
        return redirect('/menus')->with('Success', 'Menu is deleted successfully');
    }
}
