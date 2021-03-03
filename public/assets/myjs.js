$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-bottom-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
});

function searchMotelajax() {
    var min = $("#selectprice option:selected").attr("min");
    var max = $("#selectprice option:selected").attr("max");
    var id_ditrict = $("#selectdistrict").val();
    var id_category = $("#selectcategory").val();
    // console.log(min,max,id_category,id_ditrict);
    var data_send = {
        min_price: min,
        max_price: max,
        id_district: id_ditrict,
        id_category: id_category
    }


    // console.log(data_send)
    //console.log(min,max);
    // console.log(data);
    $.ajax({
        url: "searchmotel",
        method: "POST",
        data: data_send,
        success: function (result) {
            let xmlContent = ''

            let coordinatesObj = [],
                i = 0;
            // console.log(result)
            fetch('/assets/coordinates/vietnam.xml').then((response) => {
                // console.log(response)
                response.text().then((xml) => {
                    let parser = new DOMParser();

                    // console.log(xml)
                    let xmlDOM = parser.parseFromString(xml, 'application/xml')
                    // console.log(xmlDOM)
                    let placeMarks = xmlDOM.querySelectorAll('Placemark')
                    // console.log(placeMarks)


                    // let districtName = placeMarks[0].children[1].children[0].children[2].innerHTML
                    // if() {
                    // }
                    // }
                    let strCoordinates = placeMarks[0].children[2].children[0].children[0].children[0].children[0].innerHTML
                    // console.log(strCoordinates)
                    let re = ' +';
                    let coordinates=strCoordinates.split(' ')

                    coordinates.forEach(coordinate=>{

                        let arr=coordinate.split(',')
                        let lat=arr[1],
                            lng=arr[0];
                        // coordinatesObj[i]={lat:parseFloat(lat),lng: parseFloat(lng)}
                        coordinatesObj.push({lat:parseFloat(lat),lng: parseFloat(lng)})
                        // i++;
                    })


                    // placeMarks.forEach(placeMark => {
                    //     let districtName = placeMark.children[1].children[0].children[2].innerHTML
                    //     if (districtName == 'Hoàn Kiếm') {
                    //         // console.log(districtName)
                    //         let strCoordinates = placeMark.children[2].children[0].children[0].children[0].children[0].innerHTML
                    //         // console.log(strCoordinates)
                    //         let re = /\s*;\s*/;
                    //         let coordinates = strCoordinates.split(' ')
                    //
                    //         coordinates.forEach(coordinate => {
                    //
                    //             let arr = coordinate.split(',')
                    //             let lat = arr[1],
                    //                 lng = arr[0];
                    //             coordinatesObj[i] = {lat: parseFloat(lat), lng: parseFloat(lng)}
                    //             i++;
                    //         })
                    //     }
                    // })
                });
            })


            var result_room = JSON.parse(result);
            if (result_room.length != 0)
                toastr.success('Tìm thấy ' + result_room.length + ' kết quả');
            else
                toastr.warning('Không tìm thấy kết quả nào');


            var map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: 21.028511, lng: 105.804817},
                zoom: 15,
                draggable: true,
                mapTypeId: "terrain",
            });

            // console.log(map)
            // const triangleCoords = [
            //     // { lat: 21.0303124, lng: 105.8488809 },
            //     // {lat:21.026564181706924,lng: 105.79837851720734},
            //     // {lat:21.000364085645753, lng:105.82275443138725},
            //     // {lat:21.0098992098145, lng:105.84129385907337},
            //     // {lat:21.02576302375656, lng:105.82275443138725},
            //     // { lat: 18.466, lng: -66.118 },
            //     // { lat: 32.321, lng: -64.757 },
            //     {lng: 105.12155914, lat: 10.71159267},
            //     {lng: 105.11474609, lat: 10.71973896},
            //     {lng: 105.10116577, lat: 10.74414539},
            //     {lng: 105.09790039, lat: 10.76532078},
            //     {lng: 105.0883255, lat: 10.76043224},
            //     {lng: 105.08817291, lat: 10.76061153},
            //     {lng: 105.08486938, lat: 10.76449966},
            //     {lng: 105.0823288, lat: 10.76829147},
            //     {lng: 105.08082581, lat: 10.77006054},
            //     {lng: 105.07979584, lat: 10.77185059},
            //     {lng: 105.07845306, lat: 10.77317238},
            //     {lng: 105.07551575, lat: 10.77719688},
            //     {lng: 105.06964111, lat: 10.77971745},
            //     {lng: 105.06411743, lat: 10.78042889},
            //     {lng: 105.06388092, lat: 10.78098106},
            //     {lng: 105.06224823, lat: 10.79805946},
            //     {lng: 105.05731201, lat: 10.80019665},
            //     {lng: 105.05618286, lat: 10.8013773},
            //     {lng: 105.05581665, lat: 10.80400276},
            //     {lng: 105.05714417, lat: 10.81182384},
            //     {lng: 105.05714417, lat: 10.81229019},
            //     {lng: 105.05713654, lat: 10.81296158},
            //     {lng: 105.05709839, lat: 10.81670952},
            //     {lng: 105.05741882, lat: 10.81685352},
            //     {lng: 105.05765533, lat: 10.81696129},
            //     {lng: 105.05817413, lat: 10.82019138},
            //     {lng: 105.05445862, lat: 10.82912254},
            //     {lng: 105.03429413, lat: 10.8696146},
            //     {lng: 105.03371429, lat: 10.87156868},
            //     {lng: 105.03344727, lat: 10.87246227},
            //     {lng: 105.03321075, lat: 10.8732729},
            //     {lng: 105.02843475, lat: 10.89156055},
            //     {lng: 105.02928925, lat: 10.89202785},
            //     {lng: 105.02968597, lat: 10.89224339},
            //     {lng: 105.03210449, lat: 10.89356804},
            //     {lng: 105.0340271, lat: 10.89427376},
            //     {lng: 105.03412628, lat: 10.89431095},
            //     {lng: 105.03579712, lat: 10.89498997},
            //     {lng: 105.03618622, lat: 10.89562035},
            //     {lng: 105.03612518, lat: 10.89576244}
            //
            // ];

            const triangleCoords=coordinatesObj
            console.log(coordinatesObj)
            const bermudaTriangle = new google.maps.Polygon({
                paths: triangleCoords,
                strokeColor: "#FF0000",
                strokeOpacity: 0.8,
                strokeWeight: 3,
                fillColor: "#FF0000",
                fillOpacity: 0.35,
            });
            // console.log('Here')

            bermudaTriangle.setMap(map);

            for (i in result_room) {


                var geocoder = new google.maps.Geocoder()
                // console.log(geocoder)

                var data = result_room[i];
                // console.log(data)
                // console.log('Here')
                var latlng = new google.maps.LatLng(data.lat, data.lng);


                // var latlng =  new google.maps.Marker({
                // 	position: {lat:data.lat,lng:data.lng },
                // });
                // console.log(latlng)


                // geocoder.geocode({'latLng': place.geometry.location}, function (results, status) {
                //     if (status == google.maps.GeocoderStatus.OK) {
                //         if (results[0]) {
                //             // let count=results[0].address_components.length
                //             // let districts=document.getElementById('selectdistrict')
                //             let districtName=results[0].address_components[count-3].long_name;
                //             console.log(districtName)
                //             // for (let i=0;i<districts.length;i++){
                //             //
                //             //     // if(districtName.match(districts[i].innerText)){
                //             //         console.log(districts[i].innerText)
                //             //    // }
                //             // }
                //         }
                //     }
                // });
                var phongtro = new google.maps.Marker({
                    position: latlng,
                    // position:  {lat:data.lat,lng: data.lng},
                    map: map,
                    title: data.title,
                    icon: "images/gps.png",
                    content: 'dgfdgfdg'
                });
                // console.log(phongtro)


                var infowindow = new google.maps.InfoWindow();
                (function (phongtro, data) {
                    var content = '<div id="iw-container" style="width: 350px;">' +
                        '<img height="200px"  style="width: 100%;" src="uploads/images/' + data.image + '">' +
                        '<a href="detail/' + data.id + '"><div class="iw-title">' + data.title + '</div></a>' +
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
    });


}


(function () {
    var d = document,
        accordionToggles = d.querySelectorAll('.js-accordionTrigger'),
        setAria,
        setAccordionAria,
        switchAccordion,
        touchSupported = ('ontouchstart' in window),
        pointerSupported = ('pointerdown' in window);

    skipClickDelay = function (e) {
        e.preventDefault();
        e.target.click();
    }

    setAriaAttr = function (el, ariaType, newProperty) {
        el.setAttribute(ariaType, newProperty);
    };
    setAccordionAria = function (el1, el2, expanded) {
        switch (expanded) {
            case "true":
                setAriaAttr(el1, 'aria-expanded', 'true');
                setAriaAttr(el2, 'aria-hidden', 'false');
                break;
            case "false":
                setAriaAttr(el1, 'aria-expanded', 'false');
                setAriaAttr(el2, 'aria-hidden', 'true');
                break;
            default:
                break;
        }
    };
//function
    switchAccordion = function (e) {
        console.log("triggered");
        e.preventDefault();
        var thisAnswer = e.target.parentNode.nextElementSibling;
        var thisQuestion = e.target;
        if (thisAnswer.classList.contains('is-collapsed')) {
            setAccordionAria(thisQuestion, thisAnswer, 'true');
        } else {
            setAccordionAria(thisQuestion, thisAnswer, 'false');
        }
        thisQuestion.classList.toggle('is-collapsed');
        thisQuestion.classList.toggle('is-expanded');
        thisAnswer.classList.toggle('is-collapsed');
        thisAnswer.classList.toggle('is-expanded');

        thisAnswer.classList.toggle('animateIn');
    };
    for (var i = 0, len = accordionToggles.length; i < len; i++) {
        if (touchSupported) {
            accordionToggles[i].addEventListener('touchstart', skipClickDelay, false);
        }
        if (pointerSupported) {
            accordionToggles[i].addEventListener('pointerdown', skipClickDelay, false);
        }
        accordionToggles[i].addEventListener('click', switchAccordion, false);
    }
})();