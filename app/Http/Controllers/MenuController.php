<?php

namespace App\Http\Controllers;

use App\Link;
use App\Menu;
use App\MenuLink;
use App\MenuLocation;
use App\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
        $this->middleware('role:admin|superadmin|moderator')->except(['api_index', 'api_show']);
    }

    public function index()
    {
        $menus = Menu::paginate(30);
        return view('menus.index', compact('menus'));
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
        $menu_locations = MenuLocation::All();
        $pages = Page::All();
        $links = Link::All();

        return view('menus.create', compact(
            'pages',
            'menu_locations',
            'links'
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
        $this->menu_pre_validator($request->all())->validate();
        $request->merge(['links' => json_decode($request->links, true)]);

        if ($request->has('global') && $request->global === 'on') {
            $request->merge(['global' => true]);
        } else {
            $request->merge(['global' => false]);
        }
        $this->menu_post_validator($request->all())->validate();

        $menu = new Menu;
        $menu->name = $request->name;
        $menu->global = $request->global;
        $menu->menu_location_id = $request->menu_location_id;

        $menu->save();

        if ($menu->global) {
            $menu->page_id = null;
        } else {
            $menu->page_id = $request->page_id;
        }

        foreach ($request->links as $link) {
            $menu_link = new MenuLink;
            $menu_link->menu_id = $menu->id;
            $menu_link->link_id = $link['id'];
            $menu_link->order = $link['order'];
            $menu_link->save();
        }

        return redirect()->route('menus.edit', $menu)->with('success', 'Menu ble opprettet');
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
        return view('menus.show', compact('menu'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        $menu_locations = MenuLocation::All();
        $pages = Page::All();
        $links = Link::All();

        return view('menus.edit', compact(
            'menu',
            'pages',
            'menu_locations',
            'links'
        ));
    }

    // Validation to run before changing the request
    protected function menu_pre_validator(array $data)
    {
        $menu_locations = MenuLocation::pluck('id')->toArray();
        $pages = Page::pluck('id')->toArray();

        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'global' => 'nullable|string',
            'page_id' => ['nullable', 'uuid', Rule::in($pages)],
            'menu_location_id' => ['nullable', 'integer', Rule::in($menu_locations)],
            'links' => 'nullable|json',
        ]);
    }
    // Validation to run after changing the request
    protected function menu_post_validator(array $data)
    {
        $available_links = Link::pluck('id')->toArray();

        return Validator::make($data, [
            'global' => 'required|boolean',
            'links' => 'nullable|array',
            'links.*' => ['required_with:links', 'array'],
            'links.*.id' => ['required_with:links', 'uuid', Rule::in($available_links)],
            'links.*.order' => 'required_with:links|integer',
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {
        $this->menu_pre_validator($request->all())->validate();
        $request->merge(['links' => json_decode($request->links, true)]);

        if ($request->has('global') && $request->global === 'on') {
            $request->merge(['global' => true]);
        } else {
            $request->merge(['global' => false]);
        }
        $this->menu_post_validator($request->all())->validate();

        $menu->name = $request->name;
        $menu->global = $request->global;
        $menu->menu_location_id = $request->menu_location_id;

        if ($menu->global) {
            $menu->page_id = null;
        } else {
            $menu->page_id = $request->page_id;
        }

        $menu->save();

        foreach ($menu->menu_links as $link) {
            $link->delete();
        }

        foreach ($request->links as $link) {
            $menu_link = new MenuLink;
            $menu_link->menu_id = $menu->id;
            $menu_link->link_id = $link['id'];
            $menu_link->order = $link['order'];
            $menu_link->save();
        }

        return redirect()->route('menus.edit', $menu)->with('success', 'Menu er oppdatert');
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
