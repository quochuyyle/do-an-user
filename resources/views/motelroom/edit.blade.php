@extends('layouts.master')
@section('content')
    <div class="gap"></div>
    <div class="container">
        <div class="row">
            <?php
             $latLng = (array)json_decode($motelroom->latlng);
             $previewImages = [];
             $images = (array)json_decode($motelroom->images);
             foreach ($images as $image){
                $previewImages [] = ("<img src='".asset("/uploads/images/$image")."' class='file-preview-image' alt='Image' title='Image' />");
             }
//             $previewImages = json_encode($previewImages);


//             dd($previewImages);
//             dd($images);
//             dd($latLng[0]);
            ?>
            <div class="col-md-8">
                <h1 class="entry-title entry-prop">Chỉnh sửa thông tin Phòng trọ</h1>
                <hr>
                <div class="panel panel-default">
                    <div class="panel-heading">Thông tin bắt buộc*</div>
                    <div class="panel-body">
                        <div class="gap"></div>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if(session('warn'))
                            <div class="alert bg-danger">
                                <button type="button" class="close" data-dismiss="alert"><span>×</span><span
                                            class="sr-only">Close</span></button>
                                <span class="text-semibold">Error!</span> {{session('warn')}}
                            </div>
                        @endif
                        @if(session('success'))
                            <div class="alert bg-success">
                                <button type="button" class="close" data-dismiss="alert"><span>×</span><span
                                            class="sr-only">Close</span></button>
                                <span class="text-semibold">Done!</span> {{session('success')}}
                            </div>
                        @endif
                        @if(Auth::user()->tinhtrang != 0)
                            <form action="{{ route ('user.dangtin.sua', $motelroom->id) }}" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
{{--                                <input type="hidden" name="motelroom_id" value="{{ \Illuminate\Support\Facades\Auth::user()->id }}">--}}
                                <div class="form-group">
                                    <label for="usr">Tiêu đề bài đăng:</label>
                                    <input type="text" class="form-control" name="txttitle" value="{{ $motelroom->title }}">
                                </div>
                                <div class="form-group">
                                    <label>Địa chỉ phòng trọ:</label> Bạn có thể nhập hoặc chọn ví trí trên bản đồ
                                    <input type="text" id="location-text-box" name="txtaddress" class="form-control"
                                           value="{{ $motelroom->address }}"/>
                                    <p><i class="far fa-bell"></i> Nếu địa chỉ hiển thị bên bản đồ không đúng bạn có thể
                                        điều chỉnh bằng cách kéo điểm màu xanh trên bản đồ tới vị trí chính xác.</p>
                                    <input type="hidden" id="txtaddress" name="txtaddress" value=""
                                           class="form-control"/>
                                    <input type="hidden" id="txtlat" value="{{ $latLng[0] }}" name="txtlat" class="form-control" />
                                    <input type="hidden" id="txtlng" value="{{ $latLng[1] }}" name="txtlng" class="form-control"/>
                                </div>
                                <div id="map-canvas" style="width: auto; height: 400px;"></div>
                                <div class="row">
                                    <div class="col-md-9">
                                        <label for="term">Ngày bắt đầu và kết thúc:</label>
                                        <input  class="form-control" id="term" type="text" name="term"  value="{{ $motelroom->start_date .' - '.$motelroom->end_date }}"/>
                                        <input type="hidden" name="txtstart_date" id="txtstart_date"  value="{{ $motelroom->start_date }}"  />
                                        <input type="hidden" name="txtend_date" id="txtend_date"  value="{{ $motelroom->end_date }}"/>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="fee">Phí đăng tin</label>
                                        <input  class="form-control" id="fee" type="text" name="txtfee"  value="{{ old('txtfee') }}" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="usr">Giá phòng( vnđ ):</label>
                                            <input type="number" name="txtprice" class="form-control"
                                                   placeholder="750000" value="{{ $motelroom->price }}" >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="usr">Diện tích( m<sup>2</sup> ):</label>
                                            <input type="number" name="txtarea" class="form-control" placeholder="16" value="{{ $motelroom->area }}" >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="usr">Quận/ Huyện:</label>
                                            <select class="selectpicker pull-right" data-live-search="true"
                                                    name="iddistrict" id="selectdistrict">
                                                @foreach($districts as $district)
                                                    <option data-tokens="{{$district->slug}}"
                                                            value="{{ $district->id }}" {{ $motelroom->district_id == $district->id ? 'selected' : '' }} >{{ $district->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="usr">Danh mục:</label>
                                            <select class="selectpicker pull-right" data-live-search="true"
                                                    class="form-control" name="idcategory">
                                                @foreach($categories as $category)
                                                    <option data-tokens="{{$category->slug}}"
                                                            value="{{ $category->id }}" {{ $motelroom->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="usr">SĐT Liên hệ:</label>
                                            <input type="text" name="txtphone" class="form-control"
                                                   placeholder="0915111234" value="{{ $motelroom->phone }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <!-- ************** Max Items Demo ************** -->
                                    <label>Các tiện ích có trong phòng trọ:</label>
                                    <select id="select-state" name="tienich[]" multiple class="demo-default"
                                            placeholder="Chọn các tiện ích phòng trọ">
                                        <option value="Wifi miễn phí">Wifi miễn phí</option>
                                        <option value="Có gác lửng">Có gác lửng</option>
                                        <option value="Tủ + giường">Tủ + giường</option>
                                        <option value="Không chung chủ">Không chung chủ</option>
                                        <option value="Chung chủ">Chung chủ</option>
                                        <option value="Giờ giấc tự do">Giờ giấc tự do</option>
                                        <option value="Vệ sinh riêng">Vệ sinh riêng</option>
                                        <option value="Vệ sinh chung">Vệ sinh chung</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="comment">Mô tả ngắn:</label>
                                    <textarea class="form-control" rows="5" name="txtdescription"
                                              style=" resize: none;">{{ $motelroom->description  }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="comment">Thêm hình ảnh:</label>
                                    <div class="file-loading">
                                        <input id="file-5" type="file" class="file" name="hinhanh[]" multiple
                                               data-preview-file-type="any" data-upload-url="#">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="comment" class="mr-2">Trạng thái phòng trọ:</label>
                                    <label class="switch">
                                        <input type="checkbox" name="status" {{ $motelroom->status ? 'checked' : '' }}>
                                        <span class="slider"></span>
                                    </label>
                                </div>

                                <button class="btn btn-primary">Chỉnh sửa thông tin</button>
                            </form>
                        @else
                            <div class="alert bg-danger">
                                <button type="button" class="close" data-dismiss="alert"><span>×</span><span
                                            class="sr-only">Close</span></button>
                                <span class="text-semibold">Error!</span> Tài khoản của bạn đang bị khóa đăng tin.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="contactpanel">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <img src="assets/images/noavt.png" class="img-circle" alt="Cinque Terre" width="100"
                                 height="100">
                        </div>
                        <div class="col-md-8">
                            <h4>Thông tin người đăng</h4>
                            <strong> {{ Auth::user()->name }}</strong><br>
                            <i class="far fa-clock"></i> Ngày tham gia: {{ Auth::user()->created_at }}

                        </div>
                    </div>
                </div>

                <div class="gap"></div>
                {{--                <img src="images/banner-1.png" width="100%">--}}
            </div>
        </div>
    </div>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script type="text/javascript">
        {{--let previewImages = {{ json_encode($images) }};--}}
        // console.log(previewImages)
        {{--console.log({{$previewImages [0]}} );--}}
        console.log({!! $previewImages [0] !!};
        let previewImages = [];
            {{--previewImages.push({{ $previewImages [0] }});--}}

        $('#file-5').fileinput({
            theme: 'fa',
            language: 'vi',
            showUpload: false,
            allowedFileExtensions: ['jpg', 'png', 'gif'],
            // uploadUrl: "https://mcdn.wallpapersafari.com/medium/4/26/oNjunF.jpg",
            initialPreviewAsData: false,
            initialPreview: [''], //,
            initialPreviewConfig: [
                {
                    caption: 'desert.jpg',
                    width: '120px',
                    url: 'http://localhost/avatar/delete', // server delete action
                    key: 100,
                    extra: {id: 100}
                }]
{{--            {{$images [1]}},{{$images [2]}},{{$images [3]}},]--}}
        });



        $('input[name="term"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
        });

        $('input[name="term"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');

        });

    </script>

    <script type="text/javascript"
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDSgjO2ZLs29Zmv-GPwKucq0hkrIlrrF-U&callback=initialize&libraries=geometry,places"
            async defer></script>
    <script>
        var map;
        var marker;


        function initialize() {
            let latitude = 0,
                longitude = 0;



            var mapOptions = {
                center: {lat: 16.070372, lng: 108.214388},
                zoom: 12
            };
            map = new google.maps.Map(document.getElementById('map-canvas'),
                mapOptions);

            // Get GEOLOCATION
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    let lat = {{ $latLng[0] }},
                        lng = {{ $latLng[1] }}


                    var pos = new google.maps.LatLng(lat,
                        lng);
                    var geocoder = new google.maps.Geocoder();
                    geocoder.geocode({
                        'latLng': pos
                    }, function (results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            if (results[0]) {

                                // console.log(position.coords.latitude)
                                // console.log(position.coords.longitude)
                                // console.log(results[0])
                                // console.log(results[0].formatted_address);
                            } else {
                                console.log('No results found');
                            }
                        } else {
                            console.log('Geocoder failed due to: ' + status);
                        }
                    });
                    map.setCenter(pos);
                    marker = new google.maps.Marker({
                        position: pos,
                        map: map,
                        draggable: true
                    });
                }, function () {
                    handleNoGeolocation(true);
                });
            } else {
                // Browser doesn't support Geolocation
                handleNoGeolocation(false);
            }

            function handleNoGeolocation(errorFlag) {
                if (errorFlag) {
                    var content = 'Error: The Geolocation service failed.';
                } else {
                    var content = 'Error: Your browser doesn\'t support geolocation.';
                }

                var options = {
                    map: map,
                    zoom: 19,
                    position: new google.maps.LatLng(16.070372, 108.214388),
                    content: content
                };

                map.setCenter(options.position);
                marker = new google.maps.Marker({
                    position: options.position,
                    map: map,
                    zoom: 19,
                    icon: "images/gps.png",
                    draggable: true
                });
                /* Dragend Marker */
                google.maps.event.addListener(marker, 'dragend', function () {
                    var geocoder = new google.maps.Geocoder();
                    geocoder.geocode({'latLng': marker.getPosition()}, function (results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            if (results[0]) {
                                // console.log('Here')
                                $('#location-text-box').val(results[0].formatted_address);
                                $('#txtaddress').val(results[0].formatted_address);
                                $('#txtlat').val(marker.getPosition().lat());
                                $('#txtlng').val(marker.getPosition().lng());
                                infowindow.setContent(results[0].formatted_address);
                                infowindow.open(map, marker);
                            }
                        }
                    });
                });
                /* End Dragend */

            }

            // get places auto-complete when user type in location-text-box
            var input = /** @type {HTMLInputElement} */
                (
                    document.getElementById('location-text-box'));


            var autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.bindTo('bounds', map);

            var infowindow = new google.maps.InfoWindow();
            marker = new google.maps.Marker({
                map: map,
                icon: "images/gps.png",
                anchorPoint: new google.maps.Point(0, -29),
                draggable: true
            });

            google.maps.event.addListener(autocomplete, 'place_changed', function () {
                infowindow.close();
                marker.setVisible(false);
                var place = autocomplete.getPlace();
                if (!place.geometry) {
                    return;
                }
                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({'latLng': place.geometry.location}, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            let count=results[0].address_components.length
                            let districts=document.getElementById('selectdistrict')
                            let districtName=results[0].address_components[count-3].long_name;
                            for (let i=0;i<districts.length;i++){

                                if(districtName.match(districts[i].innerText)){
                                    console.log('Helloe here')
                                    console.log(districts[i].innerText)
                                }
                            }
                            // $('#selectdistrict').each(function (){
                            //     $(this).val()
                            // })
                            // console.log(results[count-3])
                            // console.log(results[0].address_components[count-3].long_name)
                            $('#txtaddress').val(results[0].formatted_address);
                            infowindow.setContent(results[0].formatted_address);
                            infowindow.open(map, marker);
                        }
                    }
                });
                // If the place has a geometry, then present it on a map.
                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(17); // Why 17? Because it looks good.
                }
                marker.setIcon( /** @type {google.maps.Icon} */ ({
                    url: "images/gps.png"
                }));
                document.getElementById('txtlat').value = place.geometry.location.lat();
                document.getElementById('txtlng').value = place.geometry.location.lng();
                // console.log(place.geometry.location.lat());
                marker.setPosition(place.geometry.location);
                marker.setVisible(true);

                var address = '';
                if (place.address_components) {
                    address = [
                        (place.address_components[0] && place.address_components[0].short_name || ''), (place.address_components[1] && place.address_components[1].short_name || ''), (place.address_components[2] && place.address_components[2].short_name || '')
                    ].join(' ');
                }
                /* Dragend Marker */
                google.maps.event.addListener(marker, 'dragend', function () {
                    var geocoder = new google.maps.Geocoder();
                    geocoder.geocode({'latLng': marker.getPosition()}, function (results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            if (results[0]) {

                                $('#location-text-box').val(results[0].formatted_address);
                                $('#txtlat').val(marker.getPosition().lat());
                                $('#txtlng').val(marker.getPosition().lng());
                                infowindow.setContent(results[0].formatted_address);
                                infowindow.open(map, marker);
                            }
                        }
                    });
                });
                /* End Dragend */
            });

        }


        // google.maps.event.addDomListener(window, 'load', initialize);
    </script>
    <script type="text/javascript" src="assets/js/selectize.js"></script>
    <script>
        $(function () {
            $('select').selectize(options);
        });
        $('#select-state').selectize({
            maxItems: null
        });
    </script>
@endsection