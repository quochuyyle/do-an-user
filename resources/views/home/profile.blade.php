@extends('layouts.master')
@section('content')
    <?php
    function time_elapsed_string($datetime, $full = false)
    {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'năm',
            'm' => 'tháng',
            'w' => 'tuần',
            'd' => 'ngày',
            'h' => 'giờ',
            'i' => 'phút',
            's' => 'giây',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? '' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' trước' : 'Vừa xong';
    }
    ?>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="banner-info mb-5">
                    <div class="mapInfo false" style="" data-reactid="47">
                        @if(Auth::user()->avatar == 'no-avatar.jpg')
                            <img style="color:#ffffff;background-color:rgb(188, 188, 188);user-select:none;display:inline-flex;align-items:center;justify-content:center;font-size:40px;border-radius:50%;height:80px;width:80px;"
                                 alt="Thành Trung" size="80" src="images/no-avatar.jpg" class="avatar"
                                 data-reactid="57">
                        @else
                            <img style="color:#ffffff;background-color:rgb(188, 188, 188);user-select:none;display:inline-flex;align-items:center;justify-content:center;font-size:40px;border-radius:50%;height:80px;width:80px;"
                                 alt="Thành Trung" size="80" src="uploads/avatars/{{Auth::user()->avatar}}"
                                 class="avatar" data-reactid="57">
                        @endif
                        <a href="user/profile/edit">
                            <div style="color: rgba(0, 0, 0, 0.87); background-color: transparent; transition: all 450ms cubic-bezier(0.23, 1, 0.32, 1) 0ms; box-sizing: border-box; font-family: Verdana, Arial, sans-serif; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 10px, rgba(0, 0, 0, 0.23) 0px 3px 10px; border-radius: 50%; display: inline-block; position: absolute; right: 20px; bottom: -17px;">
                                <button tabindex="0" type="button"
                                        style="border: 10px; box-sizing: border-box; display: inline-block; font-family: Verdana, Arial, sans-serif; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); cursor: pointer; text-decoration: none; margin: 0px; padding: 0px; outline: none; font-size: 25px; font-weight: inherit; position: relative; vertical-align: bottom; z-index: 1; background-color: rgb(255, 255, 255); transition: all 450ms cubic-bezier(0.23, 1, 0.32, 1) 0ms; height: 35px; width: 35px; overflow: hidden; border-radius: 50%; text-align: center; color: rgb(51, 51, 51);">
                                    <div>
                                        <div style="transition: all 450ms cubic-bezier(0.23, 1, 0.32, 1) 0ms; top: 0px;">
                                            <span class="ion-android-create"
                                                  style="color: rgb(51, 51, 51); position: relative; font-size: 25px; display: inline-block; user-select: none; transition: all 450ms cubic-bezier(0.23, 1, 0.32, 1) 0ms; height: 35px; line-height: 35px; fill: rgb(255, 255, 255);"><i
                                                        class="fas fa-pencil-alt"></i></span></div>
                                    </div>
                                </button>
                            </div>
                        </a>
                    </div>
                    <div class="info">
                        <h4 class="name" data-reactid="59">{{ Auth::user()->name }}</h4>
                        <div class="infoText">
                            Tham gia {{ time_elapsed_string(Auth::user()->created_at) }}
                            - {{ Auth::user()->created_at }}
                        </div>
                    </div>
                </div>
                <div class="mypage">
                    <h4>Tin đã đăng gần đây</h4>
                    @if(session('thongbao'))
                        <div class="alert bg-danger">
                            <button type="button" class="close" data-dismiss="alert"><span>×</span><span
                                        class="sr-only">Close</span></button>
                            <span class="text-semibold">Hi!</span> {{session('thongbao')}}
                        </div>
                    @endif
                    <div class="mainpage">
                        @if( count($mypost) < 1)
                            <div class="alert alert-info">
                                Bạn chưa có tin đăng phòng trọ nào đang cho thuê, thử đăng ngay.
                            </div>
                            <a href="user/dangtin" class="btn-post">ĐĂNG TIN</a>
                        @else
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Tiêu đề</th>
                                        <th>Danh mục</th>
                                        <th>Gía phòng</th>
                                        <th>Lượt xem</th>
                                        <th>Tình trạng</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($mypost as $post)
                                        <tr>
                                            <td>{{ $post->title }}</td>
                                            <td>{{ $post->category->name }}</td>
                                            <td>{{ $post->price }}</td>
                                            <td>{{ $post->count_view }}</td>
                                            <td>
                                                @if($post->approve == 1)
                                                    <span class="label label-success">Đã kiểm duyệt</span>
                                                @elseif($post->approve == 0)
                                                    <span class="label label-danger">Chờ Phê Duyệt</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="#" class="btn-editTerm" data-toggle="modal"
                                                   data-id="{{ $post->id }}" data-target="#editTerm">Gia hạn</a>
                                                <a href="phongtro/{{ $post->slug }}"><i class="fas fa-eye"></i> Xem</a>
                                                <a href="motelroom/del/{{ $post->id }}" style="color:red"><i
                                                            class="fas fa-trash-alt"></i> Xóa</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{--                            <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"--}}
                            {{--                                   style="width: 100%;">--}}
                            {{--                                <thead>--}}
                            {{--                                <tr style="text-align: center">--}}
                            {{--                                    <th style="font-weight: bold; width:5px;">{{ __('Số thứ tự') }}</th>--}}
                            {{--                                    <th style="font-weight: bold; width:20px;">{{ __('Tên phòng trọ') }}</th>--}}
                            {{--                                    <th style="font-weight: bold; width:20px;">{{ __('Loại phòng trọ') }}</th>--}}
                            {{--                                    <th style="font-weight: bold; width:20px;">{{ __('Gía phòng') }}</th>--}}
                            {{--                                    <th style="font-weight: bold; width:20px;">{{ __('Lượt xem') }}</th>--}}
                            {{--                                    <th style="font-weight: bold; width:40px;">{{ __('Trạng thái') }}</th>--}}
                            {{--                                    <th style="font-weight: bold; width:30px;">{{ __('Action') }}</th>--}}
                            {{--                                </tr>--}}
                            {{--                                </thead>--}}
                            {{--                                <tbody>--}}
                            {{--                                </tbody>--}}
                            {{--                            </table>--}}
                        @endif
                    </div>
                    <div class="modal fade" id="editTerm" tabindex="-1" role="dialog"
                         aria-labelledby="exampleModalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Gia hạn bài đăng</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home"
                                               role="tab" aria-controls="home" aria-selected="true">Gia hạn</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile"
                                               role="tab" aria-controls="profile" aria-selected="false">Lịch sử gia
                                                hạn</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="home" role="tabpanel"
                                             aria-labelledby="home-tab">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input type="hidden" id="motelroom_id" name="motelroom_id">
                                                    <input type="hidden" id="term_id" name="term_id">
                                                    {{--                                        <input type="hidden" id="motelroom_id" name="motelroom_id">--}}
                                                    <label for="start_date">Ngày bắt đầu:</label>
                                                    <input class="form-control" disabled type="text" name="start_date"
                                                           id="start_date"/>
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="end_date">Ngày kết thúc:</label>
                                                    <input class="form-control" disabled type="text" name="end_date"
                                                           id="end_date"/>
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="end_date">Gia hạn đến ngày:</label>
                                                    <input class="form-control" type="text" name="extend_term"
                                                           id="extend_term"/>
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="fee">Phí gia hạn:</label>
                                                    <input class="form-control" type="text" name="fee" id="fee"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="profile" role="tabpanel"
                                             aria-labelledby="profile-tab">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary btn-save">Save</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
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
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function () {

            {{--let datatable = $('#datatable').DataTable({--}}
            {{--    dom: 'Bfrtip',--}}
            {{--    "bLengthChange": false,--}}
            {{--    "bFilter": false,--}}
            {{--    "bInfo": false,--}}
            {{--    "bAutoWidth": false,--}}
            {{--    buttons: [--}}
            {{--        {--}}
            {{--            text: 'Add new button',--}}
            {{--            action: function (e, dt, node, config) {--}}
            {{--                dt.button().add(1, {--}}
            {{--                    text: 'Button ' + (counter++),--}}
            {{--                    action: function () {--}}
            {{--                        this.remove();--}}
            {{--                    }--}}
            {{--                });--}}
            {{--            }--}}
            {{--        }--}}
            {{--    ],--}}
            {{--    processing: true,--}}
            {{--    serverSide: true,--}}
            {{--    orderable: true,--}}

            {{--    ajax: {--}}
            {{--        url: '{{ route('user.dangtin.datatable') }}',--}}
            {{--        data: function (d) {--}}
            {{--            // d.search = $('input[name=search]').val()--}}
            {{--            // d.user_type = $('#user_type option:selected').val()--}}

            {{--        }--}}
            {{--    },--}}
            {{--    columns: [--}}
            {{--        {--}}
            {{--            data: 'DT_RowIndex',--}}
            {{--            name: 'DT_RowIndex',--}}
            {{--            searchable: false,--}}
            {{--            width: '6%',--}}
            {{--            className: 'text-center align-middle'--}}
            {{--        },--}}
            {{--        {data: 'username', name: 'username', className: 'text-center align-middle'},--}}
            {{--        {data: 'name', name: 'name', className: 'text-center align-middle'},--}}
            {{--        {data: 'email', name: 'email', className: 'text-center align-middle'},--}}
            {{--        {data: 'posts', name: 'posts', className: 'text-center align-middle'},--}}
            {{--        {data: 'tinhtrang', name: 'tinhtrang', className: 'text-center align-middle'},--}}
            {{--        {--}}
            {{--            data: 'action',--}}
            {{--            name: 'action',--}}
            {{--            width: '10%',--}}
            {{--            className: 'text-center align-middle',--}}
            {{--            orderable: false,--}}
            {{--            searchable: false--}}
            {{--        },--}}
            {{--    ]--}}
            {{--});--}}
            <?php

            ?>

            $('#extend_term').daterangepicker({
                singleDatePicker: true,
                opens: 'left',
                locale: {
                    format: 'DD-MM-YYYY'
                },
                autoUpdateInput: false,
                minDate: ''
            }, function (start, end, label) {
                let oldEnd_date = $('input[name="end_date"]').val(),
                    newEnd_date = start.format('DD-MM-YYYY');
                console.log(oldEnd_date)
                let a = moment(oldEnd_date, 'DDMMYYYY'),
                    b = moment(newEnd_date, 'DDMMYYYY');
                let diff = b.diff(a, 'days'),
                    feePerDay = 50000,
                    fee = feePerDay * diff;
                $('#fee').val(fee)
            });

            $('#extend_term').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.endDate.format('DD-MM-YYYY'));
            });

            $('#extend_term').on('cancel.daterangepicker', function (ev, picker) {
                $(this).val('');

            });
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })


            $(document).on('click', '.btn-editTerm', function (e) {
                e.preventDefault()

                let url = '{{ route('user.motelroom.show',':id') }}',
                    id = $(this).attr('data-id');
                url = url.replace(':id', id);
                // 		console.log(url)
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        id: id
                    },
                    success: function (res) {
                        // console.log(res.term.start_date)
                        $('input[name = start_date]').val(res.term.start_date)
                        $('input[name = end_date]').val(res.term.end_date)
                        $('#motelroom_id').val(id)
                        // $('#term_id').val(res.term.id)
                        $('#profile').html(res.view)
                        setTimeout(function () {
                            $('#editTerm').modal('show')
                        }, 3000)

                    }

                })
            })


            $(document).on('click', '.btn-save', function (e) {
                e.preventDefault()
                // console.log('Hello')

                let url = '{{ route('user.term.store') }}',
                    id = $('#motelroom_id').val(),
                    price = $('#fee').val(),
                    user_id = {{ \Illuminate\Support\Facades\Auth::user()->id }},
                    start_date = $('input[name = start_date]').val(),
                    end_date = $('#extend_term').val();
                url = url.replace(':id', id);

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        motelroom_id: id,
                        fee: price,
                        user_id: user_id,
                        start_date: start_date,
                        end_date: end_date
                    },
                    success: function (res) {
                        if (res.message) {
                            swalWithBootstrapButtons.fire(
                                'Thông báo',
                                res.message,
                                'success'
                            )
                            $('#editTerm').modal('hide')
                        } else {
                            swalWithBootstrapButtons.fire(
                                'Thông báo',
                                res.error,
                                'error'
                            )
                            $('#editTerm').modal('hide')
                        }

                    }
                })

            })
        })

    </script>
@endpush