<?php

namespace App\Services\Meet;

use App\Models\CourseSession;

interface MeetServiceInterface
{
    /**
     * Create a meeting link for the given session.
     */
    public function createMeetingLink(CourseSession $session): string;

    /**
     * Check if this service is properly configured and available.
     */
    public function isAvailable(): bool;
}
