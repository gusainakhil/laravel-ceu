<?php

namespace App\Http\Controllers;

use App\Models\Speaker;
use Illuminate\Http\Request;

class SpeakerController extends Controller
{
    public function index()
    {
        $speakers = Speaker::where('status', 1)->get();
        return view('speakers.index', compact('speakers'));
    }

    public function show(Speaker $speaker)
    {
        abort_unless((int) $speaker->status === 1, 404);

        return view('speakers.show', compact('speaker'));
    }

    public function become()
    {
        return view('speakers.become');
    }
}
