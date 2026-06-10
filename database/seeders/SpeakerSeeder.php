<?php

namespace Database\Seeders;

use App\Models\Speaker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpeakerSeeder extends Seeder
{
    public function run(): void
    {
        // Truncate existing speakers
        if (config('database.default') === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = OFF;');
        } else {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        }
        
        Speaker::query()->delete();
        
        if (config('database.default') === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = ON;');
        } else {
            DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
        }

        $con = mysqli_connect("68.178.236.80", "ceuservice", "@{+A_gh8RIkQ", "ceuservicesD");
        if (!$con) {
            return;
        }

        $res = mysqli_query($con, "SELECT id, name, email, designation, bio, images FROM speaker_info");
        if (!$res) {
            mysqli_close($con);
            return;
        }

        while ($row = mysqli_fetch_assoc($res)) {
            $id = $row['id'];
            $name = trim($row['name']);
            if (empty($name)) continue;

            $email = trim($row['email']);
            if (empty($email)) {
                $email = "speaker_" . $id . "@ceutrainers.com";
            }

            $designation = trim($row['designation'] ?? 'Expert Speaker');
            $bio = trim($row['bio'] ?? '');
            $photo = trim($row['images'] ?? '');

            // Create or update the Speaker record with the matching remote ID
            Speaker::updateOrCreate(
                ['id' => $id],
                [
                    'name' => $name,
                    'email' => $email,
                    'phone' => null,
                    'designation' => $designation,
                    'bio' => $bio,
                    'image' => $photo,
                    'resume' => null,
                    'is_verified' => 1,
                    'status' => 1,
                ]
            );
        }

        mysqli_close($con);
    }
}
