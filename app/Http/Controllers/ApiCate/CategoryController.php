<?php

namespace App\Http\Controllers\ApiCate;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $objCate = new Category();
        $data = $objCate->loadListCate();
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $objCate = new Category();
        $res = $objCate->insertDataCate($data);
        if($res){
            return response()->json(['success'=>true,'data'=>$data]);
        }else{
            return response()->json(['success'=>false]);
        }
    }

    /**
     * Display the specified resource.
     *
     */
    public function show($id)
    {
        $objCate = new Category();
        $data = $objCate->loadIdCate($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(Request $request, $id)
    {
        $objCate = new Category();
        $idCheck = $objCate->loadIdCate($id);
        if($idCheck){
            $data = $request->all();
            $res = $objCate->updateDataCate($data, $id);
            if($res){
                return response()->json($data);
            }else{
                return response()->json(['error'=>false, 'data'=>[]]);
            }
        }else{
            return response()->json([], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy($id)
    {
        $objCate = new Category();
        $idCheck = $objCate->loadIdCate($id);
        if($idCheck){
            $res = $objCate->deleteDataCatet($id);
            if($res){
                return response()->json('success', 204);
            }else{
                return response()->json('error', 406);
            }
        }else{
            return response()->json('error',404);
        }
    }
}
