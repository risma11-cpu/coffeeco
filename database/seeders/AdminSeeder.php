<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $email    = env('ADMIN_EMAIL');
        $password = env('ADMIN_PASSWORD');

        if (! $email || ! $password) {
            $this->command->error('Isi ADMIN_EMAIL dan ADMIN_PASSWORD di file .env dulu.');

            return;
        }

        if ($password === 'GANTI_DENGAN_PASSWORD_KUAT') {
            $this->command->error('Ganti ADMIN_PASSWORD di file .env dengan password milikmu sendiri.');

            return;
        }

        Admin::updateOrCreate(
            ['email' => $email],
            [
                'name'     => env('ADMIN_NAME', 'Admin Coffee & Co.'),
                'password' => $password,
            ]
        );

        $this->command->info('Akun admin siap: ' . $email);
    }
}