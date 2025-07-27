<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Role::truncate();
        Schema::enableForeignKeyConstraints();

        $data = [['name' => 'Student', 'auth_name' => 'student', 'created_at' => now(), 'updated_at' => now()],
                 ['name' => 'Operator', 'auth_name' => 'operator', 'created_at' => now(), 'updated_at' => now()],
                 ['name' => 'Officer', 'auth_name' => 'officer', 'created_at' => now(), 'updated_at' => now()],
                 ['name' => 'Registrar', 'auth_name' => 'registrar', 'created_at' => now(), 'updated_at' => now()],
                 ['name' => 'Subject Committee', 'auth_name' => 'subject_committee', 'created_at' => now(), 'updated_at' => now()],
                 ['name' => 'Exam Committee', 'auth_name' => 'exam_committee', 'created_at' => now(), 'updated_at' => now()],
                 ['name' => 'Council', 'auth_name' => 'council', 'created_at' => now(), 'updated_at' => now()],
                 ['name' => 'Admin', 'auth_name' => 'admin', 'created_at' => now(), 'updated_at' => now()]];
        Role::insert($data);
    }
}
