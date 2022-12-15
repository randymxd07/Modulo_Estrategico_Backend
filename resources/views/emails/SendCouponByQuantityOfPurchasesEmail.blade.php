<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Mail</title>
</head>
<body>

<section class="container col-sm-7 p-5">

    <h3>Aquí te va un regalo:</h3>

    <h4>{{$couponData['description']}}:</h4>
    <p class="lead">{{$couponData['coupon_id']}}</p>

    <h3>Muchas gracias por confiar en Daraguma Restaurant</h3>

</section>

<style>
    table {
        width: 100%;
        border: 1px solid #000;
    }
    th, td {
        width: 25%;
        text-align: left;
        vertical-align: top;
        border: 1px solid #000;
    }
</style>

</body>
</html>
