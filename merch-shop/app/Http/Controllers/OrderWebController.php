<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderWebController extends Controller
{
    public function show()
    {
        return view('checkout.index', ['user' => Auth::user()]);
    }

    public function store(StoreOrderRequest $request)
    {
        $data = $request->validated();
        try {
            Order::storeNewOrder($request, $data);
        } catch (\Throwable $e) {
            return back()->withErrors(['' => $e->getMessage()]);
        }

        return redirect(route('profile'));
    }
}
