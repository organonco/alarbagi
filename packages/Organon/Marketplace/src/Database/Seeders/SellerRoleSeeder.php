<?php

namespace Organon\Marketplace\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SellerRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // Add seeder code here
        DB::table('roles')->insert([
            'id' => 2,
            'name' => 'Seller',
            'description' => 'Seller Role',
            'permission_type' => 'custom',
            "permissions" => json_encode([
                "dashboard",
                "sales",
                "sales.orders",
                "sales.orders.view",
                "sales.orders.cancel",
                "sales.invoices",
                "sales.invoices.view",
                "sales.invoices.create",
                "catalog",
                "catalog.products",
                "catalog.products.create",
                "catalog.products.copy",
                "catalog.products.edit",
                "catalog.products.delete",
                "catalog.products.mass-update",
                "catalog.products.mass-delete"
            ]),
        ]);

    }
}
