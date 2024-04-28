<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Payment;
use Carbon\Carbon;
use Auth;

class ReportController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->hasRole('Manager')){
            $payment = Payment::wherehas('order.restaurant', function($query){
                $query->where('manager_id',Auth::user()->id);
            })->PaymentStatus('approved');

            $approved = $payment->with('order.restaurant','order')->get();
            $today = $payment->with('order.restaurant','order')->where('created_at', 'like', '%' . Carbon::today()->toDateString() . '%')->get();
        }else{
            $approved = Payment::PaymentStatus('approved')->with('order.restaurant','order')->get();
            $today = Payment::PaymentStatus('approved')->with('order.restaurant','order')
            ->where('created_at', 'like', '%' . Carbon::today()->toDateString() . '%')->get();
        }
        return $this->sendResponse([
            'approved' => $approved, 'today' => $today
        ], 'Data retrieved successfully.');
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
        //
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
        //
    }
}
