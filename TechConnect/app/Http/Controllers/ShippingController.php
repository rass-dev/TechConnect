<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipping;

class ShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shippings = Shipping::orderBy('id', 'DESC')->paginate(10);
        return view('backend.shipping.index')->with('shippings', $shippings);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.shipping.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'           => 'required|string|max:255',
            'reference_no'   => 'required|string|unique:shippings,reference_no',
            'payment_method' => 'required|string|max:255',
            'address'        => 'required|string',
            'total'          => 'required|numeric',
            'status'         => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $data = $request->all();
        $status = Shipping::create($data);

        if ($status) {
            request()->session()->flash('success', 'Shipping successfully created');
        } else {
            request()->session()->flash('error', 'Error, please try again');
        }

        return redirect()->route('shipping.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $shipping = Shipping::find($id);
        if (!$shipping) {
            request()->session()->flash('error', 'Shipping not found');
            return redirect()->back();
        }

        return view('backend.shipping.edit')->with('shipping', $shipping);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $shipping = Shipping::find($id);
        if (!$shipping) {
            request()->session()->flash('error', 'Shipping not found');
            return redirect()->back();
        }

        $this->validate($request, [
            'name'           => 'required|string|max:255',
            'reference_no'   => "required|string|unique:shippings,reference_no,{$id}",
            'payment_method' => 'required|string|max:255',
            'address'        => 'required|string',
            'total'          => 'required|numeric',
            'status'         => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $data = $request->all();
        $status = $shipping->fill($data)->save();

        if ($status) {
            request()->session()->flash('success', 'Shipping successfully updated');
        } else {
            request()->session()->flash('error', 'Error, please try again');
        }

        return redirect()->route('shipping.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $shipping = Shipping::find($id);
        if (!$shipping) {
            request()->session()->flash('error', 'Shipping not found');
            return redirect()->back();
        }

        $status = $shipping->delete();
        if ($status) {
            request()->session()->flash('success', 'Shipping successfully deleted');
        } else {
            request()->session()->flash('error', 'Error, please try again');
        }

        return redirect()->route('shipping.index');
    }
}
