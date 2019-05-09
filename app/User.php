<?php

namespace App;

use Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use App\Traits\UsesUuid;

class User extends Authenticatable implements MustVerifyEmail
{
    use UsesUuid, HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'phone', 'verified', 'email_token','image_id', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function image()
    {
        return $this->hasOne('App\Image', 'id', 'image_id')->withDefault(function ($image) {
            $image->url = '/icons/user.svg';
            $image->is_default = true;
        });
    }

    /**
     * Checks if the password is correct
     *
     * @param String $password
     * @return boolean
     */
    public function check_password(String $password): bool
    {
        return Auth::attempt(['email' => $this->email, 'password' => $password]);
    }
}
