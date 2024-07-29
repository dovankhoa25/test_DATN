<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $view;
    public function __construct()
    {
        $this->view = [];
    }

    public function index()
    {
        $objCate = new Category();
        $this->view['listCate'] = $objCate->loadListCate();
        return view('category.index', $this->view);
    }

    public function create()
    {
        return view('category.create', $this->view);
    }

    public function store(StoreCategoryRequest $request)
    {
        $data = $request->all();

        $objCate = new Category();
        $res = $objCate->insertDataCate($data);
        if ($res) {
            return redirect()->back()->with('success', "Thêm danh mục thành công");
        } else {
            return redirect()->back()->with('error', "Thêm danh mục thất bại");
        }
    }

    public function edit(int $id)
    {
        $objCate = new Category();
        $this->view['idCate'] = $objCate->loadIdCate($id);
        return view('category.edit', $this->view);
    }

    public function update(UpdateCategoryRequest $request, int $id)
    {
        $objCate = new Category();
        $idCheck = $objCate->loadIdCate($id);
    
        if ($idCheck) {
            $data = $request->all();
            $res = $objCate->updateDataCate($data, $id);
            if ($res) {
                // Cập nhật trạng thái của sản phẩm liên kết
                $objCate->updateProductStatus($id, $data['status']);
                return redirect()->back()->with('success', "Sửa danh mục thành công");
            } else {
                return redirect()->back()->with('error', "Sửa danh mục thất bại");
            }
        } else {
            return redirect()->back()->with('error', "Không tìm thấy id");
        }
    }

    public function destroy(int $id)
    {
        $objCate = new Category();
        $idCheck = $objCate->loadIdCate($id);

        if ($idCheck) {
            $category = $objCate->find($id);
            $category->products()->delete(); // Xóa các bản ghi liên quan trong bảng products
            $res = $category->delete();

            if ($res) {
                return redirect()->back()->with('success', 'Xóa thành công');
            } else {
                return redirect()->back()->with('error', 'Xóa thất bại');
            }
        } else {
            return redirect()->back()->with('error', 'Không tìm thấy ID');
        }
    }
}
