<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Order;
use DataTables;
use Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            if(Auth::user()->hasRole('Manager')){
                $data = Order::wherehas('restaurant',function($query){
                    $query->where('manager_id',Auth::user()->id);
                })->with(['restaurant','user','deliveryType','payment','orderStatus'])->select('orders.*');
            }else{
                $data = Order::with(['restaurant','user','deliveryType','payment','orderStatus'])->select('orders.*');
            }
            return DataTables::of($data)
            ->addColumn('payment_stat', function($row){
                return isset($row->payment->payment_status) ? $row->payment->payment_status : 'Pending';
            })
            ->addColumn('order_stat', function ($row) {
                return isset($row->orderStatus->name) ? $row->orderStatus->name : 'No Data';
            })
            ->addColumn('action', function($row){
                return
                    '<a href="' . url("/admin/order/".$row->id."/edit") . '" class="btn btn-sm btn-outline-success">Manage Order</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('admin.order.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $response = app('http_client')->get(env("API_URL").'/admin-order/'.$id.'/edit');
        $data = $response->json();
        $order = $data['data']['order'];
        $status = $data['data']['status'];
        return view('admin.order.edit',compact('order','status'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        dd('aa');
        dd($id);
    }
}
