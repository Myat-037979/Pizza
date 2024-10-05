@extends('user.layouts.master')

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6 offset-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title">
                                    <h3 class="text-center title-2">Contact Us</h3>
                                </div>
                                <hr>
                                <form action="{{ route('user#SendMail') }}" method="post" novalidate="novalidate">
                                    @csrf
                                    <div class="form-group">
                                        <label class="control-label mb-1">Name</label>
                                        <input type="text" name="contactName" value="{{ old('contactName') }}"
                                            class="form-control @error('contactName') is-invalid @enderror"
                                            aria-required="true" aria-invalid="false" placeholder="Enter Your Name...">
                                        @error('contactName')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label mb-1">Email</label>
                                        <input type="email" name="contactEmail" value="{{ old('contactEmail') }}"
                                            class="form-control @error('contactEmail') is-invalid @enderror"
                                            aria-required="true" aria-invalid="false" placeholder="Enter Your Email...">
                                        @error('contactEmail')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label mb-1">Message</label>
                                        <textarea class="form-control @error('contactMessage') is-invalid @enderror" name="contactMessage" id=""
                                            cols="30" rows="10" placeholder="Enter Your Message...">{{ old('contactMessage') }}</textarea>
                                        @error('contactMessage')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div>
                                        <button id="payment-button" type="submit" class="btn btn-lg btn-warning btn-block">
                                            <span id="payment-button-amount">Send</span>
                                            <i class="fa-solid fa-circle-right"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MAIN CONTENT-->
    @endsection
