<?php

namespace App\Http\Controllers;

use App\Link;
use App\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class LinkController extends Controller
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
    }

    protected function link_validator(array $data)
    {
        $pages = Page::pluck('id')->toArray();

        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'value' => 'nullable|string|max:255',
            'page_id' => ['nullable', 'uuid', Rule::in($pages)],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->link_validator($request->all())->validate();

        $link = new Link;
        $link->name = $request->name;
        $link->value = null;
        $link->page_id = null;

        if ($request->has('internal')) {
            $link->page_id = $request->page_id;
        } else if ($request->value == null) {
            $link->page_id = $request->page_id;
        } else {
            $link->value = $request->value;
        }

        $link->save();

        return redirect()->back()->with('success', 'Linken ble opprettet');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Link $link)
    {
        if ($request->ajax()) {
            return $link;
        }

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Link $link)
    {
        $this->link_validator($request->all())->validate();

        $link->name = $request->name;
        $link->value = null;
        $link->page_id = null;

        if ($request->has('internal')) {
            $link->page_id = $request->page_id;
        } else if ($request->value == null) {
            $link->page_id = $request->page_id;
        } else {
            $link->value = $request->value;
        }

        $link->save();

        return redirect()->back()->with('success', 'Linken ble oppdatert');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Link $link)
    {
        $link->delete();
        return redirect()->back()->with('success', 'Linken ble slettet');
    }
}
