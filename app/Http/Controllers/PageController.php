<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        return Validator::make($data, [
            'slug' => 'required|string|max:255',
            'components' => 'nullable|array',
            'components.*' => ['required_with:components', 'array']
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

        // Setup components
        foreach ($request->components as $component) {
            $page->recursivelyCreatePageComponents($component);
        }

        return redirect()->route('pages.edit', $page)->with('success', 'Page er opprettet');
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

        return view('pages.show', compact('page'));
    }

    public function api_show(Page $page)
    {
        $api_page = new \stdClass;
        $api_page->id = $page->id;
        $api_page->title = $page->title;
        $api_page->image_id = $page->image_id;

        $api_page->menu = $page->menu;
        $api_page->components = $page->components_cleaned;

        return response()->json($api_page);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = Page::find($id);
        $images = Image::All();
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

        $this->page_pre_validator($request->all())->validate();
        $request->merge(['slug' => str_slug($request->title)]);
        $request->merge(['components' => json_decode($request->components, true)]);
        $this->page_post_validator($request->all())->validate();

        $page->title = $request->title;
        $page->image_id = $request->image_id;
        $page->save();

        // Delete all existing components
        foreach ($page->page_components as $page_component) {
            $page_component->delete();
        }

        // Setup components
        foreach ($request->components as $component) {
            $page->recursivelyCreatePageComponents($component);
        }

        return redirect()->route('pages.edit', $page)->with('success', 'Page er oppdatert');
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
