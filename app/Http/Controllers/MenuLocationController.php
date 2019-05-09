<?php

namespace App\Http\Controllers;

use App\MenuLocation;
use Illuminate\Http\Request;

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
        $this->middleware('verified');
        $this->middleware('role:superadmin');
    }

    public function index()
    {
        $menu_locations = MenuLocation::paginate(10);
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
            'name' => 'required|string|max:255',
        ]);

        $menu_location = new MenuLocation([
            'name' => $request->get('name'),
            'slug' => str_slug($request->get('name')),
        ]);
        $menu_location->save();
        return redirect()->route('menu_locations.index')->with('success', 'Meny plasseringen ble opprettet');
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
    public function edit(MenuLocation $menu_location)
    {
        return view('menu_locations.edit', compact('menu_location'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MenuLocation $menu_location)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $menu_location->name = $request->get('name');
        $menu_location->slug = str_slug($request->get('name'));
        $menu_location->save();
        return redirect()->route('menu_locations.index')->with('success', 'Meny plasseringen ble oppdatert');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(MenuLocation $menu_location)
    {
        $menu_location->delete();
        return redirect()->route('menu_locations.index')->with('success', 'Meny plasseringen ble slettet');
    }
}
