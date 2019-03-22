<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Field;

class FieldController extends Controller
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
        $fields = Field::paginate(30);
        return view('fields.index', compact('fields'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $fields = Field::All();
        return view('fields.create', compact('fields'));
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
        
        $field = new Field([
            'name' => $request->get('name'),
            'slug'=> str_slug($request->get('name'))
        ]);
        $field->save();
        return redirect()->route('fields.index')->with('success', 'Field er opprettet');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Field $field)
    {
        $field->components;
        return view('fields.show', compact('field'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $field = Field::find($id);
        return view('fields.edit', compact('field'));
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
        
        $field = Field::find($id);
        $field->name = $request->get('name');
        $field->slug = str_slug($request->get('name'));
        $field->save();
        return redirect()->route('fields.index')->with('success', 'Field er oppdatert');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $field = Field::find($id);
        $field->delete();
        return redirect()->route('fields.index')->with('success', 'Field er slettet');
    }
}
