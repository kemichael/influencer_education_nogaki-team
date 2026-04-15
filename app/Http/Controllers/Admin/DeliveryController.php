<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DeliveryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showDeliveryEdit(int $id)
    {
        return view('admin.delivery', compact('id'));
    }
}
