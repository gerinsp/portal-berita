@extends('layouts.admin')

@section('title')
   Ubah Kategori
@endsection

@section('container')
    <main>
        <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
            <div class="container-fluid px-4">
                <div class="page-header-content">
                    <div class="row align-items-center justify-content-between pt-3">
                        <div class="col-auto mb-3">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="file-text"></i></div>
                                Ubah Kategori
                            </h1>
                        </div>
                        <div class="col-12 col-xl-auto mb-3">
                            <a class="btn btn-sm btn-light text-primary" href="{{ route('category.index') }}">
                                <i class="me-1" data-feather="arrow-left"></i>
                                Kembali Ke Semua Kategori
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Main page content-->
        <div class="container-fluid px-4">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <form action="{{ route('category.update', $item->id) }}" method="post" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="row gx-4">
                    <div class="col-lg-8">
                        <div class="card mb-4">
                            <div class="card-header">Ubah Kategori</div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="name">Nama</label>
                                    <input class="form-control" type="text" name="name" value="{{ $item->name }}"  required/>
                                </div>
                                <div class="mb-3">
                                    <label for="name">Kategori Induk</label>
                                    <select name="parent_id" class="form-control sub-category">
                                        <option value="">Tidak ada</option>
                                        @if ($categories)
                                            @foreach($categories as $category)
                                                <?php $dash=''; ?>
                                                <option value="{{$category->id}}" {{ ($category->id == $item->parent_id)? 'selected':''; }}>{{$category->name}}</option>
                                                @if(count($category->subcategory))
                                                    @include('pages.admin.category.create-sub-category',['subcategories' => $category->subcategory])
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>     
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card card-header-actions">
                            <div class="card-header">
                                Publish
                                <i class="text-muted" data-feather="info" data-bs-toggle="tooltip" data-bs-placement="left" title="Your updates will be live once a moderator approves the changes."></i>
                            </div>
                            <div class="card-body">
                                <div class="d-grid">
                                    <button class="fw-500 btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
@endsection

@push('addon-style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.1.1/dist/select2-bootstrap-5-theme.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
@endpush

@push('addon-script')
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script>
    $(".sub-category").select2({
        theme: "bootstrap-5",
    });
  </script>
@endpush
