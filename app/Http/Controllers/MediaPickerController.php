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
        $this->middleware('verified');
        $this->middleware('role:superadmin|admin|moderator');
    }

    public function show(Request $request)
    {
        $user = $request->user();
        $media = Image::where('privacy', 0)->where('user_id', $user->id)->orWhere('privacy', 1)->orderByDesc('created_at')->get();

        if ($request->ajax()) {
            return view('media-picker.show-content', compact('media'));
        }

        return view('media-picker.show', compact('media'));
    }

    public function show_refresh(Request $request)
    {
        $user = $request->user();
        $media = Image::where('privacy', 0)->where('user_id', $user->id)->orWhere('privacy', 1)->orderByDesc('created_at')->get();

        return view('media-picker.show-content-row', compact('media'));
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
            $image->attribute_alt = '';

            $ext = $uploaded_file->getClientOriginalExtension();

            $image->url = 'media/full/' . str_random(20) . '.' . $ext;
            $image->privacy = 1;
            $image->image_size_id = ImageSize::first()->id;

            if ($ext === 'svg') {
                // Upload image
                Storage::disk('public')->put($image->url, $uploaded_file->get());
            } else {

                // Resize image
                $edited_image = ImageEditor::make($uploaded_file);

                $edited_image->orientate();

                $edited_image->resize(1920, null, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $edited_image->resize(null, 1080, function ($constraint) {
                    $constraint->aspectRatio();
                });

                // Upload image
                Storage::disk('public')->put($image->url, $edited_image->stream($ext, 90)->__toString());
            }
            $image->save();

            return $image;
        } catch (\Intervention\Image\Exception\NotReadableException $e) {
            Log::error('NotReadableException');
            Log::error($uploaded_file);
            Log::error($e);
        } catch (Exception $e) {
            Log::error($e);
        }

        return false;
    }

    public function destroy(Request $request, $image)
    {
        $image = Image::findOrFail($image);
        $user = $request->user();

        if ($image->privacy === 0 && $image->user_id !== $user->id) {
            return abort(403);
        }

        $image->delete();
        return 'deleted';
    }
}
