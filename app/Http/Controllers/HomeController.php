<?php

namespace App\Http\Controllers;

use App\Models\Industry;
use App\Models\Course;
use App\Models\Speaker;
use App\Models\Faq;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Industry::where('status', 1)->limit(4)->get();
        $speakers = Speaker::where('status', 1)->limit(4)->get();
        $courses = Course::with(['industry', 'speaker'])
            ->where('status', 'published')
            ->orderByDesc('event_date')
            ->orderByDesc('event_time')
            ->limit(3)
            ->get();
        $faqs = Faq::where('status', 1)->orderBy('sort_order')->get();
        $testimonials = Testimonial::where('status', 1)->orderBy('sort_order')->latest()->get();

        return view('home.index', compact('categories', 'speakers', 'courses', 'faqs', 'testimonials'));
    }

    public function termsCondition()
    {
        return view('pages.terms-condition');
    }

    public function privacyPolicy()
    {
        return view('pages.privacy-policy');
    }

    /**
     * Generate dynamic XML Sitemap for search engine indexation.
     */
    public function sitemap()
    {
        $courses = Course::where('status', 'published')->get();
        $speakers = Speaker::where('status', 1)->get();
        
        $urls = [];
        
        // Add static routes
        $urls[] = [
            'loc' => route('home'),
            'lastmod' => now()->startOfDay()->toAtomString(),
            'changefreq' => 'daily',
            'priority' => '1.0'
        ];
        
        $urls[] = [
            'loc' => route('subscription.index'),
            'lastmod' => now()->startOfWeek()->toAtomString(),
            'changefreq' => 'weekly',
            'priority' => '0.8'
        ];
        
        $urls[] = [
            'loc' => route('webinar.index'),
            'lastmod' => now()->startOfDay()->toAtomString(),
            'changefreq' => 'daily',
            'priority' => '0.9'
        ];
        
        $urls[] = [
            'loc' => route('speakers.index'),
            'lastmod' => now()->startOfWeek()->toAtomString(),
            'changefreq' => 'weekly',
            'priority' => '0.7'
        ];
        
        $urls[] = [
            'loc' => route('faq.index'),
            'lastmod' => now()->startOfWeek()->toAtomString(),
            'changefreq' => 'monthly',
            'priority' => '0.5'
        ];
        
        $urls[] = [
            'loc' => route('contact.index'),
            'lastmod' => now()->startOfWeek()->toAtomString(),
            'changefreq' => 'monthly',
            'priority' => '0.5'
        ];

        // Add dynamic course detail routes
        foreach ($courses as $course) {
            $urls[] = [
                'loc' => route('course.show', $course->slug),
                'lastmod' => ($course->updated_at ?? now())->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.8'
            ];
        }

        // Add dynamic speaker detail routes
        foreach ($speakers as $speaker) {
            $urls[] = [
                'loc' => route('speakers.show', $speaker->id),
                'lastmod' => ($speaker->updated_at ?? now())->toAtomString(),
                'changefreq' => 'monthly',
                'priority' => '0.6'
            ];
        }

        // Generate dynamic standard XML Sitemap
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        
        foreach ($urls as $url) {
            $xml .= '<url>';
            $xml .= '<loc>' . htmlspecialchars($url['loc']) . '</loc>';
            $xml .= '<lastmod>' . $url['lastmod'] . '</lastmod>';
            $xml .= '<changefreq>' . $url['changefreq'] . '</changefreq>';
            $xml .= '<priority>' . $url['priority'] . '</priority>';
            $xml .= '</url>';
        }
        
        $xml .= '</urlset>';

        return response($xml, 200, [
            'Content-Type' => 'application/xml',
            'Cache-Control' => 'public, max-age=3600'
        ]);
    }
}
