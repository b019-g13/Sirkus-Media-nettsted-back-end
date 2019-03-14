<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Component;

class ComponentController extends Controller
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
        $components = Component::paginate(30);
        return  $components;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $components = Component::All();
        return $components;
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
            'slug' => 'requered|string',
            'order' => 'required|integer',
            'parent_id' => 'nullable|uuid'
        ]);
        $component = new Component([
            'name' => $request->get('name'),
            'slug' => $request->get('slug'),
            'order' => $request->get('order'),
            'parent_id' => $request->get('parent_id'),
        ]);
        $component->save();
        return redirect('/components')->with('success', 'Component is created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Component $component)
    {
        $component->fields;
        return  $component;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $component = Component::find($id);
        return $component;
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
            'slug' => 'required|string',
            'order' => 'required|integer',
            'parent_id' => 'nullable|uuid'
        ]);
        $component = Component::find($id);
        $component->name = $request->get('name');
        $component->slug = $request->get('slug');
        $component->order = $request->get('order');
        $component->parent_id = $request->get('parent_id');
        $component->save();
        return redirect('/components')->with('success', 'Component is updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $component = Component::find($id);
        $component->delete();
        return redirect('/components')->with('success', 'The component is deleted');
    }
}
