@extends('layouts.master')

@section('content')
<div class="d-flex mb-1">
    <div class="flex-shrink-0 me-3">
        <i class="bx bx-book display-4 text-primary mt-1"></i>
    </div>
    <div class="flex-grow-1 my-0">
        <h1 class="mb-0">Report</h1>
        <p class="fs-4">Manage Restaurant</p>
    </div>
</div>

<div class="w-100">
    <div class="card">
        <div class="card-body">
            <div class="row mt-3">
                <div class="col-sm-6 col-xl-6">
                    <div class="p-3 bg-info rounded overflow-hidden position-relative text-white mb-g d-flex align-items-center justify-content-center" id="orderCard">
                        <div class="text-center">
                            <i class="fa fa-money-bill fa-5x"></i>
                            <h5 class="display-6 d-block l-h-n m-0 fw-500 text-white">
                                RM {{ $approved_sum }}
                            </h5>
                            TOTAL SALES (OVERALL)
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-6">
                    <div class="p-3 bg-info rounded overflow-hidden position-relative text-white mb-g d-flex align-items-center justify-content-center" id="orderCard">
                        <div class="text-center">
                            <i class="fa fa-money-bill fa-5x"></i>
                            <h5 class="display-6 d-block l-h-n m-0 fw-500 text-white">
                                RM {{ $today_sum }}
                            </h5>
                            TOTAL SALES (TODAY)
                        </div>
                    </div>
                </div>
            </div>

            <ul class="nav nav-tabs mb-3 mt-3" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="overall-tab" data-bs-toggle="tab" data-bs-target="#overall_tab" type="button" role="tab" aria-controls="overall_tab" aria-selected="true">Total Overall</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="today-tab" data-bs-toggle="tab" data-bs-target="#today_tab" type="button" role="tab" aria-controls="today_tab" aria-selected="false">Today</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="overall_tab" role="tabpanel" aria-labelledby="overall-tab">
                    <table class="table table-bordered table-striped">
                        <tr class="text-center">
                            <td>Payment ID</td>
                            <td>Restaurant</td>
                            <td>Description</td>
                            <td>Email</td>
                            <td>Amount</td>
                            <td>Date</td>
                        </tr>
                        @foreach($approved as $approves)
                        <tr>
                            <td>{{ $approves['payment_id'] }}</td>
                            <td>{{ isset($approves['order']['restaurant']['name']) ? $approves['order']['restaurant']['name'] : '' }}</td>
                            <td>{{ isset($approves['order']['description']) ? $approves['order']['description'] : '' }}</td>
                            <td>{{ $approves['payer_email'] }}</td>
                            <td>{{ $approves['amount'] }}</td>
                            <td>{{ $approves['created_at'] }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>

                <div class="tab-pane fade show" id="today_tab" role="tabpanel" aria-labelledby="today-tab">
                    <table class="table table-bordered table-striped">
                        <tr class="text-center">
                            <td>Payment ID</td>
                            <td>Email</td>
                            <td>Amount</td>
                        </tr>
                        @foreach($today as $todays)
                        <tr>
                            <td>{{ $todays['payment_id'] }}</td>
                            <td>{{ $todays['payer_email'] }}</td>
                            <td>{{ $todays['amount'] }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>


@endsection

@section('script')
@endsection
