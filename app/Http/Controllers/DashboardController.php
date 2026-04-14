<?php 
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WorkOrder;

class DashboardController extends Controller
{
    public function index()
    {
        $totalWO = WorkOrder::count();
        return view('admin.dashboard', compact('totalWO'));
    }
}

?>