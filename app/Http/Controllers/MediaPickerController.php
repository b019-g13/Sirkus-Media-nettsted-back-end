<?php

namespace App\Http\Controllers;

use App\Image;
use App\ImageSize;
use Illuminate\Http\Request;
use ImageEditor;
use Log;
use Storage;

class MediaPickerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:superadmin|admin|moderator');
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

    public function store(Request $request)
    {
        $user = $request->user();

        $uploaded_file = null;

        if ($request->has('upload_medium')) {
            $uploaded_file = $request->file('upload_medium');
        }

        if ($uploaded_file === null) {
            return false;
        }

        try {
            // Don't process files that are too large (8mb)...
            // This acts as a fallback. We should validate before sending it to this method
            $image_size_mb = $uploaded_file->getSize() / (1000 * 1000);
            if ($image_size_mb > 8) {
                return false;
            }

            // Create image
            $image = new Image;
            // $image->size_name = 'full';
            $image->user_id = $user->id;
            $image->attribute_alt = $user->name . ' media';
            $image->url = 'media/full/' . str_random(20) . '.jpg';
            $image->privacy = 0;
            $image->image_size_id = ImageSize::first()->id;

            // Resize image
            $edited_image = ImageEditor::make($uploaded_file);
            $edited_image->fit(512, 512, function ($constraint) {
                $constraint->upsize();
            });
            $edited_image->orientate();

            // Upload image, convert it to jpg, and compress it slightly
            // Storage::put($image->url, $edited_image->stream('jpg', 90)->__toString());
            Storage::disk('public')->put($image->url, $edited_image->stream('jpg', 90)->__toString());

            // Set image sizes
            // $image->size_width = $edited_image->width();
            // $image->size_height = $edited_image->height();
            $image->save();

            return $image;
        } catch (\Intervention\Image\Exception\NotReadableException $e) {
            Log::error('NotReadableException');
            Log::error($uploaded_file);
            Log::error($e);
        } catch (Exception $e) {
            Log::error($e);
        }

        dd($request->all());
        return false;
    }
}
