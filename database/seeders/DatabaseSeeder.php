<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\BillingSubscription;
use App\Models\Outlet;
use App\Models\Tenant;
use App\Enums\RoleEnum;
use App\Enums\SubscriptionStatusEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            BillingPaymentSeeder::class,
        ]);
    }
}
