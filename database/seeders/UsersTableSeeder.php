<?php
namespace Database\Seeders;

use App\Models\Auth\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public const DEFAULT_PASSWORD = 'passWORD1';
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create(['email' => 'admin@nosend.net']);
        User::factory()->create(['email' => 'user@nosend.net']);

    }
}
