<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Lola Regalado',
            'email' => 'lola.regalado@bulletin.test',
            'password' => Hash::make('bulletin2026'),
        ]);

        $kagawad = User::create([
            'name' => 'Kagawad Derren Hanz Regalado',
            'email' => 'kagawad.regalado@bulletin.test',
            'password' => Hash::make('bulletin2026'),
        ]);

        Author::where('email', 'kagawad.regalado@bulletin.test')
            ->update(['user_id' => $kagawad->id]);

        User::factory()->count(8)->create();
    }
}
