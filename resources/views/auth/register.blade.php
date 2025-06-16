@extends('layouts.auth')

@section('main')
    <main>
        <div class="container-xl px-4">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <!-- Basic registration form-->
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header justify-content-center"><h3 class="fw-light my-4">Create Account</h3></div>
                        <div class="card-body">
                            <!-- Registration form-->
                            <form action="/register" method="post">
                                @csrf
                                <!-- Form Row-->
                                <div class="row gx-3">
                                    <div class="col-md-12">
                                        <!-- Form Group (first name)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="name">Full Name</label>
                                            <input class="form-control @error('name') is-invalid @enderror" id="name" name="name" type="text" value="{{ old('name') }}" placeholder="Enter first name" required autofocus/>
                                            @error('name')
                                                <div class="invalid-feedback">
                                                    {{ $message; }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <!-- Form Group (email address) -->
                                <div class="mb-3">
                                    <label class="small mb-1" for="email">Email</label>
                                    <input class="form-control @error('email') is-invalid @enderror" id="email" name="email" type="email" value="{{ old('email') }}" placeholder="Enter email address" required/>
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message; }}
                                        </div>
                                    @enderror
                                </div>
                                <!-- Form Row    -->
                                <div class="row gx-3">
                                    <div class="col-md-12">
                                        <!-- Form Group (password)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="password">Password</label>
                                            <input class="form-control @error('password') is-invalid @enderror" name="password" id="password" type="password" placeholder="Enter password" />
                                            @error('password')
                                                <div class="invalid-feedback">
                                                    {{ $message; }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-6">
                                        <!-- Form Group (confirm password)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="inputConfirmPassword">Confirm Password</label>
                                            <input class="form-control" id="inputConfirmPassword" type="password" placeholder="Confirm password" />
                                        </div>
                                    </div> --}}
                                </div>
                                <!-- Form Group (create account submit)-->
                                <button class="btn btn-primary btn-block" type="submit">Create Account</button>
                            </form>
                        </div>
                        <div class="card-footer text-center">
                            <div class="small"><a href="/login">Have an account? Go to login</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection