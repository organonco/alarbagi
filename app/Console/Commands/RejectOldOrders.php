<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Organon\Marketplace\Models\SellerOrder;
use Organon\Marketplace\Notifications\Repositories\SellerOrderRepository;

class RejectOldOrders extends Command
{

    public function __construct(private SellerOrderRepository $repository)
    {
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reject-old-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $orders = SellerOrder::query()->where('created_at', '<', Carbon::now()->subMinutes(4))->where('status', 'pending')->get();
        Log::info("Rejecting " . $orders->count() . ' Seller Orders');
        foreach($orders as $order)
            $this->repository->cancel($order);
    }
}
