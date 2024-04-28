<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Requests\Admin\StoreRestaurantRequest;
use App\Mail\NewRestaurantApplicationEmail;
use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\DeliveryType;
use App\Models\Category;
use App\Models\Food;
use App\Models\User;
use Mail;
use Auth;

class RestaurantController extends BaseController
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

    public function main(Request $request)
    {
        $category = Category::all();

        if($request->has('category')){
            $restaurant = Restaurant::whereRaw($cond)->Approved()->Enabled()->get();
        }else{
            $restaurant = Restaurant::Approved()->Enabled()->with('category')->get();
        }

        return $this->sendResponse([
            'restaurants' => $restaurant, 'categories' => $category
        ], 'Data retrieved successfully.');
    }

    public function search(Request $request)
    {
        $query = Restaurant::query()->Approved()->Enabled();

        $query->where('status', 1);
    
        if ($request->category) {
            $query->where('category_id', $request->category);
        }
    
        $restaurant = $query->with('category')->get();
    
        return response($restaurant, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::all();
        $user = User::all();
        return $this->sendResponse([
            'category' => $category, 'user' => $user
        ], 'Data retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRestaurantRequest $request)
    {
        if(Auth::user()->hasRole('Manager')){
            $approval = 6;
        }else{
            $approval = $request->input('approval') ? 3 : 4;
        }

        $restaurant = Restaurant::create([
            'name' => $request->input('name'),
            'category_id' => $request->input('category'),
            'description' => $request->input('description'),
            'location' => $request->input('location'),
            'status' => $request->input('featured') ? 1 : 2,
            'approval' => $approval,
            'manager_id' => $request->input('manager_id') ? $request->input('manager_id') : Auth::user()->id,
            'created_by' => Auth::user()->id,
        ]);

        if(Auth::user()->hasRole('Manager')){
            $manager = User::find(Auth::user()->id);
            $email = new NewRestaurantApplicationEmail($manager, $restaurant);

            $recipient_email = 'admin@gmail.com';
            Mail::to($recipient_email)->send($email);
        }

        $response = ['message' =>  'Restaurant Created'];
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

    public function display($id)
    {
        $restaurant = Restaurant::where('id',$id)->with('category')->first();
        $food = Food::RestaurantId($id)->get();
        $delivery = DeliveryType::all();
        return $this->sendResponse([
            'restaurant' => $restaurant, 'food' => $food, 'delivery' => $delivery,
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
        $restaurant = Restaurant::find($id);
        $category = Category::all();
        $food = Food::RestaurantId($id)->get();
        return $this->sendResponse([
            'restaurants' => $restaurant,
            'categories' => $category,
            'food' => $food,
        ], 'Data retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRestaurantRequest $request, $id)
    {   
        $restaurant = Restaurant::find($id);
        if(Auth::user()->hasRole('Manager')){
            $approval = $restaurant->approval;
        }else{
            $approval = $request->input('approval') ? 3 : 4;
        }

        $restaurant->update([
            'name' => $request->input('name'),
            'category_id' => $request->input('category'),
            'description' => $request->input('description'),
            'location' => $request->input('location'),
            'status' => $request->input('featured') ? 1 : 2,
            'approval' => $approval,
            'created_by' => 1,
        ]);

        $response = ['message' =>  'Restaurant Updated'];
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
        $restaurant = Restaurant::find($id);
        if(!$restaurant) {
            return response(['message'=> 'Restaurant Not Found', 404]);
        }
        Food::RestaurantId($id)->delete();
        $restaurant->delete();
        $response = ['message' =>  'Restaurant Deleted Successfully'];
        return response($response, 200);
    }
}
