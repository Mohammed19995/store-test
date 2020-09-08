<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title>Title</title>
</head>
<body>

<table border="1" cellpadding="5">
    <thead>
    <tr>

        <th>الاسم</th>
        <th>الايميل</th>
        <th>الاسم</th>
        <th>الايميل</th>

    </tr>
    </thead>


    <tbody>
    @foreach($users as $user)
        <tr>
            <td><img width="50" height="50" style="border-radius: 50%" src="{{$user->image}}"></td>
            <td>{{$user->email}}</td>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
        </tr>
    @endforeach
    </tbody>

</table>
</body>
</html>