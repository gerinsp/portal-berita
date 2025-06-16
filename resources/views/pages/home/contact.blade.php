@extends('layouts.app')

@section('title')
    Kontak
@endsection

@section('content')
 <!--main content-->
<div class="main_content pb-50 pt-50">
    <!--archive header-->
    <div class="page-header page-header-style-1 text-center">
        <div class="container">
            <h2><span class="color2">Kontak</span></h2>
            <div class="breadcrumb">
                <a href="{{ route('home') }}" rel="nofollow">Beranda</a>
                <span></span> Kontak
            </div>
            <div class="bt-1 border-color-1 mt-30 mb-50"></div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="entry-main-content">
                    {!! $item->contact_content !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
