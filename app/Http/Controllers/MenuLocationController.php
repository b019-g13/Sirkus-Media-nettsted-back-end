<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\MenuLocation;

class MenuLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {     
       $this->middleware('auth');
       $this->middleware('role:superadmin');
    }

    public function index()
    {
        $menu_locations = MenuLocation::paginate(30);
        return view('menu_locations.index', compact('menu_locations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menu_locations = MenuLocation::All();
        return view('menu_locations.create', compact('menu_locations'));
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
            'name' => 'required|string|max:255'  
        ]);
        
        $menu_location = new MenuLocation([
            'name' => $request->get('name'),
            'slug'=> str_slug($request->get('name'))
        ]);
        $menu_location->save();
        return redirect()->route('menu_locations.index')->with('success', 'Menu_location er opprettet');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(MenuLocation $menu_location)
    {
        $menu_location->menus;
        return view('menu_locations.show', compact('menu_location'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $menu_location = MenuLocation::find($id);
        return view('menu_locations.edit', compact('menu_location'));
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
            'name' => 'required|string|max:255' 
        ]);
        
        $menu_location = MenuLocation::find($id);
        $menu_location->name = $request->get('name');
        $menu_location->slug = str_slug($request->get('name'));
        $menu_location->save();
        return redirect()->route('menu_locations.index')->with('success', 'Menu_location er oppdatert');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $menu_location = MenuLocation::find($id);
        $menu_location->delete();
        return redirect()->route('menu_locations.index')->with('success', 'Menu_location er slettet');
    }
}
