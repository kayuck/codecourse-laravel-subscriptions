<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subscriptions')->insert([
            [
                'user_id' => 1,
                'name' => 'default',
                'stripe_id' => 'sub_1LE1M3JRT0lSu9XFLBsrSZql',
                'stripe_status' => 'active',
                'stripe_price' => 'price_1LCYmSJRT0lSu9XFh1vX83mZ',
                'quantity' => 1,
                'trial_ends_at' => null,
                'ends_at' => null,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
        ]);
    }
}
