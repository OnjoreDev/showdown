<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class SendBatchUpdate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $batch;

    public function __construct(array $batch)
    {
        $this->batch = $batch;
    }

    public function handle()
    {
        $payload = ['updates' => $this->batch];

        // Send the request to the third-party API
        $response = Http::post('https://127.0.0.1:8000/api/batch-endpoint', $payload);

        if ($response->failed()) {
            // Log or handle the error as needed
        }
    }
}
