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
       $this->middleware('auth');
    }
   
    
    public function index()
    {
        $components = Component::paginate(30);
   
        return view('components.index',compact('components'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $components = Component::All();
        return view('components.create',compact('components'));
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
            'slug' => 'required|string',
            'order' => 'required|integer',
            'parent_id' => 'nullable'
        ]);
        $component = new Component([
            'name' => $request->get('name'),
            'slug' => $request->get('slug'),
            'order' => $request->get('order'),
            'parent_id' => $request->get('parent_id'),
        ]);
        $component->save();
        return redirect('/components')->with('success', 'Komponenten er opprettet');
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
        $component;
        return view('components.show', compact('component'));
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
        $components = Component::All();
        return view('components.edit',compact(
            'component',
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
            'name' => 'required|string',
            'slug' => 'required|string',
            'order' => 'required|integer',
            'parent_id' => 'nullable'
        ]);
        $component = Component::find($id);
        $component->name = $request->get('name');
        $component->slug = $request->get('slug');
        $component->order = $request->get('order');
        $component->parent_id = $request->get('parent_id');
        $component->save();
        return redirect('/components')->with('success', 'Komponenten er oppdatert');
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
        return redirect('/components')->with('success', 'Komponenten er slettet');
    }
}
