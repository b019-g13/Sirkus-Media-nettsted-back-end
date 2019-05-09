<?php

namespace App\Http\Controllers;

use App\Component;
use App\ComponentField;
use App\Field;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
        $this->middleware('verified');
        $this->middleware('role:superadmin');
    }

    public function index()
    {
        $components = Component::orderBy('name')->paginate(30);

        return view('components.index', compact('components'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $components = Component::All();
        $fields = Field::All();

        return view('components.create', compact('components', 'fields'));
    }

    // Validation to run before changing the request
    protected function component_pre_validator(array $data)
    {
        $components = Component::pluck('id')->toArray();

        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'parent_id' => ['nullable', 'uuid', Rule::in($components)],
            'fields' => 'nullable|json',
        ]);
    }

    // Validation to run after changing the request
    protected function component_post_validator(array $data)
    {
        $available_fields = Field::pluck('id')->toArray();

        return Validator::make($data, [
            'slug' => 'required|string|max:255',
            'fields' => 'nullable|array',
            'fields.*' => ['required_with:fields', 'array'],
            'fields.*.id' => ['required_with:fields', 'uuid', Rule::in($available_fields)],
            'fields.*.nickname' => 'present|nullable|string',
            'fields.*.order' => 'required_with:fields|integer',
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
        $this->component_pre_validator($request->all())->validate();
        $request->merge(['slug' => str_slug($request->name)]);
        $request->merge(['fields' => json_decode($request->fields, true)]);
        $this->component_post_validator($request->all())->validate();

        $component = new Component;
        $component->name = $request->name;
        $component->slug = $request->slug;
        $component->parent_id = $request->parent_id;
        $component->save();

        foreach ($component->component_fields as $component_field) {
            $component_field->mark_for_deletion();
        }

        foreach ($request->fields as $field) {
            $component_field = new ComponentField;
            $component_field->component_id = $component->id;
            $component_field->field_id = $field['id'];
            $component_field->nickname = empty($field['nickname']) ? null : $field['nickname'];
            $component_field->order = $field['order'];
            $component_field->save();
        }

        return redirect()->route('components.index')->with('success', 'Komponenten ble opprettet');
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
    public function edit(Component $component)
    {
        $components = Component::All()->except($component->id);
        $fields = Field::All();

        return view('components.edit', compact('component', 'components', 'fields'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Component  $component
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Component $component)
    {

        $this->component_pre_validator($request->all())->validate();
        $request->merge(['slug' => str_slug($request->name)]);
        $request->merge(['fields' => json_decode($request->fields, true)]);
        $this->component_post_validator($request->all())->validate();

        $component->name = $request->name;
        $component->slug = $request->slug;
        $component->parent_id = $request->parent_id;
        $component->save();

        foreach ($component->component_fields as $component_field) {
            $component_field->mark_for_deletion();
        }

        foreach ($request->fields as $field) {
            $component_field = new ComponentField;
            $component_field->component_id = $component->id;
            $component_field->field_id = $field['id'];
            $component_field->nickname = empty($field['nickname']) ? null : $field['nickname'];
            $component_field->order = $field['order'];
            $component_field->save();
        }

        return redirect()->route('components.edit', $component)->with('success', 'Komponenten ble oppdatert');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Component $component)
    {
        $component->delete();
        return redirect()->route('components.index')->with('success', 'Komponenten ble slettet');
    }
}
