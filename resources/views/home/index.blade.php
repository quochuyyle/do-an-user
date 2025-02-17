@extends('layouts.master')
@section('content')
    <?php
    function limit_description($string)
    {
        $string = strip_tags($string);
        if (strlen($string) > 100) {

            // truncate string
            $stringCut = substr($string, 0, 100);
            $endPoint = strrpos($stringCut, ' ');

            //if the string doesn't contain any space then it will cut without word basis.
            $string = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
            $string .= '...';
        }
        return $string;
    }
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
    <div class="container-fluid">
        <div class="search-map hidden-xs">
            <div id="map"></div>
            <div class="box-search">
                <!-- <div id="flat"></div>
                    <div id="lng"></div> -->
                <form onsubmit="return false">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <div class="box-search-wrapper  mb-2">
                            <div class="box-search-select">
                                <select class="select-option-custom form-control h-100" data-live-search="true" id="selectprovince">
                                    <option data-tokens="" value="">Chọn tỉnh/thành phố</option>
                                    @foreach($provinces as $province)
                                        <option data-tokens="{{$province->slug}}"
                                                value="{{ $province->id }}">{{ $province->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="box-search-select">
                                <select class="select-option-custom form-control" data-live-search="true" id="selectdistrict">
                                    <option value="">Chọn quận/huyện</option>
                                    @foreach($district as $quan)
                                        <option data-tokens="{{$quan->slug}}"
                                                value="{{ $quan->id }}">{{ $quan->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="box-search-select">
                                <select class="select-option-custom form-control" data-live-search="true" id="selectcategory">
                                    <option value="">Chọn loại phòng trọ</option>
                                    @foreach($categories as $category)
                                        <option data-tokens="{{ $category->slug }}"
                                                value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="box-search-select">
                                <select class="select-option-custom form-control" id="selectprice" data-live-search="true">
                                    <option data-tokens="khoang gia" min="1" max="10000000">Khoảng giá</option>
                                    <option data-tokens="Tu 500.000 VNĐ - 700.000 VNĐ" min="500000" max="700000">Từ
                                        500.000
                                        VNĐ - 700.000 VNĐ
                                    </option>
                                    <option data-tokens="Tu 700.000 VNĐ - 1.000.000 VNĐ" min="700000" max="1000000">Từ
                                        700.000 VNĐ - 1.000.000 VNĐ
                                    </option>
                                    <option data-tokens="Tu 1.000.000 VNĐ - 1.500.000 VNĐ" min="1000000" max="1500000">
                                        Từ
                                        1.000.000 VNĐ - 1.500.000 VNĐ
                                    </option>
                                    <option data-tokens="Tu 1.500.000 VNĐ - 3.000.000 VNĐ" min="1500000" max="3000000">
                                        Từ
                                        1.500.000 VNĐ - 3.000.000 VNĐ
                                    </option>
                                    <option data-tokens="Tren 3.000.000 VNĐ" min="3000000" max="10000000">Trên 3.000.000
                                        VNĐ
                                    </option>
                                </select>
                            </div>
                            <div class="box-search-select">
                                <button class="btn btn-success" onclick="searchMotelajax()">Tìm kiếm ngay</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>


        </div>
        <div class="container">
            <div class="row room-hot">
                @foreach($hot_motelroom as $room)
                    <?php
                    $img_thumb = json_decode($room->images, true);
                    ?>
                @endforeach
            </div>
            <div class="home-wrapper">
                <div class="row">
                    <div class="col-sm-12 col-lg-9">
                        <div class="content-wrapper" id="show_motelroom">
                            <div class="title-wrapper">
                                <h3 class="title">Danh sách đăng tin</h3>
                            </div>
                            @if(count($motelrooms) > 0)
                                <div class="list-motelroom">
                            @include('motelroom.paginationData')
                                </div>
                            @else
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="list-filter-wrapper">
                            <div class="title-wrapper">
                                <h4 class="title">Danh mục cho thuê</h4>
                            </div>
                            <ul class="list-options">
                                @foreach($postmenus as $postmenu)
                                    <li><a href="{{ route('postmenu.motelroom', $postmenu->slug) }}"
                                           class="option {{ request()->slug == $postmenu->slug ? 'text-danger' : '' }}">{{ $postmenu->name }} </a></li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="list-filter-wrapper">
                            <div class="title-wrapper">
                                <h4 class="title">Xem theo giá</h4>
                            </div>
                            <ul class="list-options">
                                <li><a href="{{ route('price.motelroom',['min'=>'0','max'=>'1000000']) }}"
                                       class="option">Dưới 1 triệu</a></li>
                                <li><a href="{{ route('price.motelroom',['min'=>'2000000','max'=>'3000000']) }}"
                                       class="option">Từ 2 - 3 triệu</a></li>
                                <li><a href="{{ route('price.motelroom',['min'=>'4000000','max'=>'5000000']) }}"
                                       class="option">Từ 4 - 5 triệu</a></li>
                                <li><a href="{{ route('price.motelroom',['min'=>'5000000','max'=>'']) }}"
                                       class="option">Từ 5 triệu trở lên</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        @endsection
        @push('after-script')
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
            <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.1.5/js/fileinput.min.js"
                    integrity="sha512-1FvXwt9wkKd29ilILHy0zei6ScE5vdEKqZ6BSW+gmM7mfqC4T4256OmUfFzl1FkaNS3FUQ/Kdzrrs8SD83bCZA=="
                    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"
                    integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
                    crossorigin="anonymous"></script>
            <script type="text/javascript">
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $(function () {
                    $('body').on('click', '.pagination a', function (e) {
                        e.preventDefault();
                        $('#load').append('<img style="position: absolute; left: 0; top: 0; z-index: 10000;" src="https://i.imgur.com/v3KWF05.gif />');
                        var url = $(this).attr('href');
                        window.history.pushState("", "", url);
                        loadData(url);
                    });

                    function loadData(url) {
                        $.ajax({
                            url: url
                        }).done(function (data) {
                            $('.list-motelroom').html(data);
                        }).fail(function () {
                            console.log("Failed to load data!");
                        });
                    }
                });
            </script>
            <script>
                $('.select-option-custom').select2();
                var map;

                function initMap() {
                    map = new google.maps.Map(document.getElementById('map'), {
                        center: {lat: 21.028511, lng: 105.804817},
                        zoom: 15,
                        draggable: true
                    });
                    /* Get latlng list phòng trọ */
                    <?php
                    $arrmergeLatln = array();
                    foreach ($map_motelroom as $room) {
                        $arrlatlng = json_decode($room->latlng, true);
                        $arrImg = json_decode($room->images, true);
                        $arrmergeLatln[] = ["slug" => $room->slug, "lat" => $arrlatlng[0], "lng" => $arrlatlng[1], "title" => $room->title, "address" => $room->address, "image" => $arrImg[0], "phone" => $room->phone];

                    }

                    $js_array = json_encode($arrmergeLatln);
                    echo "var javascript_array = " . $js_array . ";\n";

                    ?>
                    /* ---------------  */
                    // console.log(javascript_array);

                    var listphongtro = [
                        {
                            lat: 16.067011,
                            lng: 108.214388,
                            title: '33 Hoàng diệu',
                            content: 'bbbb'
                        },
                        {
                            lat: 16.066330603904397,
                            lng: 108.2066632380371,
                            title: '33 Hoàng diệu',
                            content: 'bbbb'
                        }
                    ];
                    // console.log(javascript_array);

                    for (i in javascript_array) {
                        var data = javascript_array[i];
                        // console.log(data.lng)
                        var latlng = new google.maps.LatLng(data.lat, data.lng);
                        // console.log(latlng)
                        var phongtro = new google.maps.Marker({
                            position: latlng,
                            map: map,
                            title: data.title,
                            icon: "images/gps.png",
                            content: 'dgfdgfdg'
                        });
                        var infowindow = new google.maps.InfoWindow();
                        (function (phongtro, data) {
                            console.log(phongtro)
                            console.log(data)
                            var content = '<div id="iw-container" style="width: 350px;">' +
                                '<img  style="height: 200px;width: 100%" src="uploads/images/' + data.image + '">' +
                                '<a href="phongtro/' + data.slug + '"><div class="iw-title">' + data.title + '</div></a>' +
                                '<p><i class="fas fa-map-marker" style="color:#003352"></i> ' + data.address + '<br>' +
                                '<br>Phone. ' + data.phone + '</div>';

                            google.maps.event.addListener(phongtro, "click", function (e) {

                                infowindow.setContent(content);
                                infowindow.open(map, phongtro);
                                // alert(data.title);
                            });
                        })(phongtro, data);

                    }
                }

            </script>
            <script>
                $(document).ready(function () {
                    $("#selectprovince").change(function (e) {
                        e.preventDefault();

                        let province_id = $('#selectprovince').val(),
                            url = '{{route('district.list',':id')}}';
                        url = url.replace(':id', province_id)

                        $.ajax({
                            type: "GET",
                            url: url,
                            data: {province_id: province_id},
                            success: function (result) {
                                $('#selectdistrict').find('option:not(:first)').remove();
                                for (item in result)
                                    $("#selectdistrict").append('<option data-tokens="' + result[item].slug + '" value=' + result[item].id + '>' + result[item].name + '</option>');
                            },
                            error: function (result) {
                            }
                        });
                    })

                })
            </script>
            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAYJTsar1ApHjtBUiOwUNR3iBkBF4L14kg&callback=initMap"
                    async defer></script>
    @endpush