<?php

namespace App\Services\Meet;

use App\Models\CourseSession;

class ManualMeetService implements MeetServiceInterface
{
    /**
     * Manual mode: the admin/teacher pastes the link directly.
     * This method returns the existing URL or empty string.
     */
    public function createMeetingLink(CourseSession $session): string
    {
        return $session->meet_url ?? '';
    }

    /**
     * Manual mode is always available.
     */
    public function isAvailable(): bool
    {
        return true;
    }
}
