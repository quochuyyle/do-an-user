@extends('layouts.master')
@section('content')
    <div class="gap"></div>
    <div class="container">
        <div class="payment-wrapper">
            <div class="row">
                <div class="col-4">
                    <div class="card">
                        <img class="card-img-top payment-img" src="{{ asset('images/bank.png') }}" alt="Card image cap">
                        <div class="card-body">

                            <h5 class="card-title title">
                                <button class="btn btn-information" type="button" data-toggle="collapse"
                                        data-target="#collapseExample1" aria-expanded="false"
                                        aria-controls="collapseExample1">
                                    Chuyển khoản
                                </button>
                                <div class="collapse" id="collapseExample1">
                                    <div class="card card-body">

                                    </div>
                                </div>
                            </h5>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card">
                        <img class="card-img-top payment-img" src="{{ asset('images/mobile_card.png') }}"
                             alt="Card image cap">
                        <div class="card-body">

                            <h5 class="card-title title">
                                <button class="btn btn-information" type="button" data-toggle="collapse"
                                        data-target="#collapseExample2" aria-expanded="false"
                                        aria-controls="collapseExample2">
                                  Nạp thẻ điện thoại
                                </button>
                                <div class="collapse" id="collapseExample2">
                                    <div class="card card-body">

                                    </div>
                                </div>
                            </h5>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card">
                        <img class="card-img-top payment-img" src="{{ asset('images/momo.png') }}" alt="Card image cap">
                        <div class="card-body">

                            <h5 class="card-title title">
                                <button class="btn btn-information" type="button" data-toggle="collapse"
                                        data-target="#collapseExample3" aria-expanded="false"
                                        aria-controls="collapseExample3">
                                    Momo
                                </button>
                                <div class="collapse" id="collapseExample3">
                                    <div class="card card-body">

                                    </div>
                                </div>
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        $(document).ready(function () {

        })
    </script>
@endsection