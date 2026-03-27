<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class RevokeTrackingEventRequest extends FormRequest
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
            'event_uid' => ['nullable', 'string', 'max:100'],
            'event_id' => ['nullable', 'integer', 'min:1'],
            'action' => ['required', 'string', 'in:revoke'],
            'source_system' => ['required', 'string', 'max:64'],
            'sent_at' => ['required', 'date'],
            'reason' => ['nullable', 'string', 'max:128'],
            'trip_id' => ['nullable', 'integer'],
            'order_id' => ['nullable', 'integer'],
            'tracking_number' => ['nullable', 'string', 'max:50'],
            'event_type' => ['nullable', 'string', 'max:32'],
        ];
    }

    protected function passedValidation(): void
    {
        $eventUid = trim((string) $this->input('event_uid', ''));
        $eventId = $this->input('event_id');

        if ($eventUid === '' && (is_null($eventId) || ! is_numeric($eventId))) {
            throw new HttpResponseException(response()->json([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'event_uid' => ['The event_uid or event_id field is required.'],
                ],
            ], 422));
        }
    }

    protected function failedValidation(Validator $validator): void
    {
        Log::warning('tracking.internal.revoke.validation_failed', [
            'errors' => $validator->errors()->toArray(),
            'ip' => $this->ip(),
            'source_system' => $this->input('source_system'),
            'event_uid' => $this->input('event_uid'),
            'event_id' => $this->input('event_id'),
        ]);

        throw new HttpResponseException(response()->json([
            'message' => 'The given data was invalid.',
            'errors' => $validator->errors(),
        ], 422));
    }
}
