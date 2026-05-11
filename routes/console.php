<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Reporte diario a las 8 AM
Schedule::command('vitalia:daily-report')->dailyAt('08:00');

// Recordatorios de WhatsApp cada hora (para cubrir exactamente 24h antes)
Schedule::command('vitalia:send-reminders')->hourly();
