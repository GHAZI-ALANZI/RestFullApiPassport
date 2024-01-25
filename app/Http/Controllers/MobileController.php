<?php

namespace App\Http\Controllers;

use App\Models\Mobile;
use Illuminate\Http\Request;
use Validator;
class MobileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mobiles = Mobile::latest()->get();
        
        if (is_null($mobiles->first())) {
            return response()->json([
                'status' => 'failed',
                'message' => 'No mobile found!!',
            ], 200);
        }

        $response = [
            'status' => 'success',
            'message' => 'Mobile are retrieved successfully.',
            'data' => $mobiles,
        ];

        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|max:250',
            'description' => 'required|string|'
        ]);

        if($validate->fails()){  
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation Error!',
                'data' => $validate->errors(),
            ], 403);    
        }

        $mobile = Mobile::create($request->all());

        $response = [
            'status' => 'success',
            'message' => 'Mobile is added successfully.',
            'data' => $mobile,
        ];

        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $mobile = Mobile::find($id);
  
        if (is_null($mobile)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Mobile is not found!',
            ], 200);
        }

        $response = [
            'status' => 'success',
            'message' => 'Mobile is retrieved successfully.',
            'data' => $mobile,
        ];
        
        return response()->json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required'
        ]);

        if($validate->fails()){  
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation Error!',
                'data' => $validate->errors(),
            ], 403);
        }

        $mobile = Mobile::find($id);

        if (is_null($mobile)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Mobile is not found!',
            ], 200);
        }

        $mobile->update($request->all());
        
        $response = [
            'status' => 'success',
            'message' => 'Mobile is updated successfully.',
            'data' => $mobile,
        ];

        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $mobile = Mobile::find($id);
  
        if (is_null($mobile)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Mobile is not found!',
            ], 200);
        }

        Mobile::destroy($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Mobile is deleted successfully.'
            ], 200);
    }

    /**
     * Search by a mobile name
     *
     * @param  str  $name
     * @return \Illuminate\Http\Response
     */
    public function search($name)
    {
        $mobiles = Mobile::where('name', 'like', '%'.$name.'%')
            ->latest()->get();

        if (is_null($mobiles->first())) {
            return response()->json([
                'status' => 'failed',
                'message' => 'No mobile found!',
            ], 200);
        }

        $response = [
            'status' => 'success',
            'message' => 'Mobiles are retrieved successfully.',
            'data' => $mobiles,
        ];

        return response()->json($response, 200);
    }
}