<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class MailSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'mailer',
        'host',
        'port',
        'username',
        'password',
        'encryption',
        'from_address',
        'from_name',
        'reply_to_address',
        'is_default',
        'status',
    ];

    protected $casts = [
        'port' => 'integer',
        'is_default' => 'boolean',
        'status' => 'boolean',
    ];

    public function getPassword()
    {
        if ($this->password) {
            try {
                return Crypt::decryptString($this->password);
            } catch (\Exception $e) {
                return $this->password;
            }
        }
        return null;
    }

    public function setPassword($value)
    {
        if ($value) {
            $this->password = Crypt::encryptString($value);
        } else {
            $this->password = null;
        }
    }
}
