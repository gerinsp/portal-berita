@extends('layouts.admin')

@section('title')
   Kontak
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
                                Kontak
                            </h1>
                        </div>
                        <div class="col-12 col-xl-auto mb-3">
                            
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
            <form action="{{ route('contact.update', $item->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row gx-4">
                    <div class="col-lg-12">
                        <div class="card mb-4">
                            <div class="card-header">Kontak</div>
                            <div class="card-body">
                                {{-- Alert --}}
                                @if (session()->has('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                                <div class="mb-4">
                                    <textarea class="form-control" name="contact_content" id="summernote" required>
                                        {{ $item->contact_content }}
                                    </textarea>
                                </div>
                                <div class="mb-0">
                                    <button type="submit" class="fw-500 btn btn-primary">
                                        Perbarui
                                    </button>
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
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endpush

@push('addon-script')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                height: "800px"
            });
        });
    </script>
@endpush
