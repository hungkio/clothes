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
</body>
</html>
