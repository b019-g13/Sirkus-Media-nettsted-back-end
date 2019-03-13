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
       $this->middleware('auth:api')->except('index','show');
    }

    public function index()
    {
        $field = Field::paginate(30);
        return $field;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $field = Field::All();
        return $field;
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
            'slug' => 'required|string'   
        ]);
        
        $field = new Field([
            'name' => $request->get('name'),
            'slug' => $request->get('slug')
        ]);
        $field->save();
        return redirect('/fields')->with('Success', 'Field is created successfully');
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
        return $field;
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
        return $field;
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
            'slug' => 'required|string'   
        ]);
        
        $field = Field::find($id);
        $field->name = $request->get('name');
        $field->slug = $request->get('slug');
        $field->save();
        return redirect('/fields')->with('Success', 'Field is updated successfully');
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
        $field->save();
        return redirect('/fields')->with('Success', 'Field is deleted successfully');
    }
}
