@extends('admin.layouts.master')

@section('title', 'Category List Page')

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">

                    <h3>Total - {{ $users->total() }}</h3>

                    <div class="table-responsive table-responsive-data2 mt-4">
                        <table class="table table-data2 text-center">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Gender</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Role</th>
                                    <th></th>
                                    <th></th>

                                </tr>
                            </thead>
                            <tbody id="dataList">
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="col-2">
                                            @if ($user->image == null)
                                                @if ($user->gender == 'male')
                                                    <img src="{{ asset('image/default_user.png') }}"
                                                        class="img-thumbnail shadow-sm" alt="">
                                                @else
                                                    <img src="{{ asset('image/female_default.jpg') }}"
                                                        class="img-thumbnail shadow-sm" alt="">
                                                @endif
                                            @else
                                                <img src="{{ asset('storage/' . $user->image) }}" />
                                            @endif
                                        </td>
                                        <input type="hidden" name="" id="userId" value="{{ $user->id }}">
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->gender }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>{{ $user->address }}</td>
                                        <td>{{ $user->role }}</td>
                                        <td>
                                            <select name="" id="" class="form-control statusChange">
                                                <option value="user" @if ($user->role == 'user') selected @endif>
                                                    User</option>
                                                <option value="admin" @if ($user->role == 'admin') selected @endif>
                                                    Admin</option>
                                            </select>
                                        </td>
                                        <td>
                                            <div class="table-data-feature">
                                                <a href="{{ route('admin#UserUpdatePage', $user->id) }}">
                                                    <button class="item me-1" data-toggle="tooltip" data-placement="top"
                                                        title="Edit">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </button>
                                                </a>
                                            </div>
                                            <div class="table-data-feature">
                                                <a href="{{ route('admin#UserDelete', $user->id) }}">
                                                    <button class="item me-1" data-toggle="tooltip" data-placement="top"
                                                        title="Delete">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </button>
                                                </a>
                                            </div>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-5">
                            {{ $users->links() }}
                        </div>
                    </div>
                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection

@section('scriptSource')
    <script>
        $(document).ready(function() {
            $('.statusChange').change(function() {
                $currentStatus = $(this).val();
                $parentNode = $(this).parents("tr");
                $userId = $parentNode.find('#userId').val();

                $data = {
                    'userId': $userId,
                    'role': $currentStatus
                };

                $.ajax({
                    type: 'get',
                    url: '/user/change/role',
                    data: $data,
                    dataType: 'json',
                })
                location.reload();
            })
        })
    </script>
@endsection
