<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SubscriptionItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subscription_items')->insert([
            [
                'subscription_id' => 1,
                'stripe_id' => 'si_Lvt8QP6Gch6hoa',
                'stripe_id' => 'si_Lvt8QP6Gch6hoa',
                'stripe_product' => 'prod_LuNX5TxcUXPDY6',
                'stripe_price' => 'price_1LCYmSJRT0lSu9XFh1vX83mZ',
                'quantity' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
        ]);
    }
}
