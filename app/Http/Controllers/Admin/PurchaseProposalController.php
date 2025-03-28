<?php

namespace App\Http\Controllers\Admin;

use App\Models\PurchaseProposal;
use App\Models\Customer;
use App\Models\Area;
use App\Http\Requests\StorePurchaseProposalRequest;
use App\Http\Requests\UpdatePurchaseProposalRequest;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\DB;

class PurchaseProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $purchase_proposals = PurchaseProposal::with(['area', 'customer'])->get();
        $purchase_proposals = DB::table('purchase_proposals')
        ->join('customers', 'customers.id', '=', 'purchase_proposals.customer_id')
        ->join('areas', 'areas.id', '=', 'purchase_proposals.area_id')
        ->select('purchase_proposals.id', 'areas.area', DB::raw("CONCAT(customers.name, ' ', customers.surname) as customerName"),'purchase_proposals.city', 'purchase_proposals.price_from', 'purchase_proposals.price_to', 'purchase_proposals.mq_from', 'purchase_proposals.mq_to', 'purchase_proposals.city', 'purchase_proposals.number_rooms', 'purchase_proposals.number_bathrooms', 'purchase_proposals.type', 'purchase_proposals.sale_type', 'purchase_proposals.elevator', 'purchase_proposals.garden', 'purchase_proposals.parking_space', 'purchase_proposals.balcony') 
        ->get();
        return Inertia::render('purchase_proposals/Index', ['proposals' => $purchase_proposals]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        $customers = Customer::all();
        $areas = Area::all();
        return Inertia::render('purchase_proposals/Create', ['customers' => $customers, 'areas' => $areas]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePurchaseProposalRequest $request)
    {
        $form_data = $request->validated();
        $all_data = $request->all();
        $all_data['parking_space'] == null ? $form_data['parking_space'] = false : $form_data['parking_space'] = true;
        $all_data['balcony'] == null ? $form_data['balcony'] = false : $form_data['balcony'] = true;
        $all_data['garden'] == null ? $form_data['garden'] = false : $form_data['garden'] = true;
        $all_data['elevator'] == null ? $form_data['elevator'] = false : $form_data['elevator'] = true;
        $form_data['area_id'] = $all_data['area_id'];
        $form_data['customer_id'] = $all_data['customer_id'];
        
        $purchase_proposal = new PurchaseProposal();
        
        $purchase_proposal->fill($form_data);
        $purchase_proposal->save();

        return redirect()->route('admin.purchase-proposals.index')->with('message', 'Proposta d\'acquisto inserita correttamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(PurchaseProposal $purchaseProposal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PurchaseProposal $purchaseProposal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePurchaseProposalRequest $request, PurchaseProposal $purchaseProposal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PurchaseProposal $purchaseProposal)
    {
        //
    }
}
