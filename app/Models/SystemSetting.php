<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class SystemSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'setting_group',
        'setting_key',
        'setting_value',
        'is_encrypted',
    ];

    protected $casts = [
        'is_encrypted' => 'boolean',
    ];

    public static function get($key, $group = 'site', $default = null)
    {
        $setting = self::where('setting_group', $group)
            ->where('setting_key', $key)
            ->first();
        if ($setting) {
            if ($setting->is_encrypted && $setting->setting_value) {
                try {
                    return Crypt::decryptString($setting->setting_value);
                } catch (\Exception $e) {
                    return $setting->setting_value;
                }
            }
            return $setting->setting_value;
        }
        return $default;
    }

    public static function set($key, $value, $group = 'site', $encrypt = false)
    {
        $setting = self::firstOrNew([
            'setting_group' => $group,
            'setting_key' => $key,
        ]);

        if ($encrypt && $value) {
            $setting->setting_value = Crypt::encryptString($value);
            $setting->is_encrypted = true;
        } else {
            $setting->setting_value = $value;
            $setting->is_encrypted = false;
        }
        $setting->save();
    }
}
