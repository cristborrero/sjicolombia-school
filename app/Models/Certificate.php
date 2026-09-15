<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'enrollment_id', 'user_id', 'course_id',
        'certificate_code', 'pdf_path', 'issued_at',
    ];

    protected function casts(): array
    {
        return [
            'issued_at' => 'datetime',
        ];
    }

    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Generate a unique certificate code (e.g. SJI-2026-A8K9Z).
     */
    public static function generateCode(): string
    {
        $year = now()->year;
        $random = strtoupper(substr(bin2hex(random_bytes(3)), 0, 5));

        $code = "SJI-{$year}-{$random}";

        // Ensure uniqueness
        while (static::where('certificate_code', $code)->exists()) {
            $random = strtoupper(substr(bin2hex(random_bytes(3)), 0, 5));
            $code = "SJI-{$year}-{$random}";
        }

        return $code;
    }

    public function getVerificationUrl(): string
    {
        return url("/verificar/{$this->certificate_code}");
    }
}
