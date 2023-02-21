<?php

namespace App\Http\Controllers;

use App\Mail\ReturnBooks;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendMail()
    {
        Mail::to('khantnyeinzaw6@gmail.com')->send(new ReturnBooks());
    }
}
