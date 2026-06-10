<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::with('category')
            ->where('status', 1)
            ->orderBy('sort_order')
            ->get();

        return view('faq.index', compact('faqs'));
    }
}
