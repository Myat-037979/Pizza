@extends('admin.layouts.master')

@section('title', 'Category List Page')

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="overview-wrap">
                                <h2 class="title-1">Contact List</h2>

                            </div>
                        </div>
                    </div>

                    <h4>Total - {{ $contacts->total() }}</h4>

                    <div class="table-responsive table-responsive-data2 mt-4">
                        <table class="table table-data2 text-center">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Message</th>
                                    <th>Date</th>
                                    <th></th>
                                    <th></th>

                                </tr>
                            </thead>
                            <tbody id="dataList">
                                @foreach ($contacts as $con)
                                    <tr>
                                        <td>{{ $con->name }}</td>
                                        <td>{{ $con->email }}</td>
                                        <td>{{ $con->message }}</td>
                                        <td>{{ $con->created_at->format('F-j-Y') }}</td>
                                        <td>
                                            <div class="table-data-feature">
                                                <a href="{{ route('admin#contactDelete', $con->id) }}">
                                                    <button class="item me-1" data-toggle="tooltip" data-placement="top"
                                                        title="Delete">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </button>
                                                </a>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-5">
                            {{ $contacts->links() }}
                        </div>
                    </div>
                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
