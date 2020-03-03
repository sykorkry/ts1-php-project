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
    <title>TS1 - Results</title>
</head>
<body>

<?php

$valid_order = true;

/* ========================== FORM VALIDATION ========================== */

if (!isset($_POST['firstName'])) {
    echo "<p>Please fill in your first fame.</p>";
    $valid_order = false;
} else $firstName = $_POST['firstName'];

if (!isset($_POST['lastName'])) {
    echo "<p>Please fill in your last name.</p>";
    $valid_order = false;
} else $lastName = $_POST['lastName'];

if (!isset($_POST['email']) || $_POST['email']=="") {
    echo "<p>Please fill in your email.</p>";
    $valid_order = false;
} else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    echo "<p>Your email format is invalid.</p>";
    $valid_order = false;
} else $email = $_POST['email'];

if (!isset($_POST['birthDate'])) {
    echo "<p>Please fill in your birth date.</p>";
    $valid_order = false;
} else $birthDate = $_POST['birthDate'];

if (!isset($_POST['destination'])) {
    echo "<p>Please select a destination.</p>";
    $valid_order = false;
} else $destination = $_POST['destination'];

if (!isset($_POST['discount'])) {
    echo "<p>Please select a discount type.</p>";
    $valid_order = false;
} else $discount_type = $_POST['discount']; // in %

if (!isset($_POST['payment'])) {
    echo "<p>Please choose a payment method.</p>";
    $valid_order = false;
} else $payment = $_POST['payment'];

/* ========================== BASE PRICE ========================== */

$base_price = 0;
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
    default:
        $valid_order = false;
        echo "<p>Your destination \"$destination\" is invalid.</p>";
}

/* ========================== AGE ========================== */

// Tady je ta "chyba". Pokud maj mimino pod jeden rok tak jim to rekne ze je to nevalidni objednavka
$from = new DateTime($birthDate);
$to = new DateTime('today');
$age = $from->diff($to)->y;
$age_discount = 0; // in %
if ($age <= 0 || $age >= 100) {
    $valid_order = false;
    echo "<p>Your age ($age) is invalid.</p>";
}
if ($age > 0 && $age < 2)
    $age_discount = 100;
if ($age >= 2 && $age <= 6)
    $age_discount = 50;
if ($age >= 15 && $age <= 26)
    $age_discount = 10;

/* ========================== DISCOUNT ========================== */

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

/* ========================== CALCULATION ========================== */

$total_discount = $discount + $age_discount;
$total_price = $base_price / 100 * (100 - $total_discount);

if (!$valid_order) echo "<p><b>This order in invalid.</b></p>";
else {
    echo "<p><b>Base price:</b> $base_price,-</p>";
    echo "<p><b>Age discount:</b> $age_discount% (base on your age of $age years)</p>";
    echo "<p><b>Special discount:</b> $discount% (the $discount_type type)";
    echo "<p><h2>Total price: $total_price</h2></p>";
    echo "<p><i>Price calulation: <b>base price / 100 * ( 100 - ( discount + age discount ) )</b></i></p>";
}
?>

<p><a href="index.html">Go back.</a></p>

</body>
</html>