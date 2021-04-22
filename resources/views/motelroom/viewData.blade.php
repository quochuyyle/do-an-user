<table class="table table-striped">
    <thead>
    <tr>
        <th scope="col">STT</th>
        <th scope="col">Ngày bắt đầu</th>
        <th scope="col">Ngày kết thúc</th>
        <th scope="col">Ngày tạo</th>
        <th scope="col">Chủ nhà trọ</th>
    </tr>
    </thead>
    <tbody>
    <?php $i = 0 ?>
    @foreach($terms as $term)
        <?php $i ++ ?>
        <tr>
            <th scope="row">{{ $i }}</th>
            <td>{{ $term->start_date }}</td>
            <td>{{ $term->end_date }}</td>
            <td>{{ $term->created_at->format('d M Y - H:i:s') }}</td>
            <td>{{ $term->user->name }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
