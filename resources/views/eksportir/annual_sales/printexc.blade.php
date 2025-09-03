<?php
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=miners.xls");
?>
<html>
    <head>

    </head>
    <body>
    <table border="1">
    <thead>
        <tr>
            <td>No</td>
            <td>Company</td>
            <td>Address</td>
            <td>Provinsi</td>
            <td>Email</td>
            <td>Verify Date</td>
        </tr>
    </thead>
    <tbody>
        @foreach($datapic as $key => $val)
        <tr>
            <td><center>{{ $key+1 }}</center></td>
            <td>{{ $val->company }},{{nmbadanusaha}}</td>
            <td>{{$val->addres}}</td>
            <td>{{ $val->province_en}}</td>
            <td>{{$val->verified_at}}</td>
        </tr>
        @endforeach
    </tbody>
</table>



    </body>
</html>