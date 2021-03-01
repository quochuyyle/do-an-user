{{--@extends('layouts.master')--}}

{{--@push('before-script')--}}
{{--  <script>--}}
{{--    // This example adds a search box to a map, using the Google Place Autocomplete--}}
{{--    // feature. People can enter geographical searches. The search box will return a--}}
{{--    // pick list containing a mix of places and predicted search terms.--}}
{{--    // This example requires the Places library. Include the libraries=places--}}
{{--    // parameter when you first load the API. For example:--}}
{{--    // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">--}}
{{--    function initAutocomplete() {--}}
{{--      const map = new google.maps.Map(document.getElementById("map"), {--}}
{{--        center: { lat: -33.8688, lng: 151.2195 },--}}
{{--        zoom: 13,--}}
{{--        mapTypeId: "roadmap",--}}
{{--      });--}}
{{--      // Create the search box and link it to the UI element.--}}
{{--      const input = document.getElementById("pac-input");--}}
{{--      const searchBox = new google.maps.places.SearchBox(input);--}}
{{--      map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);--}}
{{--      // Bias the SearchBox results towards current map's viewport.--}}
{{--      map.addListener("bounds_changed", () => {--}}
{{--        searchBox.setBounds(map.getBounds());--}}
{{--      });--}}
{{--      let markers = [];--}}
{{--      // Listen for the event fired when the user selects a prediction and retrieve--}}
{{--      // more details for that place.--}}
{{--      searchBox.addListener("places_changed", () => {--}}
{{--        const places = searchBox.getPlaces();--}}

{{--        if (places.length == 0) {--}}
{{--          return;--}}
{{--        }--}}
{{--        // Clear out the old markers.--}}
{{--        markers.forEach((marker) => {--}}
{{--          marker.setMap(null);--}}
{{--        });--}}
{{--        markers = [];--}}
{{--        // For each place, get the icon, name and location.--}}
{{--        const bounds = new google.maps.LatLngBounds();--}}
{{--        places.forEach((place) => {--}}
{{--          if (!place.geometry || !place.geometry.location) {--}}
{{--            console.log("Returned place contains no geometry");--}}
{{--            return;--}}
{{--          }--}}
{{--          const icon = {--}}
{{--            url: place.icon,--}}
{{--            size: new google.maps.Size(71, 71),--}}
{{--            origin: new google.maps.Point(0, 0),--}}
{{--            anchor: new google.maps.Point(17, 34),--}}
{{--            scaledSize: new google.maps.Size(25, 25),--}}
{{--          };--}}
{{--          // Create a marker for each place.--}}
{{--          markers.push(--}}
{{--                  new google.maps.Marker({--}}
{{--                    map,--}}
{{--                    icon,--}}
{{--                    title: place.name,--}}
{{--                    position: place.geometry.location,--}}
{{--                  })--}}
{{--          );--}}

{{--          if (place.geometry.viewport) {--}}
{{--            // Only geocodes have viewport.--}}
{{--            bounds.union(place.geometry.viewport);--}}
{{--          } else {--}}
{{--            bounds.extend(place.geometry.location);--}}
{{--          }--}}
{{--        });--}}
{{--        map.fitBounds(bounds);--}}
{{--      });--}}
{{--    }--}}
{{--  </script>--}}
{{--@endpush--}}
{{--@push('style-css')--}}
{{--  <style type="text/css">--}}
{{--    /* Always set the map height explicitly to define the size of the div--}}
{{--     * element that contains the map. */--}}
{{--    #map {--}}
{{--      height: 100%;--}}
{{--    }--}}

{{--    /* Optional: Makes the sample page fill the window. */--}}
{{--    html,--}}
{{--    body {--}}
{{--      height: 100%;--}}
{{--      margin: 0;--}}
{{--      padding: 0;--}}
{{--    }--}}

{{--    #description {--}}
{{--      font-family: Roboto;--}}
{{--      font-size: 15px;--}}
{{--      font-weight: 300;--}}
{{--    }--}}

{{--    #infowindow-content .title {--}}
{{--      font-weight: bold;--}}
{{--    }--}}

{{--    #infowindow-content {--}}
{{--      display: none;--}}
{{--    }--}}

{{--    #map #infowindow-content {--}}
{{--      display: inline;--}}
{{--    }--}}

{{--    .pac-card {--}}
{{--      margin: 10px 10px 0 0;--}}
{{--      border-radius: 2px 0 0 2px;--}}
{{--      box-sizing: border-box;--}}
{{--      -moz-box-sizing: border-box;--}}
{{--      outline: none;--}}
{{--      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);--}}
{{--      background-color: #fff;--}}
{{--      font-family: Roboto;--}}
{{--    }--}}

{{--    #pac-container {--}}
{{--      padding-bottom: 12px;--}}
{{--      margin-right: 12px;--}}
{{--    }--}}

{{--    .pac-controls {--}}
{{--      display: inline-block;--}}
{{--      padding: 5px 11px;--}}
{{--    }--}}

{{--    .pac-controls label {--}}
{{--      font-family: Roboto;--}}
{{--      font-size: 13px;--}}
{{--      font-weight: 300;--}}
{{--    }--}}

{{--    #pac-input {--}}
{{--      background-color: #fff;--}}
{{--      font-family: Roboto;--}}
{{--      font-size: 15px;--}}
{{--      font-weight: 300;--}}
{{--      margin-left: 12px;--}}
{{--      padding: 0 11px 0 13px;--}}
{{--      text-overflow: ellipsis;--}}
{{--      width: 400px;--}}
{{--    }--}}

{{--    #pac-input:focus {--}}
{{--      border-color: #4d90fe;--}}
{{--    }--}}

{{--    #title {--}}
{{--      color: #fff;--}}
{{--      background-color: #4d90fe;--}}
{{--      font-size: 25px;--}}
{{--      font-weight: 500;--}}
{{--      padding: 6px 12px;--}}
{{--    }--}}

{{--    #target {--}}
{{--      width: 345px;--}}
{{--    }--}}
{{--  </style>--}}
{{--@endpush--}}
{{--@section('content')--}}
{{--<div class="gap"></div>--}}
{{--<div class="container">--}}
{{--	<div class="row">--}}
{{--		<div class="col-md-8">--}}
{{--			<h1 class="entry-title entry-prop">Đăng tin Phòng trọ</h1>--}}
{{--			<hr>--}}
{{--			<div class="panel panel-default">--}}
{{--				<div class="panel-heading">Thông tin bắt buộc*</div>--}}
{{--				<div class="panel-body">--}}
{{--					<div class="gap"></div>--}}
{{--					@if ($errors->any())--}}
{{--					<div class="alert alert-danger">--}}
{{--						<ul>--}}
{{--							@foreach ($errors->all() as $error)--}}
{{--							<li>{{ $error }}</li>--}}
{{--							@endforeach--}}
{{--						</ul>--}}
{{--					</div>--}}
{{--					@endif--}}
{{--					@if(session('warn'))--}}
{{--          <div class="alert bg-danger">--}}
{{--            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>--}}
{{--            <span class="text-semibold">Error!</span>  {{session('warn')}}--}}
{{--          </div>--}}
{{--          @endif--}}
{{--          @if(session('success'))--}}
{{--					<div class="alert bg-success">--}}
{{--						<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>--}}
{{--						<span class="text-semibold">Done!</span>  {{session('success')}}--}}
{{--					</div>--}}
{{--					@endif--}}
{{--          @if(Auth::user()->tinhtrang != 0)--}}
{{--					<form action="{{ route ('user.dangtin') }}" method="POST" enctype="multipart/form-data" >--}}
{{--            <input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
{{--						<div class="form-group">--}}
{{--							<label for="usr">Tiêu đề bài đăng:</label>--}}
{{--							<input type="text" class="form-control" name="txttitle">--}}
{{--						</div>--}}
{{--						<div class="form-group">--}}
{{--							<label>Địa chỉ phòng trọ:</label> Bạn có thể nhập hoặc chọn ví trí trên bản đồ --}}
{{--							<input type="text" id="location-text-box" name="txtaddress" class="form-control" value="" />--}}

{{--                          <input type="text" id="pac-input" name="txtaddress" class="form-control" value="" PLACEHOLDER="Địa chỉ phòng trọ" />--}}
{{--              <p><i class="far fa-bell"></i> Nếu địa chỉ hiển thị bên bản đồ không đúng bạn có thể điều chỉnh bằng cách kéo điểm màu xanh trên bản đồ tới vị trí chính xác.</p>--}}
{{--              <input type="hidden" id="txtaddress" name="txtaddress" value=""  class="form-control"  />--}}
{{--              <input type="hidden" id="txtlat" value="" name="txtlat"  class="form-control"  />--}}
{{--              <input type="hidden" id="txtlng"  value="" name="txtlng" class="form-control" />--}}
{{--            </div>--}}
{{--            <div id="map-canvas" style="width: auto; height: 400px;"></div>--}}
{{--                      <input--}}
{{--                              id="pac-input"--}}
{{--                              class="controls"--}}
{{--                              type="text"--}}
{{--                              placeholder="Search Box"--}}
{{--                      />--}}
{{--                      <div id="map"></div>--}}
{{--                      <div id="map" style="width: auto; height: 400px;"></div>--}}

{{--                      <button type="button" onclick="getLocation()">Try It</button>--}}

{{--                      <p id="demo"></p>--}}
{{--                      <iframe id="google-map"--}}
{{--                              width="100%"--}}
{{--                              height="450"--}}
{{--                              frameborder="0" style="border:0"--}}
{{--                              src="https://www.google.com/maps/embed/v1/place?key=AIzaSyDSgjO2ZLs29Zmv-GPwKucq0hkrIlrrF-U--}}
{{--    &q=LATITUDE,LONGITUDE" allowfullscreen>--}}
{{--                      </iframe>--}}
{{--            <div class="row">--}}
{{--              <div class="col-md-6">--}}
{{--                <div class="form-group">--}}
{{--                  <label for="usr">Giá phòng( vnđ ):</label>--}}
{{--                  <input type="number" name="txtprice" class="form-control" placeholder="750000" >--}}
{{--                </div>--}}
{{--              </div>--}}
{{--              <div class="col-md-6">--}}
{{--                <div class="form-group">--}}
{{--                  <label for="usr">Diện tích( m<sup>2</sup> ):</label>--}}
{{--                  <input type="number" name="txtarea" class="form-control" placeholder="16">--}}
{{--                </div>--}}
{{--              </div>--}}
{{--            </div>--}}
{{--            <div class="row">--}}
{{--              <div class="col-md-4">--}}
{{--                <div class="form-group">--}}
{{--                  <label for="usr">Quận/ Huyện:</label>--}}
{{--                  <select class="selectpicker pull-right" data-live-search="true" name="iddistrict">--}}
{{--                    @foreach($district as $quan)--}}
{{--                    <option data-tokens="{{$quan->slug}}" value="{{ $quan->id }}">{{ $quan->name }}</option>--}}
{{--                    @endforeach--}}
{{--                  </select>--}}
{{--                </div>--}}
{{--              </div>--}}
{{--              <div class="col-md-4">--}}
{{--                <div class="form-group">--}}
{{--                  <label for="usr">Danh mục:</label>--}}
{{--                  <select class="selectpicker pull-right" data-live-search="true" class="form-control" name="idcategory"> --}}
{{--                    @foreach($categories as $category)--}}
{{--                    <option data-tokens="{{$category->slug}}" value="{{ $category->id }}">{{ $category->name }}</option>--}}
{{--                    @endforeach--}}
{{--                  </select>--}}
{{--                </div>--}}
{{--              </div>--}}
{{--              <div class="col-md-4">--}}
{{--                <div class="form-group">--}}
{{--                  <label for="usr">SĐT Liên hệ:</label>--}}
{{--                  <input type="text" name="txtphone" class="form-control" placeholder="0915111234">--}}
{{--                </div>--}}
{{--              </div>--}}
{{--            </div> --}}
{{--            <div class="form-group">--}}
{{--              <!-- ************** Max Items Demo ************** -->--}}
{{--              <label>Các tiện ích có trong phòng trọ:</label>--}}
{{--              <select id="select-state" name="tienich[]" multiple class="demo-default" placeholder="Chọn các tiện ích phòng trọ">--}}
{{--                <option value="Wifi miễn phí">Wifi miễn phí</option>--}}
{{--                <option value="Có gác lửng">Có gác lửng</option>--}}
{{--                <option value="Tủ + giường">Tủ + giường</option>--}}
{{--                <option value="Không chung chủ">Không chung chủ</option>--}}
{{--                <option value="Chung chủ" >Chung chủ</option>--}}
{{--                <option value="Giờ giấc tự do">Giờ giấc tự do</option>--}}
{{--                <option value="Vệ sinh riêng">Vệ sinh riêng</option>--}}
{{--                <option value="Vệ sinh chung">Vệ sinh chung</option>--}}
{{--              </select>--}}
{{--            </div>--}}
{{--            <div class="form-group">--}}
{{--              <label for="comment">Mô tả ngắn:</label>--}}
{{--              <textarea class="form-control" rows="5" name="txtdescription" style=" resize: none;"></textarea>--}}
{{--            </div>--}}
{{--            <div class="form-group">--}}
{{--              <label for="comment">Thêm hình ảnh:</label>--}}
{{--              <div class="file-loading">--}}
{{--                <input id="file-5" type="file" class="file" name="hinhanh[]" multiple data-preview-file-type="any" data-upload-url="#">--}}
{{--              </div>--}}
{{--            </div>--}}
{{--            --}}
{{--            <button class="btn btn-primary">Đăng Tin</button>--}}
{{--          </form>--}}
{{--          @else--}}
{{--          <div class="alert bg-danger">--}}
{{--            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>--}}
{{--            <span class="text-semibold">Error!</span>  Tài khoản của bạn đang bị khóa đăng tin.--}}
{{--          </div>--}}
{{--          @endif--}}
{{--        </div>--}}
{{--      </div>--}}
{{--    </div>--}}
{{--    <div class="col-md-4">--}}
{{--     <div class="contactpanel">--}}
{{--      <div class="row">--}}
{{--       <div class="col-md-4 text-center">--}}
{{--        <img src="assets/images/noavt.png" class="img-circle" alt="Cinque Terre" width="100" height="100"> --}}
{{--      </div>--}}
{{--      <div class="col-md-8">--}}
{{--        <h4>Thông tin người đăng</h4>--}}
{{--        <strong> {{ Auth::user()->name }}</strong><br>--}}
{{--        <i class="far fa-clock"></i> Ngày tham gia: {{ Auth::user()->created_at }}	--}}

{{--      </div>--}}
{{--    </div>--}}
{{--  </div>--}}
{{--  --}}
{{--  <div class="gap"></div>--}}
{{--  <img src="images/banner-1.png" width="100%">--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--<script type="text/javascript">--}}
{{--  $('#file-5').fileinput({--}}
{{--    theme: 'fa',--}}
{{--    language: 'vi',--}}
{{--    showUpload: false,--}}
{{--    allowedFileExtensions: ['jpg', 'png', 'gif']--}}
{{--  });--}}
{{--</script>--}}
{{--<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDSgjO2ZLs29Zmv-GPwKucq0hkrIlrrF-U&callback=initialize&libraries=geometry,places" async defer></script>--}}
{{--<script>--}}
{{--  var map;--}}
{{--  var marker;--}}


{{--  // var x = document.getElementById("demo");--}}
{{--  //--}}
{{--  // function getLocation(e) {--}}
{{--  //   // e.preventDefault()--}}
{{--  //   if (navigator.geolocation) {--}}
{{--  //     navigator.geolocation.getCurrentPosition(showPosition);--}}
{{--  //--}}
{{--  //   } else {--}}
{{--  //     x.innerHTML = "Geolocation is not supported by this browser.";--}}
{{--  //   }--}}
{{--  // }--}}
{{--  //--}}
{{--  // function showPosition(position) {--}}
{{--  //   // x.innerHTML = "Latitude: " + position.coords.latitude +--}}
{{--  //   //         "<br>Longitude: " + position.coords.longitude;--}}
{{--  //   let coordinate={latitude:position.coords.latitude,longitude:position.coords.longitude};--}}
{{--  //   let url=$('#google-map').attr('src');--}}
{{--  //   url=url.replace('LATITUDE',coordinate.latitude)--}}
{{--  //   url=url.replace('LONGITUDE',coordinate.longitude)--}}
{{--  //   // console.log(url)--}}
{{--  //  $('#google-map').attr('src',url);--}}
{{--  //   // return coordinate;--}}
{{-- // }--}}

{{--  function initialize() {--}}
{{--    var mapOptions = {--}}
{{--      center: {lat: 16.070372, lng: 108.214388},--}}
{{--      zoom: 12--}}
{{--    };--}}
{{--    map = new google.maps.Map(document.getElementById('map-canvas'),--}}
{{--      mapOptions);--}}

{{--  // Get GEOLOCATION--}}
{{--  if (navigator.geolocation) {--}}
{{--    navigator.geolocation.getCurrentPosition(function(position) {--}}
{{--      var pos = new google.maps.LatLng(position.coords.latitude,--}}
{{--        position.coords.longitude);--}}
{{--      var geocoder = new google.maps.Geocoder();--}}
{{--      geocoder.geocode({--}}
{{--        'latLng': pos--}}
{{--      }, function (results, status) {--}}
{{--        if (status ==--}}
{{--          google.maps.GeocoderStatus.OK) {--}}
{{--          if (results[0]) {--}}
{{--            console.log(results[0].formatted_address);--}}
{{--          } else {--}}
{{--            console.log('No results found');--}}
{{--          }--}}
{{--        } else {--}}
{{--          console.log('Geocoder failed due to: ' + status);--}}
{{--        }--}}
{{--      });--}}
{{--      map.setCenter(pos);--}}
{{--      marker = new google.maps.Marker({--}}
{{--        position: pos,--}}
{{--        map: map,--}}
{{--        draggable: true--}}
{{--      });--}}
{{--    }, function() {--}}
{{--      handleNoGeolocation(true);--}}
{{--    });--}}
{{--  } else {--}}
{{--    // Browser doesn't support Geolocation--}}
{{--    handleNoGeolocation(false);--}}
{{--  }--}}

{{--  function handleNoGeolocation(errorFlag) {--}}
{{--    if (errorFlag) {--}}
{{--      var content = 'Error: The Geolocation service failed.';--}}
{{--    } else {--}}
{{--      var content = 'Error: Your browser doesn\'t support geolocation.';--}}
{{--    }--}}

{{--    var options = {--}}
{{--      map: map,--}}
{{--      zoom: 19,--}}
{{--      position: new google.maps.LatLng(16.070372,108.214388),--}}
{{--      content: content--}}
{{--    };--}}

{{--    map.setCenter(options.position);--}}
{{--    marker = new google.maps.Marker({--}}
{{--      position: options.position,--}}
{{--      map: map,--}}
{{--      zoom: 19,--}}
{{--      icon: "images/gps.png",--}}
{{--      draggable: true--}}
{{--    });--}}
{{--    /* Dragend Marker */--}}
{{--    google.maps.event.addListener(marker, 'dragend', function() {--}}
{{--      var geocoder = new google.maps.Geocoder();--}}
{{--      geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {--}}
{{--        if (status == google.maps.GeocoderStatus.OK) {--}}
{{--          if (results[0]) {--}}
{{--            $('#location-text-box').val(results[0].formatted_address);--}}
{{--            $('#txtaddress').val(results[0].formatted_address);--}}
{{--            $('#txtlat').val(marker.getPosition().lat());--}}
{{--            $('#txtlng').val(marker.getPosition().lng());--}}
{{--            infowindow.setContent(results[0].formatted_address);--}}
{{--            infowindow.open(map, marker);--}}
{{--          }--}}
{{--        }--}}
{{--      });--}}
{{--    });--}}
{{--    /* End Dragend */--}}

{{--  }--}}

{{--  // get places auto-complete when user type in location-text-box--}}
{{--  var input = /** @type {HTMLInputElement} */--}}
{{--  (--}}
{{--    document.getElementById('location-text-box'));--}}


{{--  var autocomplete = new google.maps.places.Autocomplete(input);--}}
{{--  autocomplete.bindTo('bounds', map);--}}

{{--  var infowindow = new google.maps.InfoWindow();--}}
{{--  marker = new google.maps.Marker({--}}
{{--    map: map,--}}
{{--    icon: "images/gps.png",--}}
{{--    anchorPoint: new google.maps.Point(0, -29),--}}
{{--    draggable: true--}}
{{--  });--}}

{{--  google.maps.event.addListener(autocomplete, 'place_changed', function() {--}}
{{--    infowindow.close();--}}
{{--    marker.setVisible(false);--}}
{{--    var place = autocomplete.getPlace();--}}
{{--    if (!place.geometry) {--}}
{{--      return;--}}
{{--    }--}}
{{--    var geocoder = new google.maps.Geocoder();--}}
{{--    geocoder.geocode({'latLng': place.geometry.location}, function(results, status) {--}}
{{--      if (status == google.maps.GeocoderStatus.OK) {--}}
{{--        if (results[0]) {--}}
{{--          $('#txtaddress').val(results[0].formatted_address);--}}
{{--          infowindow.setContent(results[0].formatted_address);--}}
{{--          infowindow.open(map, marker);--}}
{{--        }--}}
{{--      }--}}
{{--    });--}}
{{--    // If the place has a geometry, then present it on a map.--}}
{{--    if (place.geometry.viewport) {--}}
{{--      map.fitBounds(place.geometry.viewport);--}}
{{--    } else {--}}
{{--      map.setCenter(place.geometry.location);--}}
{{--      map.setZoom(17); // Why 17? Because it looks good.--}}
{{--    }--}}
{{--    marker.setIcon( /** @type {google.maps.Icon} */ ({--}}
{{--      url: "images/gps.png"--}}
{{--    }));--}}
{{--    document.getElementById('txtlat').value = place.geometry.location.lat();--}}
{{--    document.getElementById('txtlng').value = place.geometry.location.lng();--}}
{{--    console.log(place.geometry.location.lat());--}}
{{--    marker.setPosition(place.geometry.location);--}}
{{--    marker.setVisible(true);--}}

{{--    var address = '';--}}
{{--    if (place.address_components) {--}}
{{--      address = [--}}
{{--      (place.address_components[0] && place.address_components[0].short_name || ''), (place.address_components[1] && place.address_components[1].short_name || ''), (place.address_components[2] && place.address_components[2].short_name || '')--}}
{{--      ].join(' ');--}}
{{--    }--}}
{{--    /* Dragend Marker */--}}
{{--    google.maps.event.addListener(marker, 'dragend', function() {--}}
{{--      var geocoder = new google.maps.Geocoder();--}}
{{--      geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {--}}
{{--        if (status == google.maps.GeocoderStatus.OK) {--}}
{{--          if (results[0]) {--}}
{{--            $('#location-text-box').val(results[0].formatted_address);--}}
{{--            $('#txtlat').val(marker.getPosition().lat());--}}
{{--            $('#txtlng').val(marker.getPosition().lng());--}}
{{--            infowindow.setContent(results[0].formatted_address);--}}
{{--            infowindow.open(map, marker);--}}
{{--          }--}}
{{--        }--}}
{{--      });--}}
{{--    });--}}
{{--    /* End Dragend */--}}
{{--  });--}}

{{--}--}}


{{--google.maps.event.addDomListener(window, 'load', initialize);--}}
{{--</script>--}}
{{--<script--}}
{{--        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDSgjO2ZLs29Zmv-GPwKucq0hkrIlrrF-U&callback=initAutocomplete&libraries=places&v=weekly"--}}
{{--        async--}}
{{--></script>--}}
{{--<script type="text/javascript" src="assets/js/selectize.js"></script>--}}
{{--<script>--}}
{{--  $(function() {--}}
{{--    $('select').selectize(options);--}}
{{--  });--}}
{{--  $('#select-state').selectize({--}}
{{--    maxItems: null--}}
{{--  });--}}
{{--</script>--}}
{{--@endsection--}}
@extends('layouts.master')
@section('content')
    <div class="gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h1 class="entry-title entry-prop">Đăng tin Phòng trọ</h1>
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
                            <form action="{{ route ('user.dangtin') }}" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <label for="usr">Tiêu đề bài đăng:</label>
                                    <input type="text" class="form-control" name="txttitle">
                                </div>
                                <div class="form-group">
                                    <label>Địa chỉ phòng trọ:</label> Bạn có thể nhập hoặc chọn ví trí trên bản đồ
                                    <input type="text" id="location-text-box" name="txtaddress" class="form-control"
                                           value=""/>
                                    <p><i class="far fa-bell"></i> Nếu địa chỉ hiển thị bên bản đồ không đúng bạn có thể
                                        điều chỉnh bằng cách kéo điểm màu xanh trên bản đồ tới vị trí chính xác.</p>
                                    <input type="hidden" id="txtaddress" name="txtaddress" value=""
                                           class="form-control"/>
                                    <input type="hidden" id="txtlat" value="" name="txtlat" class="form-control"/>
                                    <input type="hidden" id="txtlng" value="" name="txtlng" class="form-control"/>
                                </div>
                                <div id="map-canvas" style="width: auto; height: 400px;"></div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="usr">Giá phòng( vnđ ):</label>
                                            <input type="number" name="txtprice" class="form-control"
                                                   placeholder="750000">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="usr">Diện tích( m<sup>2</sup> ):</label>
                                            <input type="number" name="txtarea" class="form-control" placeholder="16">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="usr">Quận/ Huyện:</label>
                                            <select class="selectpicker pull-right" data-live-search="true"
                                                    name="iddistrict">
                                                @foreach($district as $quan)
                                                    <option data-tokens="{{$quan->slug}}"
                                                            value="{{ $quan->id }}">{{ $quan->name }}</option>
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
                                                            value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="usr">SĐT Liên hệ:</label>
                                            <input type="text" name="txtphone" class="form-control"
                                                   placeholder="0915111234">
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
                                              style=" resize: none;"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="comment">Thêm hình ảnh:</label>
                                    <div class="file-loading">
                                        <input id="file-5" type="file" class="file" name="hinhanh[]" multiple
                                               data-preview-file-type="any" data-upload-url="#">
                                    </div>
                                </div>

                                <button class="btn btn-primary">Đăng Tin</button>
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
                <img src="images/banner-1.png" width="100%">
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $('#file-5').fileinput({
            theme: 'fa',
            language: 'vi',
            showUpload: false,
            allowedFileExtensions: ['jpg', 'png', 'gif']
        });
    </script>
    <script type="text/javascript"
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDSgjO2ZLs29Zmv-GPwKucq0hkrIlrrF-U&callback=initialize&libraries=geometry,places"
            async defer></script>
    <script>
        var map;
        var marker;

        // console.log(navigator.geolocation.getCurrentPosition(showPosition))

        function showPosition(position) {
            // x.innerHTML = "Latitude: " + position.coords.latitude +
            //         "<br>Longitude: " + position.coords.longitude;
            console.log(position.coords.latitude)
            console.log(position.coords.longitude)
        }

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