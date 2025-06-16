@extends('layouts.admin')

@section('title')
    Tag
@endsection

@section('container')
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mt-4">
                            <h1 class="page-header-title">
                                <div class="page-header-icon">
                                    <i data-feather="file-text"></i>
                                </div>
                                Tag
                            </h1>
                            <div class="page-header-subtitle">List Tag</div>
                        </div>
                    </div>
                    <nav class="mt-4 rounded" aria-label="breadcrumb">
                        <ol class="breadcrumb px-3 py-2 rounded mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item">Pos</li>
                            <li class="breadcrumb-item active">Tag</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </header>
        <!-- Main page content-->
        <div class="container-xl px-4 mt-n10">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-header">Tambah Tag Baru</div>
                        <div class="card-body">
                            <form action="{{ route('tag.store') }}" method="post" autocomplete="off" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="name">Nama</label>
                                    <input class="form-control" name="name" type="text" required>
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-md btn-primary">Tambah Tag Baru</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header">List Tag</div>
                        <div class="card-body">
                            {{-- Alert --}}
                            @if (session()->has('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
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
                            {{-- List Data --}}
                            <table class="table table-striped table-hover table-sm" id="crudTable">
                                <thead>
                                    <tr>
                                        <th width="10">No.</th>
                                        <th>Nama</th>
                                        <th>Slug</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>           
        </div>
    </main>
@endsection

@push('addon-script')
  <script>
    var datatable = $('#crudTable').DataTable({
        processing: true,
        serverSide: true,
        ordering: true,
        ajax: {
          url: '{!! url()->current() !!}',
        },
        columns: [
          { data: 'DT_RowIndex', name: 'DT_RowIndex' },
          { data: 'name', name: 'name' },
          { data: 'slug', name: 'slug' },
          { 
            data: 'action', 
            name: 'action',
            orderable: false,
            searcable: false,
            width: '15%'
          },
        ]
    });
  </script>
@endpush