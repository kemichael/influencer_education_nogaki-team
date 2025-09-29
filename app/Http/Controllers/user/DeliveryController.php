<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CurriculumProgress;
use App\Models\Curriculum;
use App\Models\DeliveryTime;
use App\Models\Grade;s
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DeliveryController extends Controller
{
    
public function showDelivery($id)
{
    $delivery = DeliveryTime::with('curriculum')->findOrFail($id);
    return view('user.delivery.show', compact('delivery'));
}


}
