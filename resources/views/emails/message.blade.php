<html>
<head>
    <title>Ваш заказ принят!</title>
    <meta charset="utf8">
</head>
<body>
    <div>
        <h3>Ваш заказ принят</h3>
        <p>Спасибо за покупку !</p>
        <div><p>Номер вашего заказа: <span id="purchase_number"> {{$order_number}}</span></p></div>
        <div><p>Количество позиций товаров: <span id="position_number"> {{$total_qty}}</span></p></div>
        <div><p>Стоимость покупки: <span id="end_purchase_price"> {{$total_price}}<span> ₽</span></span></p></div>
        <div><p>Стоимость доставки: <span id="end_delivery_price"> {{$delivery_price}}<span> ₽</span></span></p></div>
        <div><p>Итого: <span id="end_total"> {{$delivery_price + $total_price}}<span> ₽</span></span></p></div>
    </div>
</body>
</html>