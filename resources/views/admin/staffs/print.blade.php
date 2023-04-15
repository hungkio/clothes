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
        <th>Chức vụ</th>
        <th>Số ĐT</th>
        <th>Thời gian tạo</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $staff)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $staff->name }}</td>
            <td>{{ \App\Staffs::ROLE[$staff->role] }}</td>
            <td>{{ $staff->phone }}</td>
            <td>{{ formatDate($staff->created_at) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
