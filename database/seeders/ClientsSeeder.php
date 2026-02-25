<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ClientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = [];
        $now = Carbon::now();

        // Specific location IDs as provided
        $locationIds = [1, 2, 6, 7, 18, 19, 20, 21];
        
        // Sample first names
        $firstNames = ['John', 'Jane', 'Robert', 'Mary', 'Michael', 'Sarah', 'David', 'Lisa', 'James', 'Jennifer', 
                      'William', 'Elizabeth', 'Richard', 'Susan', 'Joseph', 'Maria', 'Thomas', 'Margaret', 'Charles', 'Nancy',
                      'Christopher', 'Karen', 'Daniel', 'Betty', 'Matthew', 'Sandra', 'Anthony', 'Donna', 'Mark', 'Emily'];
        
        // Sample last names
        $lastNames = ['Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis', 'Rodriguez', 'Martinez',
                     'Hernandez', 'Lopez', 'Gonzalez', 'Wilson', 'Anderson', 'Thomas', 'Taylor', 'Moore', 'Jackson', 'Martin',
                     'Lee', 'Perez', 'Thompson', 'White', 'Harris', 'Sanchez', 'Clark', 'Ramirez', 'Lewis', 'Robinson'];

        // Generate 30 clients
        for ($i = 1; $i <= 30; $i++) {
            $firstName = $firstNames[array_rand($firstNames)];
            $lastName = $lastNames[array_rand($lastNames)];
            $email = strtolower($firstName . '.' . $lastName . $i . '@example.com');
            
            // Randomly select one of the specific location IDs
            $locationId = $locationIds[array_rand($locationIds)];
            
            $clients[] = [
                'uuid' => Str::uuid(),
                'location_id' => $locationId, // Randomly selected from the specific list
                'role' => 'client',
                'first_name' => $firstName,
                'middle_name' => rand(0, 1) ? substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1) . '.' : null,
                'last_name' => $lastName,
                'user_type' => 'customer',
                'email' => $email,
                'mobile_number' => '+1' . rand(200, 999) . rand(100, 999) . rand(1000, 9999),
                'password' => Hash::make('password123'), // Default password for testing
                'profile_photo' => null,
                'status' => 'active',
                'email_verified' => 1,
                'verification_token' => null,
                'token_expiry' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // Insert clients into the database
        DB::table('tbl_users')->insert($clients);
        
        $this->command->info('✅ 30 clients have been seeded successfully with specific location IDs!');
        $this->command->info('📍 Location IDs used: ' . implode(', ', $locationIds));
    }
}