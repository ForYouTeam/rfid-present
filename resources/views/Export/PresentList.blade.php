<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Table</title>
    <style>
        .fit-content{
            width: fit-content !important
        }
    </style>
</head>
<body>

<table border="1">
    <thead>
        <tr>
            <th class="fit-content">ID</th>
            <th class="fit-content">Present Date</th>
            <th class="fit-content">Employee RFID</th>
            <th class="fit-content">Employee Name</th>
            <th class="fit-content">Description</th>
            <th class="fit-content">Hadir</th>
            <th class="fit-content">Bolos</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
            <tr>
                <td class="fit-content">{{ $item['id'] }}</td>
                <td class="fit-content">{{ $dateRange['start_date'] }} - {{ $dateRange['end_date'] }}</td>
                <td class="fit-content">{{ $item['employe_rfid'] }}</td>
                <td class="fit-content">{{ $item['employe_name'] }}</td>
                <td class="fit-content">{{ $item['description'] }}</td>
                <td class="fit-content">{{ count($item['summary']['hadir']) }}</td>
                <td class="fit-content">{{ count($item['summary']['bolos']) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>