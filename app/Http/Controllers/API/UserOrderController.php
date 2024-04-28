<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Food;
use App\Models\Restaurant;
use App\Models\DeliveryType;
use App\Models\Order;
use App\Models\OrderDetail;

class UserOrderController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function orderList()
    {
        $order = Order::UserId(Auth::user()->id)->with('restaurant','deliveryType','orderStatus','payment',
        'orderDetails','orderDetails.food')->get();
        return $this->sendResponse([
            'order' => $order
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
        $restaurant = Restaurant::find($request->input('restaurant_id'));
        $type = DeliveryType::find($request->input('delivery_type'));
        $order = Order::create([
            'restaurant_id' => $request->input('restaurant_id'),
            'user_id' => Auth::user()->id,
            'delivery_id' => $request->input('delivery_type'),
            'description' => $restaurant->name. 'Delivery Type: '.$type->name,
            'order_status' => 1
        ]);

        $selected_food = explode(',', $request->selected_foods);
        $total = 0;
        foreach ($selected_food as $value) {
            $food = Food::find($value);
            OrderDetail::create([
                'order_id' => $order->id,
                'food_id' => $value,
                'quantity' => 1,
                'total_price' => $food->price,
            ]);
            $total += $food->price;
        }

        Order::where('id',$order->id)->update(['total_price' => $total]);

        $response = [
            'redirectUrl' => '/payment/'.$order->id
        ];
        return response($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::where('id',$id)->with(['orderDetails'])->first();
        return $this->sendResponse([
            'order' => $order
        ], 'Data retrieved successfully.');
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