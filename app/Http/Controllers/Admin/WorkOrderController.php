<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WorkOrder;
use Illuminate\Http\Request;

class WorkOrderController extends Controller
{
    public function index()
    {
        $data = WorkOrder::all();
        return view('admin.work_order.index', compact('data'));
    }

    public function create()
    {
        return view('admin.work_order.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_wo' => 'required',
            'keluhan' => 'required',
            'status' => 'required',
        ]);

        WorkOrder::create($request->all());

        return redirect()->route('work-order.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = WorkOrder::findOrFail($id);
        return view('admin.work_order.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nomor_wo' => 'required',
            'keluhan' => 'required',
            'status' => 'required',
        ]);

        WorkOrder::findOrFail($id)->update($request->all());

        return redirect()->route('work-order.index')
            ->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        WorkOrder::destroy($id);
        return back()->with('success', 'Data berhasil dihapus');
    }
}
