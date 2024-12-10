<?php

namespace App\Http\Controllers;

use App\Models\PurchaseProposal;
use App\Http\Requests\StorePurchaseProposalRequest;
use App\Http\Requests\UpdatePurchaseProposalRequest;

class PurchaseProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePurchaseProposalRequest $request)
    {
        //
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
