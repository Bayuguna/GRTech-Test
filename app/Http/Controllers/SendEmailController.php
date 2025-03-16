<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\Mail;

class SendEmailController extends Controller
{
    public static function sendEmail()
    {
        $data = [
            'header' => 'The new employee has been successfully created.',
            'body' => 'Name: John Doe Email',
            'footer' => 'Thank you for using our application.'
        ];

        Mail::to(config('mail.to.address'))->send(new SendEmail($data));
    }

    public static function sendEmailNewEmployee($request)
    {
        $data = [
            'header' => 'The new employee has been successfully created.',
            'body' => 'Name: ' . @$request->name,
            'footer' => 'Thank you for using our application.'
        ];

        Mail::to(config('mail.to.address'))->send(new SendEmail($data));
    }

    public static function sendEmailNewUser($request)
    {
        $data = [
            'header' => 'The new user has been successfully created.',
            'body' => 'Name: ' . @$request->name . ' Email: ' . @$request->email . ' Phone: ' . @$request->phone . '<br/> <br/> will be added to the the company ' . @$request->company->name . '.',
            'footer' => 'Thank you for using our application.'
        ];

        Mail::to(config('mail.to.address'))->send(new SendEmail($data));
    }
}