$(function () {
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
    let min = $("#selectprice option:selected").attr("min");
    let max = $("#selectprice option:selected").attr("max");
    let id_ditrict = $("#selectdistrict").val();
    let id_category = $("#selectcategory").val();
    let district = $('#selectdistrict option:selected').text()
    // console.log(min,max,id_category,id_ditrict);
    let data_send = {
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

            let array = [];
            let i = 0;

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


                    // // let districtName = placeMarks[0].children[1].children[0].children[2].innerHTML
                    // // if() {
                    // // }
                    // // }
                    // let strCoordinates = placeMarks[0].children[2].children[0].children[0].children[0].children[0].innerHTML
                    // // console.log(strCoordinates)
                    // let re = ' +';
                    // let coordinates=strCoordinates.split(' ')
                    //
                    // coordinates.forEach(coordinate=>{
                    //
                    //     let arr=coordinate.split(',')
                    //     let lat=arr[1],
                    //         lng=arr[0];
                    //     // coordinatesObj[i]={lat:parseFloat(lat),lng: parseFloat(lng)}
                    //     coordinatesObj.push({lat:parseFloat(lat),lng: parseFloat(lng)})
                    //     // i++;
                    // })


                    placeMarks.forEach(placeMark => {
                        let districtName = placeMark.children[1].children[0].children[2].innerHTML
                        if (district.match(districtName)) {
                            // console.log(districtName)
                            // console.log(districtName)
                            let strCoordinates = placeMark.children[2].children[0].children[0].children[0].children[0].innerHTML
                            // console.log(strCoordinates)
                            let re = /\s*;\s*/;
                            let coordinates = strCoordinates.split(' ')

                            coordinates.forEach(coordinate => {

                                // console.log(coordinate)
                                let arr = coordinate.split(','),
                                    lat = arr[1],
                                    lng = arr[0];
                                array[i] =  {lat: parseFloat(lat), lng: parseFloat(lng)}
                                i++;
                                // console.log(array)
                            })
                        }
                    })
                });
            })


            var result_room = JSON.parse(result);
            if (result_room.length != 0)
                toastr.success('Tìm thấy ' + result_room.length + ' kết quả');
            else
                toastr.warning('Không tìm thấy kết quả nào');


            var map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: 21.028511, lng:  105.85131836},
                zoom: 15,
                //draggable: true,
                mapTypeId: "terrain",
            });

            // console.log(map)
            const triangleCoords = [
                {lat: 21.01835632, lng: 105.85319519},
                {lat: 21.01832581, lng: 105.85131836},
                {lat: 21.01938629, lng: 105.85036469},
                {lat: 21.01869011, lng: 105.84954834},
                {lat: 21.0188179, lng: 105.84892273},
                {lat: 21.02073097, lng: 105.84282684},
                {lat: 21.02115822, lng: 105.84145355},
                {lat: 21.02105331, lng: 105.84091187},
                {lat: 21.02883911, lng: 105.84156036},
                {lat: 21.02936363, lng: 105.84303284},
                {lat: 21.03011322, lng: 105.84404755},
                {lat: 21.03503418, lng: 105.84410858},
                {lat: 21.03936386, lng: 105.84461212},
                {lat: 21.03993988, lng: 105.84739685},
                {lat: 21.03998756, lng: 105.8475647},
                {lat: 21.04075623, lng: 105.85002136},
                {lat: 21.0402317, lng: 105.85057068},
                {lat: 21.04243088, lng: 105.85635376},
                {lat: 21.04028893, lng: 105.85832214},
                {lat: 21.03354454, lng: 105.86185455},
                {lat: 21.0302639, lng: 105.86462402},
                {lat: 21.02458572, lng: 105.86633301},
                {lat: 21.01988792, lng: 105.86779785},
                {lat: 21.01855087, lng: 105.86199188},
                {lat: 21.01906586, lng: 105.85875702},
                {lat: 21.01893044, lng: 105.8559494},
                {lat: 21.01817322, lng: 105.85466766},
                {lat: 21.01835632, lng: 105.85319519},

                // {lat: 20.99428558, lng: 105.90068817}    ,
                // {lat: 20.9990139, lng: 105.89408112}   ,
                // {lat: 21.00270081, lng: 105.8830719}   ,
                // {lat: 21.00530815, lng: 105.87498474}  ,
                // {lat: 21.01103973, lng: 105.86999512}  ,
                // {lat: 21.01988792, lng: 105.86779785}  ,
                // {lat: 21.02458572, lng: 105.86633301}  ,
                // {lat: 21.0302639, lng: 105.86462402}   ,
                // {lat: 21.03354454, lng: 105.86185455}  ,
                // {lat: 21.04028893, lng: 105.85832214}  ,
                // {lat: 21.04243088, lng: 105.85635376} ,
                // {lat: 21.0543766, lng: 105.84924316}  ,
                // {lat: 21.05807495, lng: 105.84765625} ,
                // {lat: 21.07192993, lng: 105.84356689} ,
                // {lat: 21.08115578, lng: 105.8416748}  ,
                // {lat: 21.08005333, lng: 105.84564209} ,
                // {lat: 21.07273865, lng: 105.85547638} ,
                // {lat: 21.06809998, lng: 105.86120605} ,
                // {lat: 21.06652451, lng: 105.8647995}  ,
                // {lat: 21.06791115, lng: 105.87159729} ,
                // {lat: 21.07111168, lng: 105.87796783} ,
                // {lat: 21.07457161, lng: 105.88272858} ,
                // {lat: 21.07681656, lng: 105.88654327} ,
                // {lat: 21.07926559, lng: 105.89372253} ,
                // {lat: 21.07979012, lng: 105.89772034} ,
                // {lat: 21.07860184, lng: 105.90273285} ,
                // {lat: 21.07770538, lng: 105.90856171} ,
                // {lat: 21.07720184, lng: 105.91178131} ,
                // {lat: 21.07588768, lng: 105.91855621} ,
                // {lat: 21.07192993, lng: 105.92456055} ,
                // {lat: 21.06771851, lng: 105.92775726} ,
                // {lat: 21.05692291, lng: 105.93268585} ,
                // {lat: 21.04786682, lng: 105.93566895} ,
                // {lat: 21.04009628, lng: 105.93802643} ,
                // {lat: 21.03570175, lng: 105.93480682} ,
                // {lat: 21.03507614, lng: 105.93508911} ,
                // {lat: 21.03318787, lng: 105.9331665}  ,
                // {lat: 21.03257751, lng: 105.93359375} ,
                // {lat: 21.02638817, lng: 105.92742157} ,
                // {lat: 21.02565765, lng: 105.92718506} ,
                // {lat: 21.02483368, lng: 105.92918396} ,
                // {lat: 21.02601433, lng: 105.92973328} ,
                // {lat: 21.02468109, lng: 105.93486023} ,
                // {lat: 21.02392387, lng: 105.93424988} ,
                // {lat: 21.02360344, lng: 105.93510437} ,
                // {lat: 21.02252769, lng: 105.93465424} ,
                // {lat: 21.02152824, lng: 105.93700409} ,
                // {lat: 21.02111244, lng: 105.9379425}  ,
                // {lat: 21.01980591, lng: 105.92591095} ,
                // {lat: 21.01727676, lng: 105.92606354} ,
                // {lat: 21.01683998, lng: 105.92288208} ,
                // {lat: 21.01439857, lng: 105.92414856} ,
                // {lat: 21.01414299, lng: 105.92224121} ,
                // {lat: 21.01210785, lng: 105.92258453} ,
                // {lat: 21.01193619, lng: 105.91993713} ,
                // {lat: 21.0095253, lng: 105.92018127}  ,
                // {lat: 21.00437546, lng: 105.92056274} ,
                // {lat: 21.00202179, lng: 105.9144516}  ,
                // {lat: 21.00493813, lng: 105.91010284} ,
                // {lat: 21.00230789, lng: 105.90380096} ,
                // {lat: 21.00076485, lng: 105.90459442} ,
                // {lat: 20.99428558, lng: 105.90068817} ,
                ];

            // let coordinatesObj=array;
            //  console.log(array)
            const bermudaTriangle = new google.maps.Polygon({
                paths: array,
                strokeColor: "#FF0000",
                strokeOpacity: 1,
                strokeWeight: 1,
                fillColor: 'white',
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