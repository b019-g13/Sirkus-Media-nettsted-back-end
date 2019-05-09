<?php

namespace App;

use Storage;
use ImageEditor;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use Traits\UsesUuid;

    public $appends = [
        'url_full',
    ];

    // kobling til user
    public function user()
    {
        return $this->hasOne('App\User');
    }

    // Kobling til image_sizes
    public function image_size()
    {
        return $this->hasOne('App\ImageSize');
    }

    public function getUrlFullAttribute()
    {
        if (isset($this->is_default) && $this->is_default) {
            return asset($this->url);
        }

        return asset('storage/' . $this->url);
    }

    public static function upload(
        User $user,
        $uploaded_file,
        String $path,
        int $privacy = 0,
        String $attribute_alt = '',
        int $max_width = 1920,
        int $max_height = 1920,
        int $quality = 90
    ) : ? Image
    {
        if ($uploaded_file === null) {
            return null;
        }

        try {
            // Don't process files that are too large (10mb)...
            // This acts as a fallback. We should validate before sending it to this method
            $image_size_mb = $uploaded_file->getSize() / (1000*1000);
            if ($image_size_mb > 10) {
                return null;
            }
            
            // Make image path/url
            $ext = $uploaded_file->getClientOriginalExtension();
            $image_url = $path . '/' . str_random(20) . '.' . $ext;
            
            // Create image
            $image = new Image;
            $image->user_id = $user->id;
            $image->url = $image_url;
            $image->attribute_alt = '';
            $image->privacy = $privacy;
            $image->image_size_id = 1;

            // Resize image
            $edited_image = ImageEditor::make($uploaded_file);

            // Make sure the image is the correct orientation
            $edited_image->orientate();

            // Resize and crop
            $edited_image->fit($max_width, $max_height, function ($constraint) {
                $constraint->upsize();
            });

            // Save the image
            Storage::disk('public')->put($image->url, $edited_image->stream($ext, $quality)->__toString());
            
            // Everything went well, let's put the image in the db
            $image->save();

            return $image;
        } catch (Exception $e) {
            report($e);
        }

        return null;
    }
}
