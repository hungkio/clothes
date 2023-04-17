<table>
    <thead>
    <tr>
        <th>Thứ tự</th>
        <th>Tên</th>
        <th>Số lượng</th>
        <th>Số lượng cắt</th>
        <th>Đã nhận</th>
        <th>Chưa nhận</th>
        <th>Thời gian tạo</th>
        <th>Thời gian cập nhật</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $product)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $product->design->name ?? '' }}</td>
            <td>{{ $product->quantity }}</td>
            <td>{{ $product->cut }}</td>
            <td>{{ $product->receive }}</td>
            <td>{{ $product->not_receive }}</td>
            <td>{{ formatDate($product->created_at) }}</td>
            <td>{{ formatDate($product->updated_at) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
