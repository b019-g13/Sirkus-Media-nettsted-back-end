<?php

namespace App\Http\Controllers;

use App\Field;
use App\FieldType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
        $this->middleware('verified');
        $this->middleware('role:superadmin');
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
        $field_types = FieldType::All();
        return view('fields.create', compact('field_types'));
    }

    protected function field_pre_validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'field_type_id' => ['required', 'integer', 'max:65535', Rule::in(FieldType::pluck('id')->toArray())],
        ]);
    }

    protected function field_post_validator(array $data)
    {
        return Validator::make($data, [
            'slug' => 'required|string|max:255',
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
        $this->field_pre_validator($request->all())->validate();
        $request->merge(['slug' => str_slug($request->name)]);
        $this->field_post_validator($request->all())->validate();

        $field = new Field;
        $field->name = $request->name;
        $field->slug = $request->slug;
        $field->field_type_id = $request->field_type_id;
        $field->save();

        return redirect()->route('fields.index')->with('success', 'Feltet ble opprettet');
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
    public function edit(Field $field)
    {
        $field_types = FieldType::All();
        return view('fields.edit', compact('field', 'field_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Field $field)
    {
        $this->field_pre_validator($request->all())->validate();
        $request->merge(['slug' => str_slug($request->name)]);
        $this->field_post_validator($request->all())->validate();

        $field->name = $request->name;
        $field->slug = $request->slug;
        $field->field_type_id = $request->field_type_id;
        $field->save();

        return redirect()->route('fields.index')->with('success', 'Feltet ble oppdatert');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Field $field)
    {
        $field->delete();
        return redirect()->route('fields.index')->with('success', 'Feltet ble slettet');
    }
}
