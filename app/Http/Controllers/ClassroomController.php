<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClassroomController extends Controller
{
    /**
     * Show the virtual classroom for an enrolled student.
     */
    public function show(string $slug)
    {
        $course = Course::with(['teacher', 'sessions.materials', 'materials'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Gate: only enrolled (active/completed) students may enter
        $enrollment = $course->enrollments()
            ->where('user_id', auth()->id())
            ->whereIn('status', ['active', 'completed'])
            ->first();

        if (! $enrollment) {
            return redirect()
                ->route('courses.show', $course->slug)
                ->with('error', 'Debes estar inscrito y con pago confirmado para acceder al aula virtual.');
        }

        $sessions = $course->sessions()
            ->with('materials')
            ->orderBy('order_index')
            ->get();

        // General course materials (not tied to a specific session)
        $generalMaterials = $course->materials()
            ->whereNull('course_session_id')
            ->orderBy('title')
            ->get();

        return view('courses.classroom', compact(
            'course',
            'enrollment',
            'sessions',
            'generalMaterials',
        ));
    }

    /**
     * Securely download a course material file.
     *
     * Validates that the authenticated user has an active enrollment
     * for the course that owns the material before streaming the file.
     */
    public function downloadMaterial(CourseMaterial $material)
    {
        $course = $material->course;

        $hasAccess = $course->enrollments()
            ->where('user_id', auth()->id())
            ->whereIn('status', ['active', 'completed'])
            ->exists();

        if (! $hasAccess) {
            abort(403, 'No tienes acceso a este material.');
        }

        if (! Storage::disk('local')->exists($material->file_path)) {
            abort(404, 'El archivo no fue encontrado.');
        }

        return Storage::disk('local')->download(
            $material->file_path,
            $material->title . '.' . pathinfo($material->file_path, PATHINFO_EXTENSION),
        );
    }
}
