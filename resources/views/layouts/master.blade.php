<!DOCTYPE html>
<html lang="en">
<head>
    <title>Tìm phòng trọ</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <base href="{{asset('')}}">
    {{--	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap">--}}
{{--    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">--}}
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="assets/awesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="assets/toast/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.1.5/css/fileinput.min.css" integrity="sha512-A/XiYKl0I56Nxg43kogQlAnLUbGRVGcT3J2Ni9b73+blF89rmMJ6qL9iHhPR/vDOsjcylhEoiQfzHzGHS+K/lQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous">
{{--    <script src="assets/jquery.min.js"></script>--}}
{{--    <script src="assets/bootstrap/js/bootstrap.min.js"></script>--}}
    <script src="{{ asset('assets/myjs.js') }}"></script>
{{--    <link rel="stylesheet" href="assets/selectize.default.css" data-theme="default">--}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous">
{{--    <script src="assets/js/fileinput/fileinput.js" type="text/javascript"></script>--}}
{{--    <script src="assets/js/fileinput/vi.js" type="text/javascript"></script>--}}
{{--    <link rel="stylesheet" href="assets/fileinput.css">--}}
{{--    <script src="assets/pgwslider/pgwslider.min.js" type="text/javascript"></script>--}}
{{--    <link rel="stylesheet" href="assets/pgwslider/pgwslider.min.css">--}}
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- sortable.min.js is only needed if you wish to sort / rearrange files in initial preview.
        This must be loaded before fileinput.min.js -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/plugins/sortable.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/plugins/purify.min.js" type="text/javascript"></script> -->
{{--    <link rel="stylesheet" href="assets/bootstrap/bootstrap-select.min.css">--}}

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script src="assets/bootstrap/bootstrap-select.min.js"></script>
    <link rel="stylesheet" href="{{ asset('/css/new.css') }}">
    @stack('before-script')
    @yield('style-css')
</head>
<body>
@include('common.navbar')

@yield('content')
<div class="gap"></div>
@include('common.footer')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="//{{ Request::getHost() }}:{{env('LARAVEL_ECHO_PORT')}}/socket.io/socket.io.js"></script>
<script>
    window.laravel_echo_port = '{{env("LARAVEL_ECHO_PORT")}}';
</script>
<script src="{{ url('/js/laravel-echo-setup.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="assets/toast/toastr.min.js"></script>

<script>
    $(document).ready(function () {

        $('.counter-block').hide()


        let i = 0;
        let user_id ={{\Illuminate\Support\Facades\Auth::id() ? \Illuminate\Support\Facades\Auth::id() : 0}} ;
        $('#notification').click(function () {
            // console.log('Hello')
            i = 0
            $('.counter-block').hide()
            $('.counter').text('')
        })


        window.Echo.channel('send-notification')
            .listen('.SendNotification', (data) => {


                if (user_id == data.actionData.source_to && user_id != data.actionData.sender_id) {
                    let content = '\f328';
                    let html = '<li class="list-item"><p class="noti-image">' + data.actionData.content;
                    html += '<span class="timeline-icon"></span>';
                    html += '<span class="timeline-date">' + timeDifference(data.actionData.created_at) + '</span></p></li>';

                    i++;
                    $('.counter').text(i)
                    $('.counter-block').show()
                    $('#list-noti').prepend(html)

                }
                // data.data
                // console.log(data)
                // alert(data)
                // console.log(data.actionId)
                // console.log(data.actionData)
                // $("#notification").append('<div class="alert alert-success">'+i+'.'+data.title+'</div>');
            });

        function timeDifference(created_at) {

            const oneDay = 24 * 60 * 60 * 1000;
            let currentDate = new Date();
            let created_date = new Date(created_at);
            // let seconds = (currentDate.getTime()/1000-created_date.getTime()/1000)/(24*3600);
            const diffDays = Math.round(Math.abs((currentDate - created_date) / oneDay));
            const seconds = diffDays / oneDay;
            //  console.log(currentDate)
            // console.log(diffDays)
            // console.log(currentDate.getTime()/1000)
            // console.log(created_date.getTime()/1000)
            // more that two days
            // console.log(seconds)
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
                return Math.round(minute) + " minute(s) ago";
            }
            if (seconds < 60) {
                return "now";
            }
        }
    })
</script>
@stack('after-script')
</body>
</html>
