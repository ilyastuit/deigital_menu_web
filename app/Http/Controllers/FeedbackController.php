<?php

namespace App\Http\Controllers;

use App\Feedback;

class FeedbackController extends Controller
{
    public function index(Feedback $feedback)
    {
        if(auth()->user()->hasRole('admin')) {
            return view('feedbacks.index', ['feedbacks' => $feedback::with('restaurant')->paginate(10)]);
        }
    }
}
