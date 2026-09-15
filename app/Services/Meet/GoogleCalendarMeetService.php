<?php

namespace App\Services\Meet;

use App\Models\CourseSession;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class GoogleCalendarMeetService implements MeetServiceInterface
{
    private string $credentialsPath;
    private string $calendarId;

    public function __construct()
    {
        $this->credentialsPath = config('meet.google_calendar.credentials_path', '');
        $this->calendarId = config('meet.google_calendar.calendar_id', 'primary');
    }

    public function createMeetingLink(CourseSession $session): string
    {
        if (! $this->isAvailable()) {
            throw new \RuntimeException(
                'Google Calendar API is not configured. Set GOOGLE_CREDENTIALS_PATH in .env'
            );
        }

        $accessToken = $this->getAccessToken();

        $response = Http::withToken($accessToken)
            ->post("https://www.googleapis.com/calendar/v3/calendars/{$this->calendarId}/events?conferenceDataVersion=1", [
                'summary' => $session->title . ' — ' . $session->course->title,
                'description' => $session->description ?? "Clase en vivo: {$session->course->title}",
                'start' => [
                    'dateTime' => $session->scheduled_at->toIso8601String(),
                    'timeZone' => 'America/Bogota',
                ],
                'end' => [
                    'dateTime' => $session->scheduled_at->addHours(2)->toIso8601String(),
                    'timeZone' => 'America/Bogota',
                ],
                'conferenceData' => [
                    'createRequest' => [
                        'requestId' => Str::uuid()->toString(),
                        'conferenceSolutionKey' => [
                            'type' => 'hangoutsMeet',
                        ],
                    ],
                ],
            ]);

        if ($response->failed()) {
            Log::error('Google Calendar event creation failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            throw new \RuntimeException('Failed to create Google Meet link');
        }

        $data = $response->json();

        return $data['conferenceData']['entryPoints'][0]['uri']
            ?? $data['hangoutLink']
            ?? '';
    }

    public function isAvailable(): bool
    {
        return ! empty($this->credentialsPath)
            && file_exists($this->credentialsPath);
    }

    /**
     * Get an OAuth2 access token from the service account credentials.
     * This is a simplified implementation — production should use google/apiclient.
     */
    private function getAccessToken(): string
    {
        // TODO: Implement proper OAuth2 token exchange using service account JWT.
        // For now, this serves as a placeholder for the Google Calendar API integration.
        // Install google/apiclient for full implementation:
        //   composer require google/apiclient
        throw new \RuntimeException(
            'Google Calendar OAuth2 token exchange not yet implemented. Install google/apiclient package.'
        );
    }
}
