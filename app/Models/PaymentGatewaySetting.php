<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class PaymentGatewaySetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'gateway_id',
        'setting_key',
        'setting_value',
        'is_encrypted',
    ];

    protected $casts = [
        'is_encrypted' => 'boolean',
    ];

    public function gateway()
    {
        return $this->belongsTo(PaymentGateway::class, 'gateway_id');
    }

    public function getValue()
    {
        if ($this->is_encrypted && $this->setting_value) {
            try {
                return Crypt::decryptString($this->setting_value);
            } catch (\Exception $e) {
                return $this->setting_value;
            }
        }
        return $this->setting_value;
    }

    public function setValue($value, $encrypt = false)
    {
        if ($encrypt && $value) {
            $this->setting_value = Crypt::encryptString($value);
            $this->is_encrypted = true;
        } else {
            $this->setting_value = $value;
            $this->is_encrypted = false;
        }
    }
}
