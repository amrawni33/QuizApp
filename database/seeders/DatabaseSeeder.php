<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(5)->create();
        $students=[
            'amr@fci.bu.edu.eg',
            'anas@fci.bu.edu.eg',
            'monaem@fci.bu.edu.eg',
            'abdehady@fci.bu.edu.eg',
            'fatma@fci.bu.edu.eg',
        ];
        $edu=[
            'amr@fci.bu.edu.eg',
            'anas@fci.bu.edu.eg',
        ];
        foreach ($students as $student) {
            \App\Models\User::factory()->create([
                'name' => trim($student, '@fci.bu.edu.eg'),
                'email' => $student,
                'isEduo' => in_array($student, $edu),
            ]);
        }

    }
}
