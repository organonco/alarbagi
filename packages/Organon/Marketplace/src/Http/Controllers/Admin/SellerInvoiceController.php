<?php

namespace Organon\Marketplace\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Organon\Marketplace\DataGrids\SellerInvoiceDataGrid;
use Organon\Marketplace\Enums\SellerInvoiceStatusEnum;
use Organon\Marketplace\Models\Seller;
use Organon\Marketplace\Models\SellerInvoice;
use Organon\Marketplace\Notifications\InvoiceIssuedNotification;
use Organon\Marketplace\Notifications\NewInvoiceNotification;
use Organon\Marketplace\Notifications\Repositories\SellerInvoiceRepository;
use Organon\Marketplace\Notifications\Repositories\SellerRepository;
use Organon\Marketplace\Traits\InteractsWithAuthenticatedAdmin;
use Webkul\Notification\Repositories\NotificationRepository;

class SellerInvoiceController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, InteractsWithAuthenticatedAdmin;

    /**
     * Contains route related configuration
     *
     * @var array
     */
    protected $_config;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(private readonly SellerInvoiceRepository $sellerInvoiceRepository, private readonly SellerRepository $sellerRepository, private NotificationRepository $notificationRepository)
    {
        $this->middleware('admin');

        $this->_config = request('_config');
    }


    public function index()
    {
        if (request()->ajax())
            return app(SellerInvoiceDataGrid::class)->toJson();
        return view('marketplace::admin.seller-invoice.index');
    }


    public function generate($seller_id)
    {
        if($this->getAuthenticatedAdmin()->isSeller())
            abort(401);
        /** @var Seller $seller */
        $seller = $this->sellerRepository->find($seller_id);
        $invoice = $this->sellerInvoiceRepository->generate($seller);
        return redirect(route('admin.sales.sellers.invoice.view', ['invoice_id' => $invoice->id]));

    }

    public function view($invoice_id)
    {
        $invoice = $this->sellerInvoiceRepository->find($invoice_id);
        return view('marketplace::admin.seller-invoice.preview', ['invoice' => $invoice, 'is_owner' => !$this->getAuthenticatedAdmin()->isSeller()]);
    }


    public function addItem($invoice_id)
    {
        if($this->getAuthenticatedAdmin()->isSeller())
            abort(401);
        request()->validate([
            'amount' => 'required|numeric',
            'comment' => 'required|max:255',
        ]);
        $this->sellerInvoiceRepository->addItem($invoice_id, request()->input('comment'), request()->input('amount'));
        return redirect(route('admin.sales.sellers.invoice.view', ['invoice_id' => $invoice_id]));
    }

    public function deleteItem($invoice_id, $item_id)
    {
        if($this->getAuthenticatedAdmin()->isSeller())
            abort(401);
        $this->sellerInvoiceRepository->deleteItem($item_id, $invoice_id);
        return redirect(route('admin.sales.sellers.invoice.view', ['invoice_id' => $invoice_id]));
    }

    public function sendToSeller($invoice_id)
    {
        if($this->getAuthenticatedAdmin()->isSeller())
            abort(401);
        $this->sellerInvoiceRepository->sendToSeller($invoice_id);

        $invoice = $this->sellerInvoiceRepository->find($invoice_id);
        $this->notificationRepository->fromInternalNotification(new NewInvoiceNotification($invoice), $invoice->seller->admin->id);
        return redirect(route('admin.sales.sellers.invoice.view', ['invoice_id' => $invoice_id]));
    }

    public function unsendToSeller($invoice_id)
    {
        if($this->getAuthenticatedAdmin()->isSeller())
            abort(401);
        $this->sellerInvoiceRepository->unsendToSeller($invoice_id);

        $invoice = $this->sellerInvoiceRepository->find($invoice_id);
        $this->notificationRepository->deleteLastNotification('admin.sales.sellers.invoice.view', $invoice->seller->admin->id);
        return redirect(route('admin.sales.sellers.invoice.view', ['invoice_id' => $invoice_id]));
    }

    public function approve($invoice_id)
    {
        if(!$this->getAuthenticatedAdmin()->isSeller())
            abort(401);
        $this->sellerInvoiceRepository->approve($invoice_id);
        return redirect(route('admin.sales.sellers.invoice.view', ['invoice_id' => $invoice_id]));
    }

    public function reject($invoice_id)
    {
        if(!$this->getAuthenticatedAdmin()->isSeller())
            abort(401);
        $this->sellerInvoiceRepository->reject($invoice_id);
        return redirect(route('admin.sales.sellers.invoice.view', ['invoice_id' => $invoice_id]));
    }

    public function issue($invoice_id)
    {
        $this->sellerInvoiceRepository->issue($invoice_id);

        $invoice = $this->sellerInvoiceRepository->find($invoice_id);
        $this->notificationRepository->fromInternalNotification(new InvoiceIssuedNotification($invoice), $invoice->seller->admin->id);
        return redirect(route('admin.sales.sellers.invoice.view', ['invoice_id' => $invoice_id]));
    }

    public function destroy($invoice_id)
    {
        /** @var SellerInvoice $invoice */
        $invoice = $this->sellerInvoiceRepository->find($invoice_id);
        if($invoice->status != SellerInvoiceStatusEnum::DRAFT)
            abort(401);
        $invoice->delete();
        return view('marketplace::admin.seller-invoice.index');
    }

}
