<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;

class DailyLoggerService
{
    protected $basePath;
    
    public function __construct()
    {
        $this->basePath = storage_path('logs/daily');
    }

    /**
     * Membuat log dengan format tanggal
     *
     * @param string $message
     * @param array $context
     * @param string $level
     * @return void
     */
    public function log($message, array $context = [], $level = 'info')
    {
        // Buat direktori jika belum ada
        if (!file_exists($this->basePath)) {
            mkdir($this->basePath, 0777, true);
        }

        // Format nama file berdasarkan tanggal
        $filename = Carbon::now()->format('Y-m-d') . '.log';
        
        // Konfigurasi custom logger
        config(['logging.channels.daily' => [
            'driver' => 'single',
            'path' => $this->basePath . '/' . $filename,
            'level' => 'debug',
        ]]);

        // Tambahkan timestamp ke context
        $context['timestamp'] = Carbon::now()->toDateTimeString();
        
        // Tulis log
        Log::channel('daily')->$level($message, $context);
    }

    /**
     * Log info
     */
    public function info($message, array $context = [])
    {
        $this->log($message, $context, 'info');
    }

    /**
     * Log error
     */
    public function error($message, array $context = [])
    {
        $this->log($message, $context, 'error');
    }

    /**
     * Log warning
     */
    public function warning($message, array $context = [])
    {
        $this->log($message, $context, 'warning');
    }

    /**
     * Log debug
     */
    public function debug($message, array $context = [])
    {
        $this->log($message, $context, 'debug');
    }
}