<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

Use App\Link;

class LinkController extends Controller
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
        $links = Link::paginate(30);
         return $links;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $links = Link::All();
        return $links;
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
            'name'=>'required|string',
            'value'=> 'required|string',
            'page_id'=> 'nullable|uuid'
        ]);
            $link = new Link([
            'name' => $request->get('name'),
            'value' => $request->get('value'),
            'page_id' => $request->get('page_id')
            ]);
            $link->save(); 
            return redirect('/links')->with('Success', 'Link is created');    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Link $link)
    {
        $link->menus;
        $link->component_fields;
        $link->page;
         return $link;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $link = Link::find($id);
        return $link;
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
            'value' => 'required|string',
            'page_id' => 'nullable|uuid'
        ]);
        $link = Link::find($id);
        $link->name = $request->get('name');
        $link->value = $request->get('value');
        $link->page_id = $request->get('page_id');
        $link->save();
        
        return redirected('/links')->with('Success', 'Link is updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $link = Link::find($id);
        $link->delete();
        return redirect('/links')->with('Success', 'Link is deleted successfully');
    }
}
