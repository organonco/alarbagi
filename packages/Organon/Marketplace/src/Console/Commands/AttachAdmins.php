<?php

namespace Organon\Marketplace\Console\Commands;

use Illuminate\Console\Command;
use Organon\Marketplace\Enums\SellerStatusEnum;
use Organon\Marketplace\Models\Admin;
use Organon\Marketplace\Models\Product;
use Webkul\Product\Repositories\ProductRepository;

class AttachAdmins extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attach:admins {number_of_admins}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Attach Admins to Fake Products';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(private ProductRepository $productRepository)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $numberOfAdmins = $this->argument('number_of_admins');
        $admins = Admin::factory($numberOfAdmins)->create();
        $latestAdmin = Admin::where('email', 'LIKE', '%@example.com')->where('email', 'LIKE', "seller%")->orderBy('id', "DESC")->first();
        $latestEmail = $latestAdmin ? $latestAdmin->email : "seller0@example.com";
        $startingIndex = (intval(substr($latestEmail, 6, strlen($latestEmail) - 18))) + 1;

        $products = Product::withoutGlobalScopes()->get();
        foreach ($products as $product)
            $product->update(['seller_id' => fake()->randomElement($admins)->getSellerId()]);

        foreach ($admins as $index => $admin) {
            $admin->email = "seller" . $index + $startingIndex . "@example.com";
            $admin->seller->setStatus(SellerStatusEnum::ACTIVE);
            $admin->save();
        }
    }
}
