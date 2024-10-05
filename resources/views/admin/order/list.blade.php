@extends('admin.layouts.master')

@section('title', 'Category List Page')

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="overview-wrap">
                                <h2 class="title-1">Order List</h2>

                            </div>
                        </div>
                    </div>

                    @if (session('deleteSuccess'))
                        <div class="col-4 offset-8">
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <i class="fa-solid fa-circle-xmark"></i> {{ session('deleteSuccess') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-3">
                            <h4 class="text-secondary">Search Key : <span class="text-danger">{{ request('key') }}</span>
                            </h4>
                        </div>
                        {{-- <div class="col-3 offset-6 ">
                            <form action="{{ route('admin#orderList') }}" method="GET">
                                @csrf
                                <div class="d-flex">
                                    <input type="text" name="key" value="{{ request('key') }}" class="form-control"
                                        placeholder="search...">
                                    <button class="btn btn-dark text-white" type="submit">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                            </form>
                        </div> --}}
                    </div>

                    <div class="row mt-2">
                        <div class="col-1 offset-10 bg-white shadow-sm p-2 text-center">
                            <h3> <i class="fa-solid fa-database mr-2"></i> {{ count($order) }} </h3>
                        </div>
                    </div>

                    <form action="{{ route('admin#changeStatus') }}" method="get">
                        @csrf
                        <div class="d-flex ">
                            <label for="" class="mt-1 me-4">Order Status</label>
                            <select name="orderStatus" id="orderStatus" class="form-control col-2">
                                <option value="">All
                                </option>
                                <option value="0" @if (request('orderStatus') == '0') selected @endif>Pending
                                </option>
                                <option value="1" @if (request('orderStatus') == '1') selected @endif>Success
                                </option>
                                <option value="2" @if (request('orderStatus') == '2') selected @endif>Reject
                                </option>
                            </select>

                            <button type="submit" class="btn btn-sm bg-dark text-white ms-3"><i
                                    class="fa-solid fa-magnifying-glass me-3"></i>Search</button>
                        </div>
                    </form>

                    <div class="table-responsive table-responsive-data2 mt-4">
                        <table class="table table-data2 text-center">
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>User Name</th>
                                    <th>Order Date</th>
                                    <th>OrderCode</th>
                                    <th>Amount</th>
                                    <th>Status</th>

                                </tr>
                            </thead>
                            <tbody id="dataList">
                                <tr class="tr-shadow">
                                    @foreach ($order as $o)
                                <tr class="tr-shadow">
                                    <input type="hidden" name="" class="orderId" value="{{ $o->id }}">
                                    <td>{{ $o->user_id }}</td>
                                    <td>{{ $o->user_name }}</td>
                                    <td>{{ $o->created_at->format('F-j-Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin#listInfo', $o->order_code) }}">{{ $o->order_code }}</a>
                                    </td>
                                    <td>{{ $o->total_price }} Kyats</td>
                                    <td>
                                        <select name="status" id="" class="form-control statusChange">
                                            <option value="0" @if ($o->status == 0) selected @endif>Pending
                                            </option>
                                            <option value="1" @if ($o->status == 1) selected @endif>Success
                                            </option>
                                            <option value="2" @if ($o->status == 2) selected @endif>Reject
                                            </option>
                                        </select>
                                    </td>
                                </tr>
                                @endforeach
                                </tr>
                            </tbody>
                        </table>
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
            // $('#orderStatus').change(function() {
            //     $status = $('#orderStatus').val();

            //     $.ajax({
            //         type: 'get',
            //         url: 'http://127.0.0.1:8000/order/ajax/status',
            //         data: {
            //             'status': $status
            //         },
            //         dataType: 'json',
            //         success: function(response) {
            //             $list = ``;
            //             for ($i = 0; $i < response.length; $i++) {

            //                 $months = ['January', 'February', 'March', 'April', 'May', 'Jun',
            //                     'July', 'August', 'September', 'October', 'November',
            //                     'December'
            //                 ];
            //                 $dbDate = new Date(response[$i].created_at);
            //                 $finalDate = $months[$dbDate.getMonth()] + "-" + $dbDate.getDate() +
            //                     "-" + $dbDate.getFullYear();

            //                 if (response[$i].status == 0) {
            //                     $statusMessage = `
        //                         <select name="status" id="" class="form-control statusChange">
        //                                 <option value="0" selected>Pending
        //                                 </option>
        //                                 <option value="1">Success
        //                                 </option>
        //                                 <option value="2">Reject
        //                                 </option>
        //                         </select>
        //                     `;
            //                 } else if (response[$i].status == 1) {
            //                     $statusMessage = `
        //                         <select name="status" id="" class="form-control statusChange">
        //                                 <option value="0">Pending
        //                                 </option>
        //                                 <option value="1" selected>Success
        //                                 </option>
        //                                 <option value="2">Reject
        //                                 </option>
        //                         </select>
        //                     `;
            //                 } else if (response[$i].status == 2) {
            //                     $statusMessage = `
        //                         <select name="status" id="" class="form-control statusChange">
        //                                 <option value="0">Pending
        //                                 </option>
        //                                 <option value="1">Success
        //                                 </option>
        //                                 <option value="2" selected>Reject
        //                                 </option>
        //                         </select>
        //                     `;
            //                 }


            //                 $list += `
        //                     <tr class="tr-shadow">
        //                         <input type="hidden" name="" class="orderId" value="${response[$i].user_id}">
        //                         <td> ${response[$i].user_id} </td>
        //                         <td> ${response[$i].user_name} </td>
        //                         <td> ${$finalDate} </td>
        //                         <td> ${response[$i].order_code} </td>
        //                         <td> ${response[$i].total_price}  Kyats</td>
        //                         <td> ${$statusMessage} </td>
        //                     </tr>
        //                 `;
            //             }
            //             $('#dataList').html($list);
            //         }
            //     })
            // })
            //change status
            $('.statusChange').change(function() {
                // $parentNode = $(this).parents("tr");
                // $price = Number($parentNode.find('#price').text().replace("Kyats", ""));
                // $qty = Number($parentNode.find('#qty').val());
                // $total = $price * $qty;
                // $parentNode.find('#total').html(`${$total} Kyats`);

                $currentStatus = $(this).val();
                $parentNode = $(this).parents("tr");
                $orderId = $parentNode.find('.orderId').val();

                $data = {
                    'orderId': $orderId,
                    'status': $currentStatus
                };

                $.ajax({
                    type: 'get',
                    url: '/order/ajax/change/status',
                    data: $data,
                    dataType: 'json',
                })
            })
        })
    </script>
@endsection
