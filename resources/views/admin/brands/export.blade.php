<table>
    <thead>
        <tr>
            <th>Tên</th>
            <th>Số ĐT</th>
            <th>Địa chỉ</th>
            <th>Thời gian tạo</th>
        </tr>
    </thead>
    <tbody>
    @foreach($data as $staff)
        <tr>
            <td>{{ $staff->name }}</td>
            <td>{{ $staff->phone }}</td>
            <td>{{ $staff->address }}</td>
            <td>{{ formatDate($staff->created_at) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
