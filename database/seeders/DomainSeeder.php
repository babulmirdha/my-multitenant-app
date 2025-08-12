<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Stancl\Tenancy\Database\Models\Tenant;

class DomainSeeder extends Seeder
{
    public function run()
    {
        $tenant1 = \App\Models\Tenant::where('id', 'tenant1')->first();
        if ($tenant1) {
            $tenant1->domains()->firstOrCreate(['domain' => 'tenant1.localhost']);
        }

        $tenant2 = \App\Models\Tenant::where('id', 'tenant2')->first();
        if ($tenant2) {
            $tenant2->domains()->firstOrCreate(['domain' => 'tenant2.localhost']);
        }
    }
}
