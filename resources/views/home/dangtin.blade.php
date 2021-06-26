@extends('layouts.master')
@section('style-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
@endsection
@section('content')
    <div class="gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h1 class="entry-title entry-prop">Đăng tin</h1>
                <hr>
                <div class="panel panel-default">
                    <div class="panel-heading">Thông tin bắt buộc<span class="text-danger">*</span></div>
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
                            <form action="{{ route ('user.dangtin') }}" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="user_id"
                                       value="{{ \Illuminate\Support\Facades\Auth::user()->id }}">
                                <div class="form-group">
                                    <label for="usr">Tiêu đề bài đăng<span class="text-danger">*</span>:</label>
                                    <input type="text" class="form-control" name="txttitle"
                                           value="{{ old('txttitle') }}">
                                </div>
                                <div class="form-group">
                                    <label>Địa chỉ phòng trọ,nhà bạn muốn cho thuê<span class="text-danger">*</span>:</label> <p>Bạn có thể nhập hoặc chọn ví
                                    trí trên bản đồ</p>
                                    <input type="text" id="location-text-box" name="txtaddress" class="form-control"
                                           value="{{ old('txtaddress') }}"/>
                                    <p><i class="far fa-bell"></i> Nếu địa chỉ hiển thị bên bản đồ không đúng bạn có thể
                                        điều chỉnh bằng cách kéo điểm màu xanh trên bản đồ tới vị trí chính xác.</p>
                                    <input type="hidden" id="txtaddress" name="txtaddress" value=""
                                           class="form-control"/>
                                    <input type="hidden" id="txtlat" value="" name="txtlat" class="form-control"/>
                                    <input type="hidden" id="txtlng" value="" name="txtlng" class="form-control"/>
                                </div>
                                <div id="map-canvas" style="width: auto; height: 400px;"></div>
                                <div class="row">
                                    <div class="col-md-9">
                                        <label for="postCategory">Loại bài đăng<span class="text-danger">*</span>:</label>
                                        <select class="form-control" name="postCategory" id="postCategory">
                                            @foreach($postCategories as $postCategory)
                                                <option data-value="{{ $postCategory->price }}"
                                                        value="{{ $postCategory->id }}">{{ $postCategory->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="pricePerDay">Gía ngày( vnđ )</label>
                                        <input class="form-control" id="pricePerDay" type="text" name="pricePerDay" readonly
                                               value="{{ old('txtpricePerDay') }}"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-9">
                                        <label for="term">Ngày bắt đầu và kết thúc<span class="text-danger">*</span>:</label>
                                        <input class="form-control" id="term" type="text" name="term"/>
                                        <input type="hidden" name="txtstart_date" id="txtstart_date"/>
                                        <input type="hidden" name="txtend_date" id="txtend_date"/>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="fee">Phí đăng tin<span class="text-danger">*</span></label>
                                        <input class="form-control" id="fee" type="text" name="txtfee"
                                               value="{{ old('txtfee') }}"/>
                                        <span class="validate-txtfee text-danger"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="usr">Giá phòng( vnđ )<span class="text-danger">*</span>:</label>
                                            <input type="number" name="txtprice" class="form-control"
                                                   placeholder="750000" value="{{ old('txtprice') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="usr">Diện tích( m<sup>2</sup> )<span class="text-danger">*</span>:</label>
                                            <input type="number" name="txtarea" class="form-control" placeholder="16"
                                                   value="{{ old('txtarea') }}">
                                            <span class="validate-area text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="usr">SĐT Liên hệ<span class="text-danger">*</span>:</label>
                                            <input type="text" name="txtphone" class="form-control"
                                                   placeholder="0915111234" value="{{ old('txtphone') }}">
                                            <span class="validate-phone text-danger"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="selectdistrict">Chọn Quận/ Huyện<span class="text-danger">*</span>:</label>
                                            <select class="select-option-custom pull-right form-control"
                                                    data-live-search="true"
                                                    name="iddistrict" id="selectdistrict">
                                                @foreach($district as $quan)
                                                    <option data-tokens="{{$quan->slug}}"
                                                            value="{{ $quan->id }}">{{ $quan->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="idcategory">Danh mục<span class="text-danger">*</span>:</label>
                                            <select class="select-option-custom pull-right form-control"
                                                    data-live-search="true"
                                                    id="idcategory" name="idcategory">
                                                @foreach($categories as $category)
                                                    <option data-tokens="{{$category->slug}}"
                                                            value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="post_menu">Danh mục bài đăng<span class="text-danger">*</span>:</label>
                                            <select class="select-option-custom pull-right form-control"
                                                    data-live-search="true"
                                                    name="postMenu" id="post_menu">
                                                @foreach($postMenus as $postMenu)
                                                    <option data-tokens="{{$postMenu->slug}}"
                                                            value="{{ $postMenu->id }}">{{ $postMenu->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <!-- ************** Max Items Demo ************** -->
                                    <label for="select-state">Các tiện ích có trong phòng trọ<span class="text-danger">*</span>:</label>
                                    <select id="select-state" name="tienich[]" multiple
                                            class="select-option-custom form-control"
                                            placeholder="Chọn các tiện ích phòng trọ">
                                        @foreach($ultilities as $ultitlity)
                                            <option value="{{ $ultitlity->id }}">{{ $ultitlity->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="comment">Mô tả ngắn:</label>
                                    <textarea class="form-control" rows="5" name="txtdescription"
                                              style=" resize: none;" value="{{ old('txtdescription') }}"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="comment">Thêm hình ảnh<span class="text-danger">*</span>:</label>
                                    <div class="file-loading">
                                        <input id="file-5" type="file" class="file" name="hinhanh[]" multiple
                                               data-preview-file-type="any" data-upload-url="#">
                                    </div>
                                </div>

                                <button id="btn-dang-tin" class="btn btn-primary">Đăng Tin</button>
                                <a href="/user/profile" class="btn btn-danger">Quay lại</a>
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
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.1.5/js/fileinput.min.js"
            integrity="sha512-1FvXwt9wkKd29ilILHy0zei6ScE5vdEKqZ6BSW+gmM7mfqC4T4256OmUfFzl1FkaNS3FUQ/Kdzrrs8SD83bCZA=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript">
        $('#file-5').fileinput({
            theme: 'fa',
            language: 'vi',
            showUpload: false,
            allowedFileExtensions: ['jpg', 'png', 'gif']
        });

        $('.select-option-custom').select2();

        $('input[name="term"]').daterangepicker({
            opens: 'left',
            locale: {
                format: 'DD-MM-YYYY'
            },
            autoUpdateInput: false,
            // maxDate:'3d',
            minDate: moment()
        }, function (start, end, label) {
            let diff = end.diff(start, 'days'),
                feePerDay = $('#postCategory').find(':selected').data('value');
            // console.log(feePerDay)
            $('#txtstart_date').val(start.format('DD-MM-YYYY'))
            $('#txtend_date').val(end.format('DD-MM-YYYY'))
            let fee = feePerDay * diff,
                wallet = "{{ \Illuminate\Support\Facades\Auth::user()->wallet }}";
            if (fee < wallet) {
                $('#fee').val(fee)
                $('.validate-txtfee').text('')
                $('#btn-dang-tin').attr('disabled', false)
            } else {
                $('#fee').val(fee)
                $('.validate-txtfee').text('Tài khoản bạn không đủ tiền vui lòng thử lại !')
                $('#btn-dang-tin').attr('disabled', true)
            }
        });

        $('input[name = txtarea]').keyup(function () {
            if ($(this).val() < 0) {
                $('.validate-area').text('Diện tích không hợp lệ, vui lòng nhập lại !')
                $('#btn-dang-tin').attr('disabled', true)
            } else {
                $('.validate-area').text('')
                $('#btn-dang-tin').attr('disabled', false)
            }
        })

        $('input[name = txtphone]').change(function () {
            let number = $(this).val().toString().length;
            if ( number > 10 || number < 10) {
                $('.validate-phone').text('Số điện thoại không hợp lệ , vui lòng nhập lại !')
                $('#btn-dang-tin').attr('disabled', true)
            } else {
                $('.validate-phone').text('')
                $('#btn-dang-tin').attr('disabled', false)
            }
        })

        $('#post_menu').change(function () {
            if ($(this).val() == 1) {
                $('#idcategory').attr('disabled', false)
            } else {
                $('#idcategory').attr('disabled', true)
            }
        });

        $('input[name="term"]').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
        });

        $('input[name="term"]').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');

        });

        let pricePerDay = $('#postCategory :selected').data('value')
        $('#pricePerDay').val(pricePerDay)
        $('#postCategory').change(function () {
            let pricePerDay = $(this).find(':selected').data('value')
            $('#pricePerDay').val(pricePerDay)
        })
    </script>

        <script type="text/javascript"
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAYJTsar1ApHjtBUiOwUNR3iBkBF4L14kg&callback=initialize&libraries=geometry,places"
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
                    var pos = new google.maps.LatLng(position.coords.latitude,
                        position.coords.longitude);
                    var geocoder = new google.maps.Geocoder();
                    geocoder.geocode({
                        'latLng': pos
                    }, function (results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            if (results[0]) {
                                // console.log(results[0])
                                console.log(results[0].formatted_address);
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
                            let count = results[0].address_components.length
                            let districts = document.getElementById('selectdistrict')
                            let districtName = results[0].address_components[count - 3].long_name;
                            for (let i = 0; i < districts.length; i++) {

                                if (districtName.match(districts[i].innerText)) {
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
                console.log(place.geometry.location.lat());
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
                                console.log('Here')
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

@endsection