{{--<nav class="navbar">--}}
{{--    <div class="container">--}}
{{--        <div class="navbar-wrapper">--}}
{{--            <div class="navbar-header">--}}
{{--                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">--}}
{{--                    <span class="icon-bar"></span>--}}
{{--                    <span class="icon-bar"></span>--}}
{{--                    <span class="icon-bar"></span>--}}
{{--                </button>--}}
{{--                <a class="navbar-brand" href=""><img--}}
{{--                            src="{{ asset('images/logo_icon.png') }}"--}}
{{--                            style="width: 40px;height: auto;"></a>--}}
{{--            </div>--}}
{{--            <div class="navbar-content" id="myNavbar">--}}
{{--                <ul class="navbar-nav" style="display: inline">--}}
{{--                    <li class="nav-item dropdown">--}}
{{--                        @if(\Illuminate\Support\Facades\Auth::check())--}}
{{--                            <a  class="dropdown-toggle list-item" data-toggle="dropdown" href="#">Loại phòng trọ</a>--}}
{{--                        @endif--}}
{{--                        <ul class="dropdown-menu">--}}
{{--                            @foreach($categories as $category)--}}
{{--                                <li><a class="list-item" href="category/{{$category->id}}">{{ $category->name }}</a></li>--}}
{{--                            @endforeach--}}
{{--                        </ul>--}}
{{--                    </li>--}}
{{--                    <li><a class="list-item" href="{{ route('postcategory.index') }}">Bảng giá</a></li>--}}
{{--                    <li><a class="list-item" href="{{ route('payment.index') }}">Phương thức thanh toán</a></li>--}}
{{--                </ul>--}}


{{--                @if(Auth::user())--}}
{{--                    <ul class="nav navbar-nav navbar-right" style="display: inline">--}}

{{--                        @if(Auth::user()->user_type == !2)--}}
{{--                            <li class="nav-item"><a class="list-item list-item">Tài khoản hiện có: <span--}}
{{--                                            id="user_wallet">{{ number_format(Auth::user()->wallet,2)  }}</span> VND</a>--}}
{{--                            </li>--}}
{{--                        @endif--}}
{{--                        @if(Auth::user()->user_type != 2)--}}
{{--                            <li class="nav-item"><a class="btn-dangtin list-item" href="user/dangtin"><i class="fas fa-edit"></i> Đăng tin ngay</a>--}}
{{--                            </li>--}}
{{--                        @endif--}}
{{--                        <li class="nav-item dropdown">--}}
{{--                            <a class="dropdown-toggle list-item" data-toggle="dropdown" href="#">Xin chào! {{Auth::user()->name}}--}}
{{--                                <span class="caret"></span></a>--}}
{{--                            <ul class="dropdown-menu">--}}
{{--                                <li><a class="list-item"  href="user/profile">Thông tin chi tiết</a></li>--}}

{{--                                @if(Auth::user()->user_type != 2)--}}
{{--                                    <li><a class="list-item" href="user/dangtin">Đăng tin</a></li>--}}
{{--                                @endif--}}
{{--                                <li><a class="list-item" href="user/logout">Thoát</a></li>--}}
{{--                            </ul>--}}
{{--                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                                Dropdown--}}
{{--                            </a>--}}
{{--                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">--}}
{{--                                <a class="dropdown-item" href="#">Action</a>--}}
{{--                                <a class="dropdown-item" href="#">Another action</a>--}}
{{--                                <div class="dropdown-divider"></div>--}}
{{--                                <a class="dropdown-item" href="#">Something else here</a>--}}
{{--                            </div>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <div class="dropdown" style="float: right; padding: 13px;position: relative">--}}
{{--                                <a href="#" class="list-item" onclick="return false;" role="button" data-toggle="collapse" id="dropdownMenu1"--}}
{{--                                   data-target="#dropDownList" style="float: left" aria-expanded="true">--}}
{{--                                    <i class="fa fa-bell" id="notification"--}}
{{--                                       style="font-size: 27px !important; float: left; color:#2C2E2F">--}}
{{--                                        <div class="counter-block">--}}
{{--                                            <span class="counter">0</span>--}}
{{--                                        </div>--}}
{{--                                    </i>--}}
{{--                                </a>--}}
{{--                                <ul class="dropdown-menu dropdown-menu-left pull-right" id="dropDownList" role="menu"--}}
{{--                                    aria-labelledby="dropdownMenu1">--}}
{{--                                    <li role="presentation">--}}
{{--                                        <a  href="#" class="dropdown-menu-header">Thông báo</a>--}}
{{--                                    </li>--}}
{{--                                    <ul class="timeline timeline-icons timeline-sm" id="list-noti"--}}
{{--                                        style="margin:10px;width:250px">--}}
{{--                                        @empty(!$notifications)--}}
{{--                                            @foreach($notifications as $notification)--}}
{{--                                                <li class="list-item">--}}
{{--                                                    <p class="noti-image">--}}
{{--                                                        {{$notification->content}}--}}
{{--                                                        <span class="timeline-icon"><i class="fa fa-file-pdf-o"--}}
{{--                                                                                       style="color:red"></i></span>--}}
{{--                                                        <span class="timeline-date">{{$notification->created_at->diffForHumans()}}</span>--}}
{{--                                                    </p>--}}
{{--                                                </li>--}}
{{--                                            @endforeach--}}
{{--                                        @else--}}
{{--                                            <li>--}}
{{--                                                <p class="noti-image">--}}
{{--                                                    Không có thông báo nào !--}}
{{--                                                </p>--}}
{{--                                            </li>--}}
{{--                                        @endempty--}}
{{--                                    </ul>--}}
{{--                                    <li role="presentation">--}}
{{--                                        <a href="#" class="dropdown-menu-header list-item"></a>--}}
{{--                                    </li>--}}
{{--                                </ul>--}}
{{--                            </div>--}}
{{--                        </li>--}}

{{--                    </ul>--}}

{{--                @else--}}
{{--                    <ul class="nav navbar-nav navbar-right" style="display: inline">--}}
{{--                        @if(\Illuminate\Support\Facades\Auth::check())--}}
{{--                            <li><a class="list-item" class="btn-dangtin" href="user/dangtin"><i class="fas fa-edit"></i> Đăng tin ngay</a></li>--}}
{{--                        @endif--}}
{{--                        <li><a class="list-item" href="user/login"><i class="fas fa-user-circle"></i> Đăng Nhập</a></li>--}}

{{--                        <li><a class="list-item" href="user/register"><i class="fas fa-sign-in-alt"></i> Đăng Kí</a></li>--}}
{{--                    </ul>--}}
{{--                @endif--}}
{{--            </div>--}}
{{--        </div>--}}

{{--    </div>--}}
{{--</nav>--}}
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="navbar-wrapper">
        <a class="navbar-brand" href=""><img
                    src="{{ asset('images/logo_icon.png') }}"
                    style="width: 40px;height: auto;"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link list-item {{ url()->current() == route('user.index') ? 'active' : '' }}"
                       href="{{ route('user.index') }}">Trang chủ <span class="sr-only">(current)</span></a>
                </li>
                @foreach($postmenus as $postMenu)
                    <li class="nav-item">
                        <a class="nav-link list-item {{ url()->current() == route('postmenu.motelroom', $postMenu->slug) ? 'active' : '' }}"
                           href="{{ route('postmenu.motelroom', $postMenu->slug) }}">{{ $postMenu->name }}</a>
                    </li>
                @endforeach
                <li class="nav-item">
                    <a class="nav-link list-item {{ url()->current() == route('postcategory.index') ? 'active' : '' }}"
                       href="{{ route('postcategory.index') }}">Bảng giá</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link list-item {{ url()->current() == route('payment.index') ? 'active' : '' }}"
                       href="{{ route('payment.index') }}">Phương thức thanh toán</a>
                </li>
                @if(\Illuminate\Support\Facades\Auth::check())
                    @if(\Illuminate\Support\Facades\Auth::user()->user_type != 3)
                        <li class="nav-item">
                            <a class="nav-link list-item {{ url()->current() == route('user.index.favourite', \Illuminate\Support\Facades\Auth::user()->id ) ? 'active' : '' }}"
                               href="{{ route('user.index.favourite', \Illuminate\Support\Facades\Auth::user()->id) }}">Nhà
                                trọ yêu thích của bạn <span
                                        class="sr-only">(current)</span></a>
                        </li>
                    @endif
                @endif
                {{--                @if(\Illuminate\Support\Facades\Auth::check())--}}
                {{--                    @if(\Illuminate\Support\Facades\Auth::user()->user_type != 2)--}}
                {{--                        <li class="nav-item"><a class="list-item list-item">Tài khoản hiện có: <span--}}
                {{--                                        id="user_wallet">{{ number_format(Auth::user()->wallet,2)  }}</span> VND</a>--}}
                {{--                        </li>--}}
                {{--                    @endif--}}
                {{--                    <li class="nav-item dropdown">--}}
                {{--                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"--}}
                {{--                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
                {{--                            Dropdown--}}
                {{--                        </a>--}}
                {{--                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">--}}
                {{--                            <a class="dropdown-item" href="#">Action</a>--}}
                {{--                            <a class="dropdown-item" href="#">Another action</a>--}}
                {{--                            <div class="dropdown-divider"></div>--}}
                {{--                            <a class="dropdown-item" href="#">Something else here</a>--}}
                {{--                        </div>--}}
                {{--                    </li>--}}
                {{--                @else--}}
                {{--                @endif--}}
            </ul>
            @if(Auth::user())
                <ul class="nav navbar-nav navbar-right">

                    @if(Auth::user()->user_type != 2)
                        <li class="nav-item"><a class="list-item list-item user_wallet-wrapper">Tài khoản: <span
                                        id="user_wallet">{{ number_format(Auth::user()->wallet,2)  }}</span> VND</a>
                        </li>
                    @endif
                    @if(Auth::user()->user_type != 2)
                        <li class="nav-item"><a class="btn btn-dangtin list-item" href="user/dangtin"><i
                                        class="fas fa-edit"></i> Đăng tin ngay</a>
                        </li>
                    @endif
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle list-item" href="#" id="navbarDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Xin chào! {{Auth::user()->name}}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item list-item" href="user/profile">Thông tin chi tiết</a>
                            @if(Auth::user()->user_type != 2)
                                <a class="dropdown-item list-item" href="user/dangtin">Đăng tin</a>
                            @endif
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item list-item" href="user/logout">Thoát</a>
                        </div>
                    </li>
                    <li>
                        <div class="dropdown" style="float: right; padding: 13px;position: relative">
                            <a href="#" class="list-item" onclick="return false;" role="button" data-toggle="collapse"
                               id="dropdownMenu1"
                               data-target="#dropDownList" style="float: left" aria-expanded="true">
                                <i class="fa fa-bell" id="notification"
                                   style="font-size: 27px !important; float: left; color:#2C2E2F">
                                    <div class="counter-block">
                                        <span class="counter">0</span>
                                    </div>
                                </i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-left pull-right" id="dropDownList" role="menu"
                                aria-labelledby="dropdownMenu1">
                                <li role="presentation">
                                    <div href="#" class="dropdown-menu-header">Thông báo</div>
                                </li>
                                <ul class="timeline timeline-icons timeline-sm" id="list-noti"
                                    style="margin:10px;width:267px;overflow-y: scroll;height: 400px;">
                                    @empty(!$notifications)
                                        @foreach($notifications as $notification)
                                            <li class="list-item">
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
                                </ul>
                            </ul>
                        </div>
                    </li>

                </ul>

            @else
                <ul class="nav navbar-nav navbar-right">
                    @if(\Illuminate\Support\Facades\Auth::check())
                        <li><a class="list-item" class="btn-dangtin" href="user/dangtin"><i class="fas fa-edit"></i>
                                Đăng tin ngay</a></li>
                    @endif
                    <li class="mr-2"><a class="list-item" href="user/login"><i class="fas fa-user-circle"></i> Đăng Nhập</a></li>

                    <li><a class="list-item" href="user/register"><i class="fas fa-sign-in-alt"></i> Đăng Kí</a></li>
                </ul>
            @endif
        </div>
    </div>

</nav>