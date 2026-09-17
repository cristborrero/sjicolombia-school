<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeacherDashboardController extends Controller
{
    /**
     * Show the attendance roster for a course.
     *
     * Accessible only to the assigned teacher or an admin.
     * Lists enrolled students with their identity document
     * so the teacher can verify attendees in the Meet/Zoom
     * waiting room.
     */
    public function roster(string $slug)
    {
        $course = Course::with([
            'sessions',
            'enrollments' => fn ($q) => $q
                ->whereIn('status', ['active', 'completed'])
                ->with('user'),
        ])
            ->where('slug', $slug)
            ->firstOrFail();

        $user = auth()->user();

        // Only the course teacher or an admin may see the roster
        if (! $user->isAdmin() && $course->teacher_id !== $user->id) {
            abort(403, 'No tienes permiso para acceder a esta vista.');
        }

        $enrolledStudents = $course->enrollments->map(fn ($e) => $e->user);

        return view('teacher.roster', compact('course', 'enrolledStudents'));
    }

    /**
     * Upload a material file to a course (or a specific session).
     */
    public function uploadMaterial(Request $request, string $slug)
    {
        $course = Course::where('slug', $slug)->firstOrFail();

        $user = auth()->user();

        if (! $user->isAdmin() && $course->teacher_id !== $user->id) {
            abort(403, 'No tienes permiso para subir materiales a este curso.');
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'file'  => ['required', 'file', 'max:20480', 'mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,zip'],
            'course_session_id' => ['nullable', 'exists:course_sessions,id'],
        ]);

        $file = $request->file('file');
        $path = $file->store("materials/{$course->id}", 'local');

        CourseMaterial::create([
            'course_id'         => $course->id,
            'course_session_id' => $validated['course_session_id'] ?? null,
            'title'             => $validated['title'],
            'file_path'         => $path,
            'file_type'         => $file->getClientOriginalExtension(),
            'file_size_bytes'   => $file->getSize(),
        ]);

        return redirect()
            ->back()
            ->with('success', 'Material subido correctamente.');
    }
}
