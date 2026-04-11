<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class DeliveryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showDelivery(int $id)
    {
        return view('user.delivery', compact('id'));
    }
}
