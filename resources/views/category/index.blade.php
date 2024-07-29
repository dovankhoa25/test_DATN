@extends('category.layoutadmin')
@section('title')
    Danh sách danh mục
@endsection
@section('content')
    <div class="d-flex gap-2">
        <a class="btn btn-secondary" href="{{route('categories.create')}}">Thêm danh mục</a>
        {{-- <a class="btn btn-secondary" href="{{route('products.index')}}"> Xem sản phẩm</a> --}}
    </div>
    
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Status</th>
            <th colspan="2">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($listCate as $items)
            <tr>
                <td>{{$items->id}}</td>
                <td>{{$items->name}}</td>
                {{-- <td>{{$items->status}}</td> --}}
                <td>
                    @if ($items->status == 1)
                        <div class="badge bg-success fs-6" style="width:100px;">Public</div>
                    @else
                    <div class="badge bg-danger fs-6" style="width:100px;">Private</div>
                    @endif
                </td>
                <td>
                    <a href="{{route('categories.edit',['id'=>$items->id])}}" class="btn btn-warning">Sửa</a>
                </td>
                <td>
                    <form action="{{route('categories.destroy',['id'=>$items->id])}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa không?. (Khi thực hiện sẽ xóa các sản phẩm liên quan đến danh mục này!)')">Xóa</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{-- {{$listCate->links()}} --}}
@endsection
