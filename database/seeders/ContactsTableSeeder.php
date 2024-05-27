<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Contact;
use Faker\Factory as Faker;

class ContactsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Generate 50 contacts
        for ($i = 0; $i < 50; $i++) {
            // Generate random user_id within the range of existing users
            $userId = 1; // Adjust the range as needed

            // Create contact with random data
            Contact::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->phoneNumber,
                'company' => $faker->company, // Nullable field, no need to check for existence
                'user_id' => $userId,
            ]);
        }
        
    }
}
