<?php

namespace App\Http\Controllers;

use App\Models\Course;

class CourseController extends Controller
{
    /**
     * Display a listing of published courses.
     */
    public function index()
    {
        $courses = Course::with(['teacher', 'sessions'])
            ->whereIn('status', ['published', 'in_progress'])
            ->latest('starts_at')
            ->get();

        return view('courses.index', compact('courses'));
    }

    /**
     * Display the specified course by slug.
     */
    public function show(string $slug)
    {
        $course = Course::with(['teacher', 'sessions', 'materials'])
            ->where('slug', $slug)
            ->firstOrFail();

        $isEnrolled = false;
        if (auth()->check()) {
            $isEnrolled = $course->enrollments()
                ->where('user_id', auth()->id())
                ->whereIn('status', ['active', 'completed', 'pending_payment'])
                ->exists();
        }

        return view('courses.show', compact('course', 'isEnrolled'));
    }
}
