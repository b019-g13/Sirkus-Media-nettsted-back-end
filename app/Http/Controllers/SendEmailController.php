<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Mail;
use Session;

class SendEmailController extends Controller
{
    function index()
    {
        return view('emails.contact');
    }
    function send(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'companyName' => 'required',
            'email' => 'required|email',  
            'phone' => 'required',
            'bodyMessage' => 'required'
        ]);
        $data = array(
            'name' => $request->name,
            'companyName' => $request->companyName,
            'email' => $request->email,
            'phone' => $request->phone,
            'bodyMessage'=>$request->message
        );
        Mail::send('emails.send_email', $data, function($message) use($data){
            $message->from($data['email']);
            $message->to('bergoitomg@yahoo.com');
        });
        Session::flash('success', 'Eposten ble sendt');
        return redirect('/');
    }
}
