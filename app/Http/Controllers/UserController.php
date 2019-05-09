<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:superadmin|admin')->only('index', 'destroy');
    }

    public function index(Request $request)
    {
        $users = User::all();
        return view('user.index', compact('users'));
    }

    public function show(Request $request)
    {
        $user = $request->user();
        return view('user.show', compact('user'));
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index')->with('success', 'Brukeren ble slettet');
    }

    protected function update_email_validator(array $data)
    {
        return Validator::make($data, [
            'current_password' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users']
        ]);
    }

    protected function update_password_validator(array $data)
    {
        return Validator::make($data, [
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed']
        ]);
    }

    protected function update_info_validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
        ]);
    }

    protected function update_image_validator(array $data)
    {
        return Validator::make($data, [
            'image' => ['required', 'image', 'dimensions:max_width=3000,max_height=3000', 'max:10000']
        ]);
    }
    protected function remove_image_validator(array $data)
    {
        return Validator::make($data, [
            'image_remove' => ['required', 'accepted']
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $session = $request->session();
        $error = false;
        $simple_changes = false;

        // Update email
        if ($request->filled('email') && $request->email != $user->email) {
            if ($user->check_password($request->current_password)) {
                $this->update_email_validator($request->all())->validate();

                $user->email = $request->email;
                $user->email_verified_at = null;
                $user->sendEmailVerificationNotification();
                $user->save();

                $session->flash('success', 'Din kontos e-post adresse ble oppdatert.');
                $session->flash('info', 'Du må bekrefte din nye e-post. En lenke har blitt sendt til deg.');
            } else {
                $error = true;
                $session->flash('error', 'Feil passord');
            }
        }

        // Update password
        if ($request->filled('new_password') && !$error) {
            if ($user->check_password($request->current_password)) {
                $this->update_password_validator($request->all())->validate();

                $user->password = Hash::make($request->new_password);
                $user->save();
    
                $session->flash('success', 'Din kontos passord ble oppdatert.');
            } else {
                $error = true;
                $session->flash('error', 'Feil passord');
            }
        }

        // Update name
        if ($request->filled('name') && !$error) {
            $this->update_info_validator($request->all())->validate();

            $user->name = $request->name;
            
            if ($user->save()) {
                $simple_changes = true;
            }
        }

        // Remove image
        if ($request->has('image_remove') && !$error) {
            $this->remove_image_validator($request->all())->validate();

            $user->image_id = null;
            $user->save();

            $simple_changes = true;
        }

        // Update image
        if ($request->has('image') && !$error) {
            $this->update_image_validator($request->all())->validate();

            $alt = $user->name . ' profilbilde';
            $image = Image::upload($user, $request->file('image'), 'profiles', 0, $alt, 256, 256, 60);

            if ($image === null) {
                $session->flash('error', 'Noe gikk galt. Vi kunne ikke laste opp bilde ditt.');
                $error = true;
            } else {
                $user->image_id = $image->id;
                $user->save();

                $simple_changes = true;
            }
        }

        if ($simple_changes && !$error) {
            $session->flash('success', 'Din konto ble oppdatert.');
        }

        return redirect()->route('user.show');
    }
}
