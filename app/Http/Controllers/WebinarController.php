<?php

namespace App\Http\Controllers;

use App\Models\Industry;
use App\Models\Course;
use Illuminate\Http\Request;

class WebinarController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::with(['industry', 'speaker'])->where('status', 'published');

        // Filter by Search Query
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by Industry
        if ($request->filled('industry')) {
            $query->where('industry_id', $request->input('industry'));
        }

        // Filter by Date
        if ($request->filled('date_filter')) {
            $dateFilter = $request->input('date_filter');
            if ($dateFilter === 'upcoming') {
                $query->where('event_date', '>=', now()->toDateString());
            } elseif ($dateFilter === 'past') {
                $query->where('event_date', '<', now()->toDateString());
            }
        }

        $courses = $query
            ->orderByDesc('event_date')
            ->orderByDesc('event_time')
            ->paginate(20)
            ->withQueryString();
        $categories = Industry::where('status', 1)->get();

        return view('webinar.index', compact('courses', 'categories'));
    }
}
