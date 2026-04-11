@extends('layouts.app')

@section('hide_default_nav', '1')
@section('body_class', trim('portal-page-body ' . $__env->yieldContent('body_class')))
@section('main_class', $__env->yieldContent('main_class', 'portal-page-main'))

@section('content')
    @yield('page_content')
@endsection
