<div class="list-motelroom">
    @foreach($motelrooms as $motelroom)
        @php
            $images = (array)(json_decode($motelroom->images));
        @endphp
        <div class="motelroom-wrapper">
            <div class="image-wrapper">
                <img class="image" src="{{ asset('uploads/images/'.$images[0]) }}" alt="">
            </div>
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-6">
                        <div class="name-wrapper">
                            <h4 class="name">{{ $motelroom->title }}</h4>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="star-rating">
                            <input type="radio" name="stars" value="1"/>
                        </div>
                    </div>
                </div>

                <div class="information-wrapper">
                    <div class="price-wrapper">
                        <span class="price">Gía: {{ number_format($motelroom->price, null, ',', '.') }} VND</span>
                    </div>
                    <div class="area-wrapper">
                        <span class="area">Diện tích: {{ $motelroom->area }}m2</span>
                    </div>
                </div>
                <div class="address-wrapper">
                                            <span class="address">
                                            Địa chỉ: {{ $motelroom->address }}
                                            </span>
                </div>
                <p class="description"> {{ $motelroom->description }}</p>
                <div class="contact-wrapper">
                    <a href="tel:{{ $motelroom->phone }}" class="btn btn-phone">{{ $motelroom->phone }}</a>
                    <a href="" class="btn btn-message">Nhắn Zalo</a>
                </div>
            </div>
        </div>
    @endforeach
        {!! $motelrooms->render() !!}
</div>