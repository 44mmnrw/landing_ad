<?php

namespace App\Http\Requests;

use App\Support\TrackingEventCatalog;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class StoreTrackingEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'tracking_number' => ['required', 'regex:/^TRK-[A-Z2-9]{4}-[A-Z2-9]{4}$/'],
            'event_uid' => ['required', 'string', 'max:100'],
            'event_type' => ['required', 'string', 'max:32'],
            'status' => ['required', 'string', 'in:'.implode(',', TrackingEventCatalog::inboundStatusValues())],
            'occurred_at' => ['required', 'date'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'notes' => ['nullable', 'string'],
            'source_system' => ['required', 'string', 'max:64'],
            'sent_at' => ['required', 'date'],
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        Log::warning('tracking.internal.validation_failed', [
            'errors' => $validator->errors()->toArray(),
            'ip' => $this->ip(),
            'source_system' => $this->input('source_system'),
            'tracking_number' => $this->input('tracking_number'),
        ]);

        throw new HttpResponseException(response()->json([
            'message' => 'The given data was invalid.',
            'errors' => $validator->errors(),
        ], 422));
    }
}
