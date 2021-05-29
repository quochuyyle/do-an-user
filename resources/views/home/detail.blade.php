@extends('layouts.master')
@section('content')
    <?php
    function limit_description($string)
    {
        $string = strip_tags($string);
        if (strlen($string) > 150) {

            // truncate string
            $stringCut = substr($string, 0, 150);
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
    <div class="gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li><a href="#">Trang Chủ</a></li>
                    <li><a href="#">{{ $motelroom->category->name }}</a></li>
                    <li class="active">{{ $motelroom->title }}</li>
                    <input type="hidden" id="owner_id" value="{{ $motelroom->user_id }}"/>
                    <input type="hidden" id="motelroom_id" value="{{ $motelroom->id }}"/>
                    <input type="hidden" id="user_wallet"
                           value="{{ \Illuminate\Support\Facades\Auth::check() ? \Illuminate\Support\Facades\Auth::user()->wallet : 0 }}"/>

                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h1 class="entry-title entry-prop">{{ $motelroom->title }}</h1>
                @if(\Illuminate\Support\Facades\Auth::check())
                    @if($motelroom->user_id == \Illuminate\Support\Facades\Auth::user()->id)
                <div class="row" style="margin: 15px 0 0 0;">
                    <div class="col-md-6" style="padding-left: 0">

                                <p>Thời hạn bài
                                    đăng: {{ $motelroom->term->start_date .' - '. $motelroom->term->end_date }}</p>

                    </div>
                    <div style="text-align: right;padding-right: 0px" class="col-md-6">
                        <?php
                        date_default_timezone_set('Asia/Ho_Chi_Minh');
                        $now = time();
                        $convertDate = date('d-m-Y', $now);
                        $start_date = new DateTime($convertDate);
                        $end_date = new DateTime($motelroom->end_date);
                        $diff = $start_date->diff($end_date);
                        ?>
                        @if($diff->days < 7)
                            <p>
                                <span class="text-danger"><b>Bài đăng sẽ hết hạn sau: {{ $diff->days }} ngày</b></span>
                            </p>
                        @endif
                    </div>
                </div>
                    @endif
                @endif


                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <span class="price_area">{{ number_format($motelroom->price) }} <span
                                    class="price_label">VND</span></span>
                    </div>
                    <div class="col-md-6">
					<span class="pull-right">Lượt xem: {{ $motelroom->count_view }} - <span>Ngày đăng: </span> <span
                                style="color: red; font-weight: bold;">
						<?php echo time_elapsed_string($motelroom->created_at); ?>
					</span></span>
                    </div>
                </div>

                @if(Auth::check())
                    <div id="map-detail"
                         style="{{ $motelroom->user_id == \Illuminate\Support\Facades\Auth::user()->id ? 'filter: blur(0)' :  \Illuminate\Support\Facades\Auth::user()->specificTradeHistory($motelroom->id) ? 'filter: blur(0)' : 'filter: blur(10px)' }} "></div>
                @else
                    <div id="map-detail" style="filter: blur(10px)"></div>

                @endif
                <hr>
                <div class="detail">
                    {{--                    <p><strong>Địa chỉ: {{ $motelroom->address }}</strong><br></p>--}}
                    <p>
                        <strong>Giá phòng: </strong><span
                                class="price_area"><?php echo number_format($motelroom->price); ?>  <span
                                    class="price_label">VND</span></span>
                        <strong><i class="fas fa-street-view"></i> Diện tích:
                        </strong><span> {{$motelroom->area}} m <sup>2</sup> </span>
                    </p>
                    <!-- Tiện ích -->
                    <?php $arrtienich = json_decode($motelroom->utilities, true); ?>
                    <div id="km-detail">
                        <div class="fs-dtslt">Tiện ích Phòng Trọ</div>
                        <div style="padding: 5px;">
                            @foreach($arrtienich as $tienich)
                                <span><i class="fas fa-check"></i> {{ $tienich }}</span>
                            @endforeach
                        </div>
                    </div>
                    <h4>Mô tả:</h4>
                    <pre>
					<p class="pre">{{ $motelroom->description }}</p>
				</pre>
                </div>

                <?php
                $arrimg = json_decode($motelroom->images, true);
                $i = 0
                ?>
                <center>
                    <!-- Slider Hình Ảnh -->
                    <ul class="pgwSlider">
                        @foreach($arrimg as $img)
                            <li>
                                <img src="{{ asset('uploads/images/'.$img) }}" width="50%" alt="">
                                @endforeach
                            </li>
                    </ul>

                </center>
                <!-- END Slider Hình Ảnh -->
                <div class="gap"></div>
            </div>
            <div class="col-md-4">
                <div class="contactpanel">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            @if($motelroom->user->avatar == 'no-avatar.jpg')
                                <img src="images/no-avatar.jpg" class="img-circle" alt="Cinque Terre" width="100"
                                     height="100">
                            @else
                                <img src="uploads/avatars/<?php echo $motelroom->user->avatar; ?>" class="img-circle"
                                     alt="Cinque Terre" width="100" height="100">
                            @endif
                        </div>
                        <div class="col-md-8">
                            <h4>Thông tin người đăng</h4>
                            <strong>{{ $motelroom->user->name }}</strong><br>
                            <i class="far fa-clock"></i> Ngày tham gia: 17-02-2018
                        </div>
                    </div>
                </div>
                        <div class="phone_btn">
                            <a type="button" id="btn_show_phone" href="tel:{{ $motelroom->phone }}" class="btn btn-primary btn-block"
                                    style="font-weight: bold !important;font-size: 14px;">
                                <i class="fa fa-mobile-phone"></i> Số điện thoại: {{ $motelroom->phone }}
                            </a>
                        </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            var slider = $('.pgwSlider').pgwSlider({
                maxHeight: 300
            });
            slider.previousSlide();

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            {{--$('#btn_show_phone').click(function (e) {--}}
            {{--    e.preventDefault()--}}
            {{--    let url = "{{ route('rent.phone.show',':id') }}",--}}
            {{--        id = {!! $motelroom->id !!},--}}
            {{--        price = {!! $motelroom->price !!},--}}
            {{--        fee = price * 10 / 100,--}}
            {{--        type = 1,--}}
            {{--        user_id = {{ Auth::check() ? \Illuminate\Support\Facades\Auth::user()->id : 0}},--}}
            {{--        owner_id = $('#owner_id').val(),--}}
            {{--        wallet = {{ Auth::check() ? \Illuminate\Support\Facades\Auth::user()->wallet : 0 }},--}}
            {{--        commission = (fee * 25) / 100,--}}
            {{--        receiving = (fee * 75) / 100,--}}
            {{--        updatedWallet = wallet - fee;--}}
            {{--    console.log(updatedWallet)--}}
            {{--    console.log(commission)--}}
            {{--    console.log(receiving)--}}
            {{--    --}}{{--$('#user_wallet').text({{ number_format() }})--}}
            {{--        url = url.replace(':id', id)--}}

            {{--    if (wallet >= fee) {--}}
            {{--        swal.fire({--}}
            {{--            title: 'Mất ' + fee + ' VND để xem thông tin chi tiết ?',--}}
            {{--            text: "Bạn không thể hoàn tác !",--}}
            {{--            icon: 'warning',--}}
            {{--            showCancelButton: true,--}}
            {{--            confirmButtonText: 'Có',--}}
            {{--            cancelButtonText: 'không',--}}
            {{--            reverseButtons: true--}}
            {{--        }).then((result) => {--}}
            {{--            if (result.value) {--}}
            {{--                $.ajax({--}}
            {{--                    type: 'POST',--}}
            {{--                    url: url,--}}
            {{--                    data: {--}}
            {{--                        type: type,--}}
            {{--                        fee: fee,--}}
            {{--                        motelroom_id: id,--}}
            {{--                        user_id: user_id,--}}
            {{--                        owner_id: owner_id,--}}
            {{--                        commission:commission,--}}
            {{--                        receiving:receiving--}}
            {{--                    },--}}
            {{--                    success: function (res) {--}}
            {{--                        if (res.message) {--}}
            {{--                            $('#user_wallet').html()--}}
            {{--                            $('#btn_show_phone').attr('style','display:none;')--}}
            {{--                            $('#map-detail').css('filter', 'blur(0)')--}}
            {{--                            swalWithBootstrapButtons.fire(--}}
            {{--                                'Thông báo',--}}
            {{--                                res.message,--}}
            {{--                                'success'--}}
            {{--                            )--}}
            {{--                        } else {--}}
            {{--                            swalWithBootstrapButtons.fire(--}}
            {{--                                'Thông báo',--}}
            {{--                                res.error,--}}
            {{--                                'error'--}}
            {{--                            )--}}
            {{--                        }--}}
            {{--                    }--}}

            {{--                })--}}
            {{--            }--}}
            {{--        });--}}
            {{--    }--}}
            {{--})--}}

            {{--$('#btn_rent_motel').click(function (e) {--}}
            {{--    e.preventDefault()--}}
            {{--    let url = "{{ route('rent.phone.show',':id') }}",--}}
            {{--        id = {!! $motelroom->id !!};--}}
            {{--    url = url.replace(':id', id)--}}
            {{--    swal.fire({--}}
            {{--        title: 'Bạn có chắc muốn thuê phòng trọ này ?',--}}
            {{--        text: "Bạn không thể hoàn tác !",--}}
            {{--        icon: 'warning',--}}
            {{--        showCancelButton: true,--}}
            {{--        confirmButtonText: 'Có',--}}
            {{--        cancelButtonText: 'không',--}}
            {{--        reverseButtons: true--}}
            {{--    }).then((result) => {--}}
            {{--        if (result.value) {--}}
            {{--            $('#map-detail').css('filter', 'blur(0)')--}}
            {{--            // $.ajax({--}}
            {{--            //     type: 'POST',--}}
            {{--            //     url: url,--}}
            {{--            //     data:{--}}
            {{--            //         fee:100000,--}}
            {{--            //         motelroom_id:id--}}
            {{--            //     },--}}
            {{--            //     success:function (res){--}}
            {{--            //         $('#user_wallet').html()--}}
            {{--            //         $('#btn_show_phone').text('Số điện thoại liên hệ: ' +res.phone)--}}
            {{--            //     }--}}
            {{--            //--}}
            {{--            // })--}}
            {{--        }--}}
            {{--    });--}}

            {{--})--}}
        });
    </script>
    <script>

        var map;

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

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDSgjO2ZLs29Zmv-GPwKucq0hkrIlrrF-U&callback=initMap"
            async defer></script>
@endsection