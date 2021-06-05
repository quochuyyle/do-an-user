@extends('layouts.master')
@section('content')
    <div class="detail-wrapper">
        <div class="container">

            <div class="row">
                <div class="col-lg-9">
                    <div class="content-wrapper">
                        <div class="header-wrapper">
                            <div class="star-ratings-wrapper" style="position: initial">
                                @if($motelroom->post_type == 1)
                                    <div class="star-ratings">
                                        <div class="fill-ratings" style="width: 100%;">
                                            <span>★★★★★</span>
                                        </div>
                                        <div class="empty-ratings">
                                            <span>★★★★★</span>
                                        </div>
                                    </div>
                                @elseif($motelroom->post_type == 2)
                                    <div class="star-ratings">
                                        <div class="fill-ratings" style="width: 80%;">
                                            <span>★★★★★</span>
                                        </div>
                                        <div class="empty-ratings">
                                            <span>★★★★★</span>
                                        </div>
                                    </div>
                                @elseif($motelroom->post_type == 3)
                                    <div class="star-ratings">
                                        <div class="fill-ratings" style="width: 60%;">
                                            <span>★★★★★</span>
                                        </div>
                                        <div class="empty-ratings">
                                            <span>★★★★★</span>
                                        </div>
                                    </div>
                                @elseif($motelroom->post_type == 4)
                                    <div class="star-ratings">
                                        <div class="fill-ratings" style="width: 40%;">
                                            <span>★★★★★</span>
                                        </div>
                                        <div class="empty-ratings">
                                            <span>★★★★★</span>
                                        </div>
                                    </div>
                                @elseif($motelroom->post_type == 5)
                                    <div class="star-ratings">
                                        <div class="fill-ratings" style="width: 20%;">
                                            <span>★★★★★</span>
                                        </div>
                                        <div class="empty-ratings">
                                            <span>★★★★★</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="title-wrapper">
                                <h3 class="title">{{ $motelroom->title }}</h3>
                            </div>
                        </div>
                        <p class="post-menu">Chuyên mục: <a href="#">{{ $motelroom->postMenu->name }}</a></p>
                        <div class="location-wrapper">
                            <div class="image-wrapper">
                                <img class="image-icon" src="{{ asset('/images/location_icon.png')  }}" alt="">
                            </div>
                            <div class="address-wrapper">
                                <h5 class="address">Địa chỉ: {{ $motelroom->address }}</h5>
                            </div>
                        </div>
                        <div class="information-wrapper">
                            <div class="price-wrapper">
                                <h3 class="price">{{ number_format($motelroom->price, '2', ',', '.') }}/tháng</h3>
                            </div>
                            <div class="area-wrapper">
                                <h3 class="area">Diện tích: {{ $motelroom->area }}m2</h3>
                            </div>
                            <div class="created_at-wrapper">
                                <h3 class="created_at">Thời gian: {{ $motelroom->created_at }}</h3>
                            </div>
                        </div>
                        <div class="description-wrapper">
                            <h3 class="header">Thông tin mô tả</h3>
                            <h5 class="text-bold">Tiện ích:</h5>
                            <div class="ultility-wrapper">
                                <ul class="ultility-list">
                                    @foreach($ultitlities as $row)
                                    <li class="ultility">
                                       -{{ $row->name }}
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            <h5 class="text-bold">Mô tả:</h5>
                            <p class="description">
                                {{ $motelroom->description }}
                            </p>
                        </div>
                        <div class="image-wrapper">
                            <h3 class="header">Hình ảnh</h3>
                            <div id="carouselExampleControls" style="height: 300px;" class="carousel slide"
                                 data-mdb-ride="carousel">
                                @php
                                    $images = json_decode($motelroom->images);
                                    $number = 0;
                                @endphp
                                <ol class="carousel-indicators">
                                    @foreach($images as $image)
                                        <li data-target="#carouselExampleControls" data-slide-to="{{ $number }}"
                                            class="{{ $number == 0 ? 'active' : '' }}"></li>
                                        @php
                                            $number++;
                                        @endphp
                                    @endforeach
                                </ol>


                                <div class="carousel-inner" style="height: 300px;">
                                    @php
                                        $images = json_decode($motelroom->images);
                                        $i = 0;
                                    @endphp
                                    @foreach($images as $image)
                                        <div class="carousel-item {{ $i == 0 ? 'active' : '' }}">
                                            <img src="{{ asset('/uploads/images/'.$image) }}"
                                                 class="d-block w-100"
                                                 alt="..."
                                            />
                                        </div>
                                        @php
                                            $i++;
                                        @endphp
                                    @endforeach
                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleControls" role="button"
                                   data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleControls" role="button"
                                   data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                        <div class="map-wrapper">
                            <h3 class="header">Bản đồ</h3>
                            <h4 class="address">Địa chỉ: {{ $motelroom->address }}</h4>
                            <div id="map-detail"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="onwner_info-wrapper">
                        <div class="avatar-wrapper">
                            <div class="avatar-container">
                                <img class="avatar" src="{{ asset('/uploads/avatars/'.$motelroom->user->avatar) }}"
                                     alt="">
                            </div>
                        </div>
                        <div class="name-wrapper">
                            <h3 class="name">{{ $motelroom->user->name }}</h3>
                        </div>
                        <div class="phone-wrapper">
                            <a href="tel:{{ $motelroom->phone }}" class="btn btn-phone"><img class="image-icon"
                                                                                             src="{{ asset('/images/phone_icon.png') }}"
                                                                                             alt="">{{ $motelroom->phone }}
                            </a>
                        </div>
                        <div class="message-wrapper">
                            <button class="btn btn-message"><img class="image-icon"
                                                                 src="{{ asset('/images/zalo_icon.png') }}" alt="">Nhắn
                                zalo
                            </button>
                        </div>
                        <div class="favourite-wrapper">
                            <button class="btn btn-favourite">
                                <div class="heart-wrapper">
                                    <input type="checkbox" data-id="{{ $motelroom->id }}"
                                           {{ \Illuminate\Support\Facades\Auth::user()->favourite->where('motelroom_id', $motelroom->id)->first() ? 'checked' : '' }} class="toggle">
                                    <div id="twitter-heart"></div>
                                    </input>
                                </div>
                            </button>
                        </div>
                    </div>
                    <div class="list-filter-wrapper">
                        <div class="title-wrapper">
                            <h4 class="title">Danh mục cho thuê</h4>
                        </div>
                        <ul class="list-options">
                            @foreach($postmenus as $postmenu)
                                <li><a href="{{ route('postmenu.motelroom', $postmenu->slug) }}"
                                       class="option">{{ $postmenu->name }} </a></li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="list-filter-wrapper">
                        <div class="title-wrapper">
                            <h4 class="title">Xem theo giá</h4>
                        </div>
                        <ul class="list-options">
                            <li><a href="{{ route('price.motelroom',['min'=>'0','max'=>'1000000']) }}" class="option">Dưới
                                    1 triệu</a></li>
                            <li><a href="{{ route('price.motelroom',['min'=>'2000000','max'=>'3000000']) }}"
                                   class="option">Từ 2 - 3 triệu</a></li>
                            <li><a href="{{ route('price.motelroom',['min'=>'4000000','max'=>'5000000']) }}"
                                   class="option">Từ 4 - 5 triệu</a></li>
                            <li><a href="{{ route('price.motelroom',['min'=>'5000000','max'=>'']) }}" class="option">Từ
                                    5 triệu trở lên</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@push('after-script')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD541vsuvBAzV7RqE2U6iZEZn-9u5JJpgw&callback=initMap"
            async defer></script>
    <script>
        $(document).ready(function () {
            $('.carousel').carousel()

            var map;
            initMap()

            function initMap() {
                map = new google.maps.Map(document.getElementById('map-detail'), {
                    center: {lat: 16.067011, lng: 108.214388},
                    zoom: 15,
                    draggable: true
                });
                /* Get latlng vị trí phòng trọ */
                <?php
                $arrmergeLatln = array();

                $arrlatlng = json_decode($motelroom->latlng, true);

                $arrmergeLatln[] = ["lat" => $arrlatlng[0], "lng" => $arrlatlng[1], "title" => $motelroom->title, "address" => $motelroom->address, "phone" => $motelroom->phone, "slug" => $motelroom->slug];
                $js_array = json_encode($arrmergeLatln);
                echo "var javascript_array = " . $js_array . ";\n";

                ?>
                /* ---------------  */

                for (i in javascript_array) {
                    var data = javascript_array[i];
                    var latlng = new google.maps.LatLng(data.lat, data.lng);
                    var phongtro = new google.maps.Marker({
                        position: latlng,
                        map: map,
                        title: data.title,
                        icon: "images/gps.png",
                        content: 'dgfdgfdg'
                    });
                    var infowindow = new google.maps.InfoWindow();
                    (function (phongtro, data) {
                        var content = '<div id="iw-container">' +
                            '<a href="phongtro/' + data.slug + '"><div class="iw-title">' + data.title + '</div></a>' +
                            '<p><i class="fas fa-map-marker" style="color:#003352"></i> ' + data.address + '<br>' +
                            '<br>Phone. ' + data.phone + '</div>';
                        infowindow.setContent(content);
                        infowindow.open(map, phongtro);
                        google.maps.event.addListener(phongtro, "click", function (e) {

                            infowindow.setContent(content);
                            infowindow.open(map, phongtro);
                            // alert(data.title);
                        });
                    })(phongtro, data);

                }
                google.maps.event.addListener(map, 'mousemove', function (e) {
                    document.getElementById("flat").innerHTML = e.latLng.lat().toFixed(6);
                    document.getElementById("lng").innerHTML = e.latLng.lng().toFixed(6);

                });


            }
        })
    </script>
@endpush