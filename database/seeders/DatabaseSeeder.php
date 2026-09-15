<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseSession;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        $admin = User::create([
            'name' => 'Admin SJI',
            'email' => 'admin@sjicolombia.com',
            'password' => Hash::make('password'),
            'document_type' => 'CC',
            'document_number' => '1234567890',
            'phone_whatsapp' => '+573001234567',
            'city' => 'Santa Marta',
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Teacher user
        $teacher = User::create([
            'name' => 'Dr. Juan Pérez',
            'email' => 'profesor@sjicolombia.com',
            'password' => Hash::make('password'),
            'document_type' => 'CC',
            'document_number' => '9876543210',
            'phone_whatsapp' => '+573009876543',
            'city' => 'Santa Marta',
            'role' => 'teacher',
            'is_active' => true,
        ]);

        // Student user
        User::create([
            'name' => 'María García',
            'email' => 'estudiante@sjicolombia.com',
            'password' => Hash::make('password'),
            'document_type' => 'CC',
            'document_number' => '5555555555',
            'phone_whatsapp' => '+573005555555',
            'city' => 'Bogotá',
            'role' => 'student',
            'is_active' => true,
        ]);

        // Sample course
        $course = Course::create([
            'title' => 'Propiedad Horizontal: Régimen Legal y Administración',
            'slug' => 'propiedad-horizontal-regimen-legal',
            'short_description' => 'Curso integral sobre el régimen de propiedad horizontal en Colombia, dirigido a administradores, consejeros y copropietarios.',
            'syllabus' => "## Módulo 1: Fundamentos de la Ley 675 de 2001\n- Concepto y naturaleza jurídica\n- Órganos de dirección y administración\n\n## Módulo 2: Asambleas y Consejos\n- Convocatorias y quórum\n- Actas y decisiones\n\n## Módulo 3: Presupuesto y Obligaciones\n- Cuotas de administración\n- Fondo de imprevistos\n\n## Módulo 4: Solución de Conflictos\n- Mecanismos alternativos\n- Jurisprudencia relevante",
            'price_cop' => 350000.00,
            'hours_intensity' => 20,
            'max_capacity' => 50,
            'status' => 'published',
            'teacher_id' => $teacher->id,
            'starts_at' => now()->addWeeks(2),
        ]);

        // Sample sessions for the course
        $sessionTopics = [
            'Fundamentos de la Ley 675 de 2001',
            'Órganos de Dirección y Administración',
            'Asambleas: Convocatorias y Quórum',
            'Presupuesto y Cuotas de Administración',
            'Solución de Conflictos en Propiedad Horizontal',
        ];

        foreach ($sessionTopics as $index => $topic) {
            CourseSession::create([
                'course_id' => $course->id,
                'title' => "Sesión " . ($index + 1) . ": {$topic}",
                'description' => "Clase en vivo sobre {$topic}.",
                'scheduled_at' => now()->addWeeks(2)->addDays($index * 2)->setHour(19)->setMinute(0),
                'meet_url' => null,
                'meet_source' => 'manual',
                'order_index' => $index,
            ]);
        }
    }
}
