<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Http\Request;

class MediaPickerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Request $request)
    {
        $user = $request->user();
        $media = Image::where('privacy', 0)->orWhere('privacy', 1)->where('user_id', $user->id)->get();

        if ($request->ajax()) {
            return view('media-picker.show-content', compact('media'));
        }

        return view('media-picker.show', compact('media'));
    }
}
