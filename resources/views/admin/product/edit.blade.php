@extends('admin.layouts.master')

@section('title', 'Category List Page')

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="row">
            <div class="col-3 offset-7 mb-2">
                @if (session('updateSuccess'))
                    <div class="">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fa-solid fa-circle-xmark"></i> {{ session('updateSuccess') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-10 offset-1">
                    <div class="card">
                        <div class="card-body">
                            <div class="ms-5">
                                {{-- <a href="{{ route('product#list') }}" class="text-decoration-none "> --}}
                                <i class="fa-solid fa-arrow-left text-dark" onclick="history.back()"></i>
                                {{-- </a> --}}
                            </div>
                            <div class="card-title">
                                {{-- <h3 class="text-center title-2">Pizza Details</h3> --}}
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-3 offset-1">
                                    <img src="{{ asset('storage/' . $pizza->image) }}" alt=""
                                        class="img-thumbnail shadow-sm">
                                </div>
                                <div class="col-8">
                                    <h3 class="my-3 btn btn-danger text-white d-block w-50 fs-4 text-center">
                                        {{ $pizza->name }}
                                    </h3>
                                    <span class="my-3 btn btn-dark text-white"> <i
                                            class="fa-solid fa-money-bill-1-wave me-2 fs-5"></i>
                                        {{ $pizza->price }} kyats
                                    </span>
                                    <span class="my-3 btn btn-dark text-white"> <i class="fa-solid fa-clock me-2 fs-5"></i>
                                        {{ $pizza->waiting_time }} mins
                                    </span>
                                    <span class="my-3 btn btn-dark text-white"> <i class="fa-solid fa-eye me-2 fs-5"></i>
                                        {{ $pizza->view_count }}</span>
                                    <span class="my-3 btn btn-dark text-white"> <i class="fa-solid fa-clone me-2 fs-5"></i>
                                        {{ $pizza->category_name }}</span>
                                    <span class="my-3 btn btn-dark text-white"> <i
                                            class="fa-solid fa-user-clock me-2 fs-5"></i>
                                        {{ $pizza->created_at->format('j-F-y') }}</span>
                                    <div class="my-3"> <i class="fa-solid fa-file-lines me-2 fs-5"></i>
                                        Details </div>
                                    <div class="">
                                        {{ $pizza->description }}
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
