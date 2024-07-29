<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    use HasFactory;
    protected $table = "categories";
    protected $fillable = [
      'id',
      'name',
      'status',
      'created_at',
      'updated_at',
    ];
    public $timestamps = false;

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function loadAllCategory(){
//        $query = DB::table($this->table.' as cate')
//            ->select($this->fillable)
//            ->get();

        //QRM
        $query = Category::query()
        // ->where('status', '=', 1)
        ->get();
        return $query;
    }

    public function loadListCate(){
        $query = Category::query()
        ->orderBy('id')->get();
        // ->paginate(5);
        return $query;
    }

    public function insertDataCate($params){
        $params['created_at'] = date('Y-m-d H:i:s');
        $res = Category::query()->create($params);
        return $res;
    }

    public function loadIdCate($id){
        $query = Category::query()
        ->find($id);
        return $query;
    }

    public function updateDataCate($params, $id){
        $res = Category::query()
        ->find($id)->update($params);
        return $res;
    }

    public function updateProductStatus($categoryId, $status)
    {
        $products = Product::where('category_id', $categoryId)->get();
        foreach ($products as $product) {
            $product->update(['status' => $status]);
        }
    }

    public function deleteDataCatet($id){
        $res = Product::query()->find($id)->delete();
        return $res;
    }
}
