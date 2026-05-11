<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TwilioService
{
    protected $sid;
    protected $token;
    protected $from;

    public function __construct()
    {
        $this->sid = config('services.twilio.sid');
        $this->token = config('services.twilio.token');
        $this->from = config('services.twilio.whatsapp_from');
    }

    public function sendMessage($to, $message)
    {
        if (!$this->sid || !$this->token) {
            Log::warning("Twilio no configurado. El mensaje no se envió realmente.");
            return false;
        }

        try {
            $response = Http::asForm()
                ->withBasicAuth($this->sid, $this->token)
                ->post("https://api.twilio.com/2010-04-01/Accounts/{$this->sid}/Messages.json", [
                    'To' => "whatsapp:{$to}",
                    'From' => "whatsapp:{$this->from}",
                    'Body' => $message,
                ]);

            if ($response->successful()) {
                Log::info("WhatsApp real enviado vía Twilio a {$to}");
                return true;
            }

            Log::error("Error Twilio API: " . $response->body());
            return false;
        } catch (\Exception $e) {
            Log::error("Excepción Twilio: " . $e->getMessage());
            return false;
        }
    }
}
