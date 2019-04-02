<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

use App\Page;
use App\Image;
use App\Field;
use App\Component;
use App\PageComponent;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use HasRoles;

    public function __construct()
    {     
        $this->middleware('auth')->except(['api_index' , 'api_show']);
        $this->middleware(['role:superadmin|admin|moderator']);

    public function __construct()
    {
        $this->middleware('auth')->except('api_index', 'api_show');
    }

    public function index()
    {
        $pages = Page::paginate(30);
        return view('pages.index',compact('pages'));
    }

    public function api_index()
    {
        return Page::paginate(30);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pages = Page::All();
        $images = Image::All();
        $components = Component::All();
        $components = Component::whereNull('parent_id')->get();

        return view('pages.create', compact(
            'pages',
            'images',
            'components'
        ));
    }

    protected function page_pre_validator(array $data)
    {
        return Validator::make($data, [
            'title' => 'required|string|max:255',
            'image_id' => 'nullable',
            'components' => 'nullable|json'
        ]);
    }

    protected function page_post_validator(array $data)
    {
        $field_ids = Field::pluck('id')->toArray();
        $component_ids = Component::pluck('id')->toArray();

        return Validator::make($data, [
            'slug' => 'required|string|max:255',
            'components' => 'nullable|array',
            'components.*' => ['required_with:components', 'array'],
            'components.*.id' => ['required_with:components', 'uuid', Rule::in($component_ids)],
            'components.*.order' => 'required_with:components|integer',
            'components.*.fields' => 'nullable|array',
            'components.*.fields.*.id' => ['required_with:components.*.fields', 'uuid', Rule::in($field_ids)],
            'components.*.children' => 'nullable|array',
            'components.*.children.*.id' => ['required_with:components.*.children', 'uuid', Rule::in($component_ids)]
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
        $this->page_pre_validator($request->all())->validate();
        $request->merge(['slug' => str_slug($request->title)]);
        $request->merge(['components' => json_decode($request->components, true)]);
        $this->page_post_validator($request->all())->validate();

        $page = new Page;
        $page->title = $request->get('title');
        $page->image_id = $request->get('image_id');
        $page->save();

        foreach ($page->components as $components) {
            $components->delete();
        }

        foreach ($request->components as $component) {
            $component = (object) $component;

            foreach ($component->fields as $field) {
                $field = (object) $field;

                $page_component = new PageComponent;
                $page_component->page_id = $page->id;
                $page_component->component_id = $component->id;
                $page_component->field_id = $field->id;
                $page_component->value = $field->value;
                $page_component->save();
            }
        }

        return redirect()->route('pages.index')->with('success', 'Page er opprettet');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        $page->menu;
        $components = $page->components;
        foreach($components as $component){
            $component->fields;
        }
        return view('pages.show',compact('page'));
    }

    public function api_show(Page $page)
    {
        $page->menu;
        $components = $page->components;

        foreach($components as $component){
            $component->fields;
        }

        return $page;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Gate::allows('web')){
            abort(404, "Access denied");
        }
        $page = Page::find($id);
        $images = Image::All();
        $components = Component::All();
        $components = Component::whereNull('parent_id')->get();

        return view('pages.edit', compact(
            'page',
            'images',
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
    public function update(Request $request, Page $page)
    {
        $request->validate([
            'title'=>'required|string|max:255',
            'image_id'=> 'nullable',
          ]);
    
          $page = Page::find($id);
          $page->title = $request->get('title');
          $page->image_id = $request->get('image_id');
          $page->component_id = $request->get('name');
          $page->save();
    
          return redirect()->route('pages.index')->with('success', 'Page er oppdatert');
        $this->page_pre_validator($request->all())->validate();
        $request->merge(['slug' => str_slug($request->title)]);
        $request->merge(['components' => json_decode($request->components, true)]);
        $this->page_post_validator($request->all())->validate();

        // $new_comps = $request->components;
        // // $new_comps[0]['fields'][0]['id'] = null;
        // $request->merge(['components' => $new_comps]);

        // dump($request->all());
        // $errors = $this->page_post_validator($request->all())->errors();
        // foreach ($errors->getMessages() as $value) {
        //     dump($value);
        // }
        // dd('');

        $page->title = $request->get('title');
        $page->image_id = $request->get('image_id');
        $page->save();

        foreach ($page->components as $components) {
            $components->delete();
        }

        foreach ($request->components as $component) {
            $component = (object) $component;

            foreach ($component->fields as $field) {
                $field = (object) $field;

                $page_component = new PageComponent;
                $page_component->page_id = $page->id;
                $page_component->component_id = $component->id;
                $page_component->field_id = $field->id;
                $page_component->value = $field->value;
                $page_component->save();
            }
        }

        return redirect()->route('pages.index')->with('success', 'Page er oppdatert');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $page = Page::find($id);
        $page->delete();

     return redirect()->route('pages.index')->with('success', 'Page er slettet');
    }
}
 