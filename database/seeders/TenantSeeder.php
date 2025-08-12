<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Stancl\Tenancy\Database\Models\Tenant;

class TenantSeeder extends Seeder
{
    public function run()
    {
        // Create tenant with id 'tenant1'
        \App\Models\Tenant::firstOrCreate(['id' => 'tenant1']);

        // Create tenant with id 'tenant2' as example
        \App\Models\Tenant::firstOrCreate(['id' => 'tenant2']);
    }
}
