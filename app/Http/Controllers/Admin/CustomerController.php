<?php

namespace App\Http\Controllers\Admin;

use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\DB;

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
    {   $customer_infos = DB::table('customers')
        ->join('estates', 'estates.customer_id', '=', 'customers.id')
        ->join('areas', 'areas.id', '=', 'estates.area_id')
        ->select('customers.name', 'customers.surname', 'customers.email', 'customers.phone', 'customers.address', 'estates.id', 'estates.cover_image', 'estates.area_id', 'areas.area', 'estates.name as estateName', 'estates.type', 'estates.sale_type', 'estates.price', 'estates.mq', 'estates.address as estateAddress', 'estates.city', 'estates.number_rooms', 'estates.number_bathrooms', 'estates.garden', 'estates.elevator', 'estates.parking_space', 'estates.balcony', 'estates.energetic_efficency', 'estates.description', 'estates.customer_id'   
        )
        ->where('customers.id', $customer->id)
        ->first();
        return Inertia::render('customers/Show', ['customer' => $customer_infos]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return Inertia::render('customers/Edit', ['customer' => $customer]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $form_data = $request->validated();
        $customer->update($form_data);

        return redirect()->route('admin.customers.index')->with('message', 'Cliente aggiornato correttamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('admin.customers.index');
    }
}
