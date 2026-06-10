<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Speaker;
use App\Models\Industry;
use App\Models\CoursePricing;
use App\Models\RegistrationOptionTemplateItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        // Truncate existing courses and pricing
        if (config('database.default') === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = OFF;');
        } else {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        }

        CoursePricing::query()->delete();
        Course::query()->delete();

        if (config('database.default') === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = ON;');
        } else {
            DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
        }

        $con = mysqli_connect("68.178.236.80", "ceuservice", "@{+A_gh8RIkQ", "ceuservicesD");
        if (!$con) {
            return;
        }

        // Fetch all course records
        $res = mysqli_query($con, "SELECT id, industries, speaker, title, description, date, time, duration, course_thumbail, selling_option, slug, status FROM course_detail");
        if (!$res) {
            mysqli_close($con);
            return;
        }

        $insertedSlugs = [];

        // Dynamic scaling rules to copy blueprint options to individual courses
        $scaleRules = [
            '1 Attendee' => ['mult' => 1.0, 'off' => 0.0],
            '2 Attendees (Save $45)' => ['mult' => 2.0, 'off' => -45.0],
            '3 Attendees (Get 3 On Demands FREE)' => ['mult' => 3.0, 'off' => -100.0],
            '4 Attendees (Get 4 On Demands FREE)' => ['mult' => 4.0, 'off' => -175.0],
            '5 Attendees (Get 5 On Demands FREE)' => ['mult' => 5.0, 'off' => -240.0],
            'On Demand' => ['mult' => 1.0, 'off' => 0.0],
            'e-Transcript' => ['mult' => 1.0, 'off' => 15.0],
            'Live + On Demand' => ['mult' => 1.0, 'off' => 90.0],
            'Live + e-Transcript' => ['mult' => 1.0, 'off' => 100.0],
            'On Demand + e-Transcript' => ['mult' => 1.0, 'off' => 80.0],
            'Live + On Demand + e-Transcript' => ['mult' => 1.0, 'off' => 190.0],
            '6 Attendees (6 ODs & 6 Transcripts FREE)' => ['mult' => 6.0, 'off' => -295.0],
            '7 Attendees (7 ODs & 7 Transcripts FREE)' => ['mult' => 7.0, 'off' => -360.0],
        ];

        // Fetch standard blueprint template items
        $templateItems = RegistrationOptionTemplateItem::where('template_id', 1)->get();

        while ($row = mysqli_fetch_assoc($res)) {
            $id = $row['id'];
            $title = trim($row['title']);
            if (empty($title)) continue;

            $description = trim($row['description'] ?? '');
            $duration = (int) ($row['duration'] ?? 60);
            $slug = trim($row['slug'] ?? '');
            if (empty($slug)) {
                $slug = Str::slug($title);
            }

            if (in_array($slug, $insertedSlugs)) {
                $slug = $slug . '-' . $id;
            }
            $insertedSlugs[] = $slug;

            // Extract price using robust regex matching
            $sellingOption = $row['selling_option'] ?? '';
            $price = 185.00; // Default base price
            if (preg_match('/\'1 Attendee\'\s*=>\s*\'(\d+)\'/i', $sellingOption, $matches)) {
                $price = (float) $matches[1];
            } elseif (preg_match('/"1 Attendee"\s*=>\s*"(\d+)"/i', $sellingOption, $matches)) {
                $price = (float) $matches[1];
            } elseif (preg_match('/\'On Demand\'\s*=>\s*\'(\d+)\'/i', $sellingOption, $matches)) {
                $price = (float) $matches[1];
            } elseif (preg_match('/"On Demand"\s*=>\s*"(\d+)"/i', $sellingOption, $matches)) {
                $price = (float) $matches[1];
            }

            // Map Industry ID
            $industryId = (int) ($row['industries'] ?? 2);
            $industryExists = Industry::where('id', $industryId)->exists();
            if (!$industryExists) {
                $industryId = 2; // Default fallback to HR
            }

            // Map Speaker ID
            $speakerId = (int) ($row['speaker'] ?? 1);
            $speakerExists = Speaker::where('id', $speakerId)->exists();
            if (!$speakerExists) {
                $firstSpeaker = Speaker::first();
                $speakerId = $firstSpeaker ? $firstSpeaker->id : 1;
            }

            // Parse scheduled dates and times safely
            $dateStr = trim($row['date'] ?? '');
            $eventDate = null;
            $eventTime = null;
            if (!empty($dateStr)) {
                try {
                    $eventDate = Carbon::parse($dateStr);
                    if (!empty($row['time'])) {
                        $eventTime = trim($row['time']);
                    }
                } catch (\Exception $e) {
                    $eventDate = null;
                }
            }

            $status = $row['status'] == '1' ? 'published' : 'draft';
            $thumbnail = trim($row['course_thumbail'] ?? '');

            // Create the course in v4 courses table
            $course = Course::updateOrCreate(
                ['id' => $id],
                [
                    'industry_id' => $industryId,
                    'speaker_id' => $speakerId,
                    'title' => $title,
                    'slug' => $slug,
                    'short_description' => Str::limit(strip_tags($description), 200),
                    'description' => $description,
                    'certificate_text' => 'Successfully completed CEU credits certification requirements.',
                    'thumbnail' => $thumbnail,
                    'event_date' => $eventDate,
                    'event_time' => $eventTime,
                    'duration_minutes' => $duration,
                    'single_sale_enabled' => 1,
                    'subscription_enabled' => 1,
                    'default_price' => $price,
                    'currency' => 'USD',
                    'status' => $status,
                ]
            );

            // Populate course_pricing from templates dynamically
            foreach ($templateItems as $item) {
                $itemPrice = $item->price;
                if (isset($scaleRules[$item->label])) {
                    $rule = $scaleRules[$item->label];
                    $itemPrice = ($price * $rule['mult']) + $rule['off'];
                }
                if ($itemPrice < 0) {
                    $itemPrice = 0.00;
                }

                CoursePricing::create([
                    'course_id' => $course->id,
                    'template_item_id' => $item->id,
                    'category' => $item->category,
                    'label' => $item->label,
                    'attendees' => $item->attendees,
                    'price' => $itemPrice,
                    'compare_at_price' => $item->compare_at_price ? ($price * 2.0) : null,
                    'currency' => 'USD',
                    'description' => $item->description,
                    'sort_order' => $item->sort_order,
                    'status' => 1,
                ]);
            }
        }

        mysqli_close($con);
    }
}
