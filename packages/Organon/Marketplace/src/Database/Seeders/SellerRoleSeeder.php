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

		DB::table('roles')->insert([
			'id' => 2,
			'name' => 'Seller',
			'description' => 'Seller Role',
			'permission_type' => 'custom',
			"permissions" => json_encode(
				[
					"marketplace",
					"marketplace.orders",
					"account",
					"account.profile",
					"account.settings",
					"catalog",
					"catalog.products",
					"products",
					"catalog.products.create",
					"catalog.products.copy",
					"catalog.products.edit",
					"catalog.products.delete",
					"catalog.products.mass-update",
					"catalog.products.mass-delete",
					"offers"
				]
			),
		]);

		DB::table('roles')->insert([
			'id' => 3,
			'name' => "Manager",
			'description' => "Manager Role",
			'permission_type' => 'custom',
			'permissions' => json_encode(
				[
					"dashboard",
					"sales",
					"sellers",
					"orders",
					"sales.orders",
					"sales.sellers",
					"sales.orders.view",
					"sales.orders.cancel",
					"seller-categories",
					"sales.seller-categories",
					"catalog",
					"products",
					"catalog.products",
					"catalog.products.edit",
					"catalog.products.delete",
					"catalog.products.mass-update",
					"catalog.products.mass-delete",
					"categories",
					"catalog.categories.create",
					"catalog.categories.edit",
					"catalog.categories.delete",
					"catalog.categories.mass-delete",
					"catalog.categories.mass-update",
					"customers",
					"customers.customers",
					"customers.customers.create",
					"customers.customers.edit",
					"customers.customers.delete",
					"customers.customers.mass-update",
					"customers.customers.mass-delete",
					"delivery",
					"delivery.areas",
					"delivery.shipping-companies",
					"areas",
					"shipping-companies",
					"cms",
					"cms.create",
					"cms.edit",
					"cms.delete",
					"cms.mass-delete",
					"banners",
					"offers"
				]
			)
		]);
	}
}
