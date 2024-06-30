<?php

namespace App\Http\Controllers;

use App\Mail\Subscribed;
use App\Models\Subscribe;
use Illuminate\Support\Facades\Mail;

class SubscribeController extends Controller
{
    public function store()
    {
        $attributes = request()->validate([
            'email' => 'required|email|unique:subscribes',
        ],
            [
                'email.required' => 'Please enter your email address.',
                'email.email' => 'Please enter a valid email address.',
                'email.unique' => "This email address is already listed as a subscriber.",
            ]);

        $subscribe = Subscribe::create($attributes);
        $email = request()->email;
        // moil to email received and send the mail.thank-you-for-subscribing view
        Mail::to($email)->queue(new Subscribed($email));
        return response()->json(['message' => 'Thank you for subscribing!']);
        Inertia::render('Subscribed');
    }
}
