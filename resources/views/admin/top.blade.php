@extends('admin.layouts.app')

@section('title', '管理者トップ')

@section('content')
<!-- 管理者情報（上マージン付き） -->
<div class="mt-5 flex justify-center">
    <div class="container mx-auto p-4 bg-white border border-gray-300 rounded-0 w-70 fs-3 space-y-2">
        <p>ユーザー名：{{ Auth::guard('admin')->user()->name }}</p>
        <p>メールアドレス：{{ Auth::guard('admin')->user()->email }}</p>
    </div>
</div>
@endsection