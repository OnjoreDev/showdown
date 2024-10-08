<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Jobs\SendBatchUpdate;

class UserAttributeController extends Controller
{
    //Maximum hourly batch requests
    const BATCH_LIMIT = 50;
    //Maximum records per batch
    const RECORD_LIMIT = 1000;

    //function to perform the update
    public function update(Request $request){
        $changes = $request->input('batches'); // Expected input: { "batches": [{ "email": "...", "attribute": "value" }, ...] }

        //Validate the input
        $validated = $this->validateChanges($changes);

        //Chunk changes into batches
        $batches = array_chunk($validated, self::RECORD_LIMIT);

        //Process each batch
        foreach ($batches as $batch) {
            // $this->sendBatchUpdate($batch);
            SendBatchUpdate::dispatch($batch)->delay(now()->addSeconds(2)); // Adjust delay as needed
        }

        return response()->json(['status' => 'success', 'message' => 'Updates processed.']);
    }
    private function validateChanges(array $changes)
    {
        // Add your validation logic here (e.g., ensure email format is correct)
        return $changes; // Return validated changes
    }

    private function sendBatchUpdate(array $batch)
    {
        $payload = [
            'updates' => $batch,
        ];

        try {
            // $response = Http::post('https://thirdpartyapi.com/batch-endpoint', $payload);
            
             $response = Http::post('https://127.0.0.1:8000/api//user-attributes/update', $payload);

            // Handle the response, e.g., log errors, etc.
            if ($response->failed()) {
                // Log or handle the error as needed
            }
        } catch (\Exception $e) {
            // Handle exceptions (e.g., log the error)
        }
    }

}
