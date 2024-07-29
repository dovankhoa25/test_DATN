@extends('category.layoutadmin')
@section('title')
    Sửa danh mục
@endsection
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(session('success'))
        <div class="alert alert-success">
            {{session('success')}}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            {{session('error')}}
        </div>
    @endif

    <form action="{{route('categories.update',['id'=>$idCate->id])}}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" class="form-control" name="name" placeholder="Tên sản phẩm" value="{{$idCate->name}}">
        </div>
        <div class="mb-3">
            <label class="form-label">Status</label>
            <select class="form-select" aria-label="Danh mục sản phẩm" name="status">
                <option value="1"
                @if ($idCate->status == 1)
                    selected
                @endif
                >Public</option>
                <option value="0"
                @if ($idCate->status == 0)
                    selected
                @endif
                >Private</option>
            </select>
            <p>(Khi sửa trạng thái, các sản phẩm liên quan sẽ đồng thời được cập nhật theo trang thái danh mục)</p>
        </div>
        <button type="submit" class="btn btn-success">Sửa</button>
        <a class="btn btn-light" href="{{route('categories.index')}}">Quay lại trang chủ</a>
    </form>
@endsection

