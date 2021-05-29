@extends('layouts.master')
@section('style-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
@endsection
@section('content')
    <div class="gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="entry-title entry-prop">Gia hạn bài đăng</h1>
                <hr>
                <div class="panel panel-default">
                    <div class="panel-heading">Thông tin bắt buộc*</div>
                    <div class="panel-body">
                        <form action="{{ route ('user.term.store', $motelroom->id) }}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="user_id" value="{{ \Illuminate\Support\Facades\Auth::user()->id }}">
                            <input type="hidden" name="motelroom_id" value="{{ $motelroom->id }}">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="start_date">Ngày bắt đầu</label>
                                    <input class="form-control" id="start_date" type="text" name="start_date" readonly
                                           value="{{ $motelroom->start_date ? $motelroom->start_date : old('start_date') }}"/>
                                </div>
                                <div class="col-md-6">
                                    <label for="end_date">Ngày kết thúc</label>
                                    <input class="form-control" id="end_date" type="text" name="end_date" readonly
                                           value="{{ $motelroom->end_date ? $motelroom->end_date : old('start_date') }}"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="postCategory">Loại bài đăng:</label>
                                    <select class="form-control" name="post_type" id="postCategory">
                                        @foreach($postCategories as $postCategory)
                                            <option data-value="{{ $postCategory->price }}"
                                                    value="{{ $postCategory->id }}">{{ $postCategory->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="term">Ngày bắt đầu và kết thúc:</label>
                                        <input class="form-control" id="term" type="text" name="term" value="{{ old('term') }}"
                                               autocomplete="off"/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="fee">Phí đăng tin</label>
                                        <input class="form-control" id="fee" type="text" name="fee"
                                               value="{{ old('fee') }}"/>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Gia hạn</button>
                            <a href="user/profile" class="btn btn-danger">Quay lại</a>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('after-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
            integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
            crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        $(document).ready(function () {

            $('#postCategory').change(function () {
                $('#term').val('')
                $('input[name = fee]').val('')
            })

            $('#term').daterangepicker({
                singleDatePicker: true,
                opens: 'left',
                locale: {
                    format: 'DD-MM-YYYY'
                },
                autoUpdateInput: false,
                 minDate: moment({{ $motelroom->end_date }}, "DDMMYYYY").add(1, 'd')
            }, function (start, end, label) {
                let oldEnd_date = $('input[name="end_date"]').val(),
                    newEnd_date = start.format('DD-MM-YYYY');
                // console.log(oldEnd_date)
                let a = moment(oldEnd_date, 'DDMMYYYY'),
                    b = moment(newEnd_date, 'DDMMYYYY');
                let diff = b.diff(a, 'days'),
                    feePerDay = $('#postCategory').find(':selected').data('value'),//50000
                    fee = feePerDay * diff;
                console.log(feePerDay)
                $('#fee').val(fee)
            });

            $('#term').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.endDate.format('DD-MM-YYYY'));
            });

            $('#term').on('cancel.daterangepicker', function (ev, picker) {
                $(this).val('');

            });
        })
    </script>
@endpush