<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Component;
use App\ComponentField;
use App\Field;

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
        $fields = Field::All();
        return view('components.create', compact('components', 'fields'));
    }

    protected function store_validator(array $data)
    {
        $all_fields = Field::pluck('id')->toArray();

        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable',
            'fields' => 'nullable|array',
            'fields.*' => ['nullable', 'uuid', Rule::in($all_fields)]
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
        if ($request->has('fields')) {
            $request->merge(['fields' => explode(',', $request->fields)]);
        }

        $this->store_validator($request->all())->validate();

        $component = new Component;
        $component->name = $request->name;
        $component->slug = str_slug($request->name);
        $component->parent_id = $request->parent_id;
        $component->save();

        foreach ($request->fields as $field) {
            $component_field = new ComponentField;
            $component_field->component_id = $component->id;
            $component_field->field_id = $field;
            $component_field->order = 0;
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
            'name' => 'required|string|max:255',
            'order' => 'required|integer|min:0',
            'parent_id' => 'nullable'
        ]);
        $component = Component::find($id);
        $component->name = $request->get('name');
        $component->slug = str_slug($request->get('name'));
        $component->order = $request->get('order');
        $component->parent_id = $request->get('parent_id');
        $component->save();
        return redirect()->route('components.index')->with('success', 'Komponenten er oppdatert');
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
        return redirect()->route('components.index')->with('success', 'Komponenten er slettet');
    }
}
