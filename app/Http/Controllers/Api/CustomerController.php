<?php

namespace App\Http\Controllers\Api;

use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class CustomerController extends Controller
{
    
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

        return response()->json([
            'success' => true,
            'results' => $customer->id
        ]);
    }

    
}
