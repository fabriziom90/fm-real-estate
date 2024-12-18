<?php

namespace App\Http\Controllers\Admin;

use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::all('id', 'name', 'surname', 'email', 'phone', 'address');

        return Inertia::render('customers/Index', ['customers' => $customers]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('customers/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        $form_data = $request->validated();

        $customer = new Customer();
        $customer->name = $form_data['name'];
        $customer->surname = $form_data['surname'];
        $customer->email = $form_data['email'];
        $customer->phone = $form_data['phone'];
        $customer->address = $form_data['address'];

        $customer->save();

        return redirect()->route('admin.customers.index')->with('message', 'Cliente aggiunto correttamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return Inertia::render('customers/Show', ['customer' => $customer]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
