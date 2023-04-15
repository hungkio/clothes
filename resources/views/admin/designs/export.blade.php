<table>
    <thead>
        <tr>
            <th>Thứ tự</th>
            <th>Tên</th>
            <th>Nhân viên</th>
            <th>Tiến trình</th>
            <th>Thời gian</th>
            <th>Trạng thái</th>
            <th>Thời gian tạo</th>
        </tr>
    </thead>
    <tbody>
    @foreach($data as $design)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $design->name }}</td>
            <td>{{ $design->user->last_name ?? '' }}</td>
            <td>{{ \App\Designs::PROGRESS[$design->progress] }}</td>
            <td>{{ $design->duration }}</td>
            <td>{{ \App\Designs::STATUS[$design->status] }}</td>
            <td>{{ formatDate($design->created_at) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
