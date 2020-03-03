<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
    <title>Your order</title>
</head>
<body>

<?php
var_dump($_POST);

$birthDate = $_POST['birthDate'];
$from = new DateTime($birthDate);
$to = new DateTime('today');
$age = $from->diff($to)->y;

echo "Age:" . $age;

?>

</body>
</html>