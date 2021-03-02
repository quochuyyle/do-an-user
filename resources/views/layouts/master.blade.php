<!DOCTYPE html>
<html lang="en">
<head>
    <title>Tìm phòng trọ</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <base href="{{asset('')}}">
    {{--	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap">--}}
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="assets/awesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="assets/toast/toastr.min.css">
    <script src="assets/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/myjs.js"></script>
    <link rel="stylesheet" href="assets/selectize.default.css" data-theme="default">
    <script src="assets/js/fileinput/fileinput.js" type="text/javascript"></script>
    <script src="assets/js/fileinput/vi.js" type="text/javascript"></script>
    <link rel="stylesheet" href="assets/fileinput.css">
    <script src="assets/pgwslider/pgwslider.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="assets/pgwslider/pgwslider.min.css">


    <!-- sortable.min.js is only needed if you wish to sort / rearrange files in initial preview.
        This must be loaded before fileinput.min.js -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/plugins/sortable.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/plugins/purify.min.js" type="text/javascript"></script> -->
    <link rel="stylesheet" href="assets/bootstrap/bootstrap-select.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="assets/bootstrap/bootstrap-select.min.js"></script>
    @stack('before-script')
    @stack('style-css')
</head>
<body>
<nav class="navbar navbar-inverse">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href=""><img
                        src="https://thumbs.dreamstime.com/b/motel-icon-white-background-simple-element-illustration-city-elements-concept-sign-symbol-design-141333219.jpg"
                        style="width: 40px;height: auto;"></a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                @foreach($categories as $category)
                    <li><a href="category/{{$category->id}}">{{ $category->name }}</a></li>
                @endforeach
            </ul>
            @if(Auth::user())
                <ul class="nav navbar-nav navbar-right">
                    <li><a class="btn-dangtin" href="user/dangtin"><i class="fas fa-edit"></i> Đăng tin ngay</a></li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Xin chào! {{Auth::user()->name}}
                            <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="user/profile">Thông tin chi tiết</a></li>
                            <li><a href="user/dangtin">Đăng tin</a></li>
                            <li><a href="user/logout">Thoát</a></li>
                        </ul>
                    </li>
                    <li>
                        {{--                        <i class="fas fa-bell" id="notification" style="padding-top: 19px;font-size: 30px;">--}}
                        {{--                            <div class="counter-block"><span class="counter">1</span></div>--}}
                        {{--                        </i>--}}
                        <div class="dropdown" style="float: right; padding: 13px;position: relative">
                            <a href="#" onclick="return false;" role="button" data-toggle="collapse" id="dropdownMenu1"
                               data-target="#dropDownList" style="float: left" aria-expanded="true">
                                <i class="fa fa-bell" id="notification"
                                   style="font-size: 27px !important; float: left; color:#2C2E2F">
                                    <div class="counter-block">
                                        <span class="counter">1</span>
                                    </div>
                                </i>
                            </a>
                            <span class="badge badge-danger counter"></span>
                            <ul class="dropdown-menu dropdown-menu-left pull-right" id="dropDownList" role="menu"
                                aria-labelledby="dropdownMenu1">
                                <li role="presentation">
                                    <a href="#" class="dropdown-menu-header">Thông báo</a>
                                </li>
                                <ul class="timeline timeline-icons timeline-sm" id="list-noti"
                                    style="margin:10px;width:250px">
                                    @empty(!$notifications)
                                        @foreach($notifications as $notification)
                                            <li>
                                                <p class="noti-image">
                                                    {{$notification->content}}
                                                    <span class="timeline-icon"><i class="fa fa-file-pdf-o"
                                                                                   style="color:red"></i></span>
                                                    <span class="timeline-date">{{$notification->created_at->diffForHumans()}}</span>
                                                </p>
                                            </li>
                                        @endforeach
                                    @else
                                        <li>
                                            <p class="noti-image">
                                                Không có thông báo nào !
                                            </p>
                                        </li>
                                    @endempty
                                    {{--                                    <li>--}}
                                    {{--                                        <p>--}}
                                    {{--                                            Your “Marketplace Report” PDF is ready <a href="">here</a>--}}
                                    {{--                                            <span class="timeline-icon"><i class="fa fa-file-pdf-o"  style="color:red"></i></span>--}}
                                    {{--                                            <span class="timeline-date">Dec 6, 10:17</span>--}}
                                    {{--                                        </p>--}}
                                    {{--                                    </li>--}}
                                    {{--                                    <li>--}}
                                    {{--                                        <p>--}}
                                    {{--                                            Your “Top Words” spreadsheet is ready <a href="">here</a>--}}
                                    {{--                                            <span class="timeline-icon"><i class="fa fa-file-excel-o"  style="color:green"></i></span>--}}
                                    {{--                                            <span class="timeline-date">Dec 5, 04:36</span>--}}
                                    {{--                                        </p>--}}
                                    {{--                                    </li>--}}
                                </ul>
                                <li role="presentation">
                                    <a href="#" class="dropdown-menu-header"></a>
                                </li>
                            </ul>
                        </div>
                    </li>

                </ul>

            @else
                <ul class="nav navbar-nav navbar-right">
                    <li><a class="btn-dangtin" href="user/dangtin"><i class="fas fa-edit"></i> Đăng tin ngay</a></li>
                    <li><a href="user/login"><i class="fas fa-user-circle"></i> Đăng Nhập</a></li>
                    <li><a href="user/register"><i class="fas fa-sign-in-alt"></i> Đăng Kí</a></li>
                </ul>
            @endif
        </div>
    </div>
</nav>

@yield('content')
<div class="gap"></div>
<div class="footer-dark">
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-6 item text">
{{--                    <div class="row">--}}
{{--                        <div class="col-md-6">--}}
                            <img style="width: 140px;" src="https://thumbs.dreamstime.com/b/motel-icon-white-background-simple-element-illustration-city-elements-concept-sign-symbol-design-141333219.jpg" />
{{--                            <span>Sinh viên thực hiện:Lê Quốc Huy-Vũ Thị Hường</span>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-6">--}}
{{--                      --}}
{{--                        </div>--}}
{{--                    </div>--}}

                </div>
                <div class="col-sm-6 col-md-3 item">
                    <h3>Services</h3>
                    <ul>
                        <li><a href="#">Web design</a></li>
                        <li><a href="#">Development</a></li>
                        <li><a href="#">Hosting</a></li>
                    </ul>
                </div>
                <div class="col-sm-6 col-md-3 item">
                    <h3>About</h3>
                    <ul>
                        <li><a href="#">Company</a></li>
                        <li><a href="#">Team</a></li>
                        <li><a href="#">Careers</a></li>
                    </ul>
                </div>

                <div class="col item social"><a href="#"><i class="icon ion-social-facebook"></i></a><a href="#"><i
                                class="icon ion-social-twitter"></i></a><a href="#"><i
                                class="icon ion-social-snapchat"></i></a><a href="#"><i
                                class="icon ion-social-instagram"></i></a></div>
            </div>

        </div>
        <p class="copyright">
            <span>Sinh viên thực hiện:Lê Quốc Huy-Vũ Thị Hường</span>
        </p>
    </footer>
</div>
{{--<footer>--}}
{{--    <div class="container">--}}
{{--        <div class="row">--}}
{{--            <div class="col-md-12">--}}
{{--                <div class="logo-footer">--}}
{{--                    <a href="/" title="Cổng thông tin số 1 về Dự án Bất động sản - Homedy.com">--}}
{{--                        <img src="images/logo.png">--}}
{{--                    </a>--}}
{{--                    <div style="padding-top: 10px;">--}}
{{--                        <p>Sinh viên thực hiện:Lê Quốc Huy - Vũ Thị Hường - Lớp:HTTT15</p>--}}
{{--                        --}}{{-- <p>Sinh viên thực hiện: Lê Thành Trung - Lớp 15SI-CLC.</p> --}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--</footer>--}}
<script>
    window.laravel_echo_port='{{env("LARAVEL_ECHO_PORT")}}';
</script>
<script src="//{{ Request::getHost() }}:{{env('LARAVEL_ECHO_PORT')}}/socket.io/socket.io.js"></script>
<script src="{{ url('/js/laravel-echo-setup.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="assets/toast/toastr.min.js"></script>
<script>
    $(document).ready(function () {

        $('.counter-block').hide()

        // $(document).click(function (e) {
        //     // let notification=document.getElementById('dropDownList')
        //     // let show=$('#dropDownList').is(':visible')
        //     // // console.log(show)
        //     // if (show) {
        //     //     $('#dropDownList').hide()
        //     // }
        //     // else
        //     // {
        //     //     $('#dropDownList').show()
        //     // }
        //     // notification.stopPropagation()
        //     // e.stopPropagation()
        // })

        // $('#dropDownList').mouseout((e)=>{
        //     e.stopPropagation()
        // })

        let i = 0;
        let user_id ={{\Illuminate\Support\Facades\Auth::id()}};
        $('#notification').click(function () {
            // console.log('Hello')
            i = 0
            $('.counter-block').hide()
            $('.counter').text('')
        })


        window.Echo.channel('send-notification')
            .listen('.SendNotification', (data) => {


                if(user_id==data.actionData.source_to && user_id!=data.actionData.sender_id){
                      // console.log('Hello')

                    let html='<li> '+
                       +' <p class="noti-image">' +
                       + '<span class="timeline-icon"><i class="fa fa-file-pdf-o" style="color:red"></i></span>' +
                    +'<span class="timeline-date">'+timeDifference(data.actionData.created_at)+'</span></p></li>'


                    i++;
                    $('.counter').text(i)
                    $('.counter').show()
                    $('#list-noti').prepend(html)

                }
                // data.data
                // console.log(data)
                // alert(data)
                // console.log(data.actionId)
                // console.log(data.actionData)
                $("#notification").append('<div class="alert alert-success">'+i+'.'+data.title+'</div>');
            });

        function timeDifference(created_date) {
            var d = new Date();  // Gets the current time
            var ts = new Date(created_date).getTime() / 1000;
            var nowTs = Math.floor(d.getTime() / 1000); // getTime() returns milliseconds, and we need seconds, hence the Math.floor and division by 1000
            var seconds = nowTs - ts;

            // more that two days
            if (seconds > 2 * 24 * 3600) {
                return "a few days ago";
            }
            // a day
            if (seconds > 24 * 3600) {
                return "1 day ago";
            }

            if (seconds > 3600) {
                let hour = seconds / 3600;
                return Math.round(hour) + " hours ago";
            }
            if (seconds < 3600 && seconds > 60) {
                let minute = seconds / 60;
                return Math.round(minute) + " minutes ago";
            }
            if (seconds < 60) {
                return Math.floor(seconds / 60) + " seconds ago";
            }
        }
    })
</script>
</body>
</html>
