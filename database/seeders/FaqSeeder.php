<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        // Truncate existing
        Faq::query()->delete();
        FaqCategory::query()->delete();

        $categories = [
            'General Questions' => 1,
            'Academics & CEU Credits' => 2,
            'Billing & Refunds' => 3,
        ];

        $catModels = [];
        foreach ($categories as $name => $order) {
            $catModels[$name] = FaqCategory::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'status' => 1,
                'sort_order' => $order,
            ]);
        }

        $faqs = [
            [
                'category_name' => 'General Questions',
                'question' => 'How do I join a live webinar?',
                'answer' => 'Once you register or enroll in a live webinar course, a secure link will be provided under your profile panel. You will also receive an email invitation 24 hours prior and 1 hour before the scheduled start time containing the access link.',
                'sort_order' => 1,
            ],
            [
                'category_name' => 'Academics & CEU Credits',
                'question' => 'Are course certificates recognized by professional organizations?',
                'answer' => 'Yes! All courses offered by CEUTrainers are designed in tandem with professional accreditation organizations in the HR, BFSI, Payroll, and Construction sectors. Continuing Education Units (CEUs) are fully recognized and can be claimed towards professional recertifications.',
                'sort_order' => 2,
            ],
            [
                'category_name' => 'General Questions',
                'question' => 'Can I access courses after they conclude?',
                'answer' => 'Absolutely. If you are registered in a Live Webinar, the recording will automatically be made available in your account as an "On-Demand" webinar within 24 to 48 hours. On-demand courses and eTranscripts have lifetime access once acquired.',
                'sort_order' => 3,
            ],
            [
                'category_name' => 'Billing & Refunds',
                'question' => 'What is your refund policy?',
                'answer' => 'We offer a 100% satisfaction guarantee. If you are unable to attend a live webinar or find that a course does not meet your professional educational requirements, you can request a full refund or exchange credits within 14 days of purchase.',
                'sort_order' => 4,
            ],
        ];

        foreach ($faqs as $faq) {
            $cat = $catModels[$faq['category_name']] ?? null;
            Faq::create([
                'category_id' => $cat ? $cat->id : null,
                'question' => $faq['question'],
                'answer' => $faq['answer'],
                'sort_order' => $faq['sort_order'],
                'status' => 1,
            ]);
        }
    }
}
