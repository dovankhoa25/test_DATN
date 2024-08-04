<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApiProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listProducts = Product::all();

        if ($listProducts->count() > 0) {
            return response()->json([
                'status' => 200,
                'listProducts' => $listProducts
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'Không có sản phẩm nào'
            ]);
        }
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
        // Xác thực dữ liệu từ request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate file image
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id', // Kiểm tra category_id có tồn tại trong bảng categories
        ]);

        // Kiểm tra nếu xác thực thất bại
        if ($validator->fails()) {
            // Trả về phản hồi JSON chứa lỗi xác thực và mã trạng thái 400
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 400);
        }

        // Lấy dữ liệu đã xác thực
        $validated = $validator->validated();

        // Xử lý tệp ảnh
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = date('YmdHi') . $image->getClientOriginalName();
            $image->move(public_path('upload/products'), $imageName);
            $validated['image'] = $imageName;
        }

        // Tạo sản phẩm mới với dữ liệu đã xác thực
        $product = Product::create($validated);

        // Trả về phản hồi JSON với thông tin sản phẩm vừa tạo và mã trạng thái 201
        return response()->json([
            'status' => 201,
            'message' => 'Product created successfully',
            'product' => $product
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        if ($product) {
            return response()->json([
                'status' => 200,
                'product' => $product
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'không tìm thấy product'
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        if ($product) {
            return response()->json([
                'status' => 200,
                'product' => $product
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'không tìm thấy product để eidt'
            ]);
        }
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
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price' => 'nullable|numeric',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 400);
        }

        // Lấy dữ liệu đã xác thực
        $validated = $validator->validated();

        if ($request->hasFile('image')) {

            $image = $request->file('image');
            $imageName = date('YmdHi') . $image->getClientOriginalName();
            $image->move(public_path('upload/products'), $imageName);
            $validated['image'] = $imageName;
        }

        // Cập nhật sản phẩm với dữ liệu đã xác thực
        $product->update($validated);

        // Trả về phản hồi JSON với thông tin sản phẩm vừa cập nhật và mã trạng thái 200
        return response()->json([
            'status' => 'success',
            'vali' => $validated
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->delete();
            return response()->json([
                'status' => 200,
                'message' => 'xoá thành công'
            ], 404);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'không tìm thấy product để xoá'
            ], 404);
        }
    }
}
