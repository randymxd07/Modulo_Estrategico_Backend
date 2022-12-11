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
        <h3>Tu orden está lista, {{$sendOrder['fullname']}}</h3>

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th class="text-center">Cantidad</th>
                    <th class="text-end">Precio</th>
                    <th class="text-end">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sendOrder['order_details'] as $order)
                    <tr>
                        <td>{{$order['product_name']}}</td>
                        <td class="text-center">{{$order['quantity']}}</td>
                        <td class="text-end">{{$order['product_price']}}</td>
                        <td class="text-end">{{$order['quantity'] * (int)$order['product_price']}}.00</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h3>Muchas gracias por preferirnos 🙏</h3>

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
