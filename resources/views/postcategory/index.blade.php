@extends('layouts.master')
@section('content')
    <div class="gap"></div>
    <div class="container">
        <div class="postcategory">
            <div class="title-wrapper">
                <h2 class="title">Giới thiệu LalaHome</h2>
            </div>
            <div class="content-wrapper">
                <p class="content">
                    LalaHome tự hào là trang web đứng top đầu google về từ khóa: cho thuê phòng trọ,
                    thuê phòng trọ, phòng trọ hồ chí minh, phòng trọ hà nội, thuê nhà nguyên căn, cho
                    thuê căn hộ, tìm người ở ghép…với lưu lượng truy cập (traffic) cao nhất trong lĩnh vực.

                    LalaHome tự hào có lượng dữ liệu bài đăng lớn nhất trong lĩnh vực cho thuê phòng
                    trọ với hơn 70.000 tin trên hệ thống và tiếp tục tăng.

                    LalaHome tự hào có số lượng người dùng lớn nhất trong lĩnh vực cho thuê phòng trọ
                    với hơn 300.000 khách truy cập và hơn 2.000.000 lượt pageview mỗi tháng.
                </p>
            </div>
            <div class="postcategory-table">
                <div class="title-wrapper">
                    <h3 class="title">Bảng giá dịch vụ</h3>
                </div>
                <div class="table-wrapper">
                   <table class="table  table-bordered text-center">
                       <thead>
                        <tr>
                            <th>Loại tin</th>
                            <th>Giá ngày</th>
                            <th>Giá tuần</th>
                            <th>Giá tháng</th>
                            <th>Giá UP TOP</th>
                            <th>Tối thiểu</th>
                        </tr>
                       </thead>
                       <tbody>
                       @foreach($postCategories as $postCategory)
                        <tr>
                            <th>{{ $postCategory->name }}</th>
                            <th>{{ number_format($postCategory->price, 2, ',', '.') }}</th>
                            <th>{{ number_format($postCategory->price*7, 2, ',', '.') }}</th>
                            <th>{{ number_format($postCategory->price*30, 2, ',', '.') }}</th>
                            <th>{{ number_format( 5000, 2,',', '.') }}</th>
                            <th>{{ $postCategory->max_date }} ngày</th>
                        </tr>
                       @endforeach
                       </tbody>
                   </table>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        $(document).ready(function (){

        })
    </script>
@endsection