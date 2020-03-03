<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
    <style>
        body {
            margin: 50px;
        }
    </style>
    <title>Your order</title>
</head>
<body>

    <?php


    //phpinfo();

    $valid_order = true;

    /* ========================== BASE PRICE ========================== */

    $base_price = 0;
    $destination = $_POST['destination'];
    switch ($destination) {
        case 'berlin':
            $base_price = 2000;
            break;
        case 'london':
            $base_price = 5000;
            break;
        case 'newyork':
            $base_price = 20000;
            break;
        case 'brno':
            $base_price = 1000;
            break;
    }

    /* ========================== AGE ========================== */

    $birthDate = $_POST['birthDate'];
    $from = new DateTime($birthDate);
    $to = new DateTime('today');
    $age = $from->diff($to)->y;

    $age_discount = 0; // in %

    // Tady je ta chyba. Pokud maj mimino pod jeden rok tak jim to rekne ze je to nevalidni objednavka
    if ($age <= 0 || $age >= 150)
        $valid_order = false;

    if ($age > 0 && $age < 2)
        $age_discount = 100;

    if ($age >= 2 && $age <= 6)
        $age_discount = 50;

    if ($age >= 15 && $age <= 26)
        $age_discount = 10;

    /* ========================== discount ========================== */
    $discount_type = $_POST['discount']; // in %
    $discount = 0;

    switch ($discount_type) {
        case 'student':
            $discount = 25;
            break;
        case 'handicapped':
            $discount = 30;
            break;
        case 'coupon':
            $discount = 10;
            break;
    }

    $total_discount = $discount + $age_discount;
    $total_price = $base_price / 100 * (100 - $total_discount);

    if (!$valid_order) echo "<p><b class='alert'>This order in invalid.</b></p>";
    else {
        echo "<p><b>Base price:</b> $base_price,-</p>";
        echo "<p><b>Age discount:</b> $age_discount% (base on your age of $age years)</p>";
        echo "<p><b>Special discount:</b> $discount% (the $discount_type type)";
        echo "<p><h2>Total price: $total_price</h2></p>";
    }


    ?>

<p><a href="index.html">go back</a></p>

</body>
</html>