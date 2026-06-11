<?php

namespace App\Services;

use App\Models\MailSetting;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MailService
{
    public static function send(string $to, Mailable $mailable): void
    {
        $setting = MailSetting::where('status', true)
            ->where('is_default', true)
            ->first()
            ?: MailSetting::where('status', true)->first();

        if (!$setting) {
            Log::warning('MailService: no active mail setting found, email not sent.', ['to' => $to]);
            return;
        }

        $host       = $setting->host;
        $port       = $setting->port;
        $encryption = $setting->encryption;
        $username   = $setting->username;
        $password   = $setting->getPassword();
        $fromAddr   = $setting->from_address;
        $fromName   = $setting->from_name ?: config('app.name');
        $replyTo    = $setting->reply_to_address;

        // Send after HTTP response is already returned to the browser
        dispatch(function() use ($to, $mailable, $host, $port, $encryption, $username, $password, $fromAddr, $fromName, $replyTo) {
            set_time_limit(120);

            Config::set('mail.mailers.smtp_db', [
                'transport'  => 'smtp',
                'host'       => $host,
                'port'       => $port,
                'encryption' => $encryption,
                'username'   => $username,
                'password'   => $password,
                'timeout'    => 60,
            ]);
            Config::set('mail.from.address', $fromAddr);
            Config::set('mail.from.name', $fromName);

            try {
                if ($replyTo) {
                    $mailable->replyTo($replyTo);
                }

                Mail::mailer('smtp_db')->to($to)->send($mailable);

                Log::info('MailService: email sent.', ['to' => $to, 'subject' => $mailable->envelope()->subject]);
            } catch (\Throwable $e) {
                Log::error('MailService: failed to send email.', [
                    'to'    => $to,
                    'error' => $e->getMessage(),
                ]);
            }
        })->afterResponse();
    }
}
