<?php

namespace App\Http\Controllers;

use App\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class SiteSettingController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except('api_index', 'api_show');
        $this->middleware('verified')->except('api_index', 'api_show');
        $this->middleware('role:superadmin|admin')->except('api_index', 'api_show');
    }

    /**
     * Display a listing of the site setting.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $site_settings = SiteSetting::paginate(10);
        return view('site_settings.index', compact('site_settings'));
    }

    public function api_index()
    {
        return SiteSetting::paginate(100);
    }

    /**
     * Display the specified site setting.
     *
     * @param  SiteSetting $site_setting
     * @return \Illuminate\Http\Response
     */
    public function api_show(String $site_setting_name)
    {
        return SiteSetting::where('name', $site_setting_name)->firstOrFail();
    }

    /**
     * Show the form for creating a new site setting.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('site_settings.create');
    }

    protected function validator(array $data, $site_setting_id = null)
    {
        $name_rules = ['required', 'string', 'min:1', 'max:255'];

        if ($site_setting_id === null) {
            $name_unique_rule = Rule::unique('site_settings');
        } else {
            $name_unique_rule = Rule::unique('site_settings')->ignore($site_setting_id);
        }

        array_push($name_rules, $name_unique_rule);

        return Validator::make($data, [
            'name' => $name_rules,
            'value' => ['nullable', 'string', 'max:65535']
        ]);
    }

    /**
     * Store a newly created site setting in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();

        $site_setting = new SiteSetting;
        $site_setting->name = $request->name;
        $site_setting->value = $request->value;
        $site_setting->save();

        $request->session()->flash('success', 'Innstillingen ble opprettet.');
        return redirect()->route('site_settings.index');
    }

    /**
     * Show the form for editing the specified site setting.
     *
     * @param  SiteSetting $site_setting
     * @return \Illuminate\Http\Response
     */
    public function edit(SiteSetting $site_setting)
    {
        return view('site_settings.edit', compact('site_setting'));
    }

    /**
     * Update the specified site setting in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  SiteSetting $site_setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SiteSetting $site_setting)
    {
        $this->validator($request->all(), $site_setting->id)->validate();

        $site_setting->name = $request->name;
        $site_setting->value = $request->value;
        $site_setting->save();

        $request->session()->flash('success', 'Innstillingen ble opdatert.');
        return redirect()->route('site_settings.index');
    }

    /**
     * Remove the specified site setting from storage.
     *
     * @param  SiteSetting $site_setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, SiteSetting $site_setting)
    {
        $site_setting->delete();

        $request->session()->flash('success', 'Innstillingen ble slettet.');
        return redirect()->route('site_settings.index');
    }
}
