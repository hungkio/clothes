<!DOCTYPE html>
<html lang="en">
<head>
    <title>In Danh sách Sản phẩm</title>
    <meta charset="UTF-8">
    <meta name=description content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <style>
        body {margin: 20px}
    </style>
</head>
<body>
<table class="table table-bordered table-condensed table-striped">
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
</body>
</html>
