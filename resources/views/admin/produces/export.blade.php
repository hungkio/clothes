<table>
    <thead>
        <tr>
            <th>Thứ tự</th>
            <th>Tên nguyên liệu</th>
            <th>Số lượng</th>
            <th>Thời gian cập nhật</th>
            <th>Thời gian tạo</th>
        </tr>
    </thead>
    <tbody>
    @foreach($data as $post)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $post->name }}</td>
            <td>{{ $post->quantity }}</td>
            <td>{{ formatDate($post->updated_at) }}</td>
            <td>{{ formatDate($post->created_at) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
