<div class="list-motelroom">
    @foreach($motelrooms as $motelroom)
        @php
            $images = (array)(json_decode($motelroom->images));
        @endphp
        <div class="motelroom-wrapper">
            <div class="image-wrapper">
                <img class="image" src="{{ asset('uploads/images/'.$images[0]) }}" alt="">
                @if(\Illuminate\Support\Facades\Auth::check())
                    @if(\Illuminate\Support\Facades\Auth::user()->user_type != 3)
                        <div class="heart-wrapper">
                            <div id="heart-container">
                                <input type="checkbox" data-id="{{ $motelroom->id }}"  {{ \Illuminate\Support\Facades\Auth::user()->favourite->where('motelroom_id', $motelroom->id)->first() ? 'checked' : '' }} class="toggle">
                                <div id="twitter-heart"></div>
                                </input>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-6">
                        <div class="name-wrapper">
                            <a class="name" href="{{ route('user.motelroom.detail', $motelroom->slug) }}">{{ $motelroom->title }}</a>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="star-ratings-wrapper">
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

@push('after-script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function () {
            $('.toggle').click(function () {
                let motelroom_id = $(this).data('id'),
                    user_id = {{ \Illuminate\Support\Facades\Auth::user()->id }},
                    url = "{{ route('user.motel.favourite') }}",
                    type = 1;

                if (!$(this).attr('checked')) {
                    type = 0;
                }
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {
                        user_id: user_id,
                        motelroom_id: motelroom_id,
                        type: type
                    },
                    success: function (res) {
                        console.log(res)
                    }
                })
            })
        })
    </script>
@endpush