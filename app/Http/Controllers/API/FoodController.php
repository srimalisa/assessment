<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Requests\Admin\StoreFoodRequest;
use App\Models\Food;
use Auth;

class FoodController extends BaseController
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
    public function store(StoreFoodRequest $request)
    {
        Food::create([
            'restaurant_id' => $request->input('restaurant_id'),
            'name' => $request->input('food_name'),
            'description' => $request->input('food_name'),
            'price' => $request->input('price'),
            'created_by' => Auth::user()->id,
        ]);

        // return $this->sendResponse('message', 'Created');
        $response = ['message' =>  'Food Updated'];
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
        $request->validate([
            'f_name.*' => 'required|string|max:255',
            'f_description.*' => 'required|string|max:255',
            'f_price.*' => 'required|numeric',
        ]);

        foreach($request->input('food_id') as $key => $value){
            Food::where('id',$key)->update([
                'name' => $request->input('f_name')[$key],
                'description' => $request->input('f_description')[$key],
                'price' => $request->input('f_price')[$key],
            ]);
        }

        $response = ['message' =>  'Food Updated'];
        return response($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $food = Food::find($id);
        if(!$food) {
            return response(['message'=> 'Food Not Found', 404]);
        }
        $food->delete();
        $response = ['message' =>  'Food Deleted Successfully'];
        return response($response, 200);
    }
}
