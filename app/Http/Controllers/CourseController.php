<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CoursePricing;
use App\Models\Faq;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function show($slug)
    {
        $course = Course::with(['industry', 'speaker'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Fetch up to 3 related courses in the same industry, excluding current
        $relatedCourses = Course::with(['industry', 'speaker'])
            ->where('industry_id', $course->industry_id)
            ->where('id', '!=', $course->id)
            ->where('status', 'published')
            ->limit(3)
            ->get();

        // Fetch course-specific registration pricing from course_pricing
        $options = CoursePricing::where('course_id', $course->id)
            ->where('status', 1)
            ->orderBy('sort_order')
            ->get();

        // Group options by their category
        $groupedOptions = [];
        foreach ($options as $option) {
            $groupedOptions[$option->category][$option->label] = (float)$option->price;
        }

        $faqs = Faq::where('status', 1)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('course.show', compact('course', 'relatedCourses', 'groupedOptions', 'faqs'));
    }
}
