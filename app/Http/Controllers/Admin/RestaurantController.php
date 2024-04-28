<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Restaurant;
use DataTables;

class RestaurantController extends Controller
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
                $data = Restaurant::ManagerId(Auth::user()->id)->Approved()
                ->with(['category','foods','status','approval'])->select('restaurants.*');
            }else{
                $data = Restaurant::with(['category','foods','status','approval'])->select('restaurants.*');
            }
            return DataTables::of($data)
            ->addColumn('action', function($data){
                if($data->orders->count() >= 1){
                    return
                        '<a href="' . url("/admin/restaurant/".$data->id."/edit") . '" class="btn btn-sm btn-outline-success">Manage</a>';    
                }else{
                    return
                        '<a href="' . url("/admin/restaurant/".$data->id."/edit") . '" class="btn btn-sm btn-outline-success">Manage</a>
                        <button class="btn btn-sm btn-outline-danger btn-delete delete" data-remote="' . url("/api/restaurant/".$data->id) . '">Delete</button>';

                }
            })
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('admin.restaurant.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $response = app('http_client')->get(env("API_URL").'/restaurant/create');
        $data = $response->json();
        $category = $data['data']['category'];
        $user = $data['data']['user'];

        return view('admin.restaurant.create',compact('category','user'));
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
        $response = app('http_client')->get(env("API_URL").'/restaurant/'.$id.'/edit');
        $data = $response->json();
        $restaurant = $data['data']['restaurants'];
        $category = $data['data']['categories'];
        $food = $data['data']['food'];
        return view('admin.restaurant.edit',compact('restaurant', 'category', 'food'));
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
