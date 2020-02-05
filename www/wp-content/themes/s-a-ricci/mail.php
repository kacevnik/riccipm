<?php

$recepient = "info@riccipm.ru";
$siteName = "S.A.Ricci PM";
$from = 'noreply@riccipm.ru';
$headers = "From: $from\r\nReply-to:$from\r\nContent-type:text/html;charset=utf-8\r\n";

$name = trim($_POST["name"]);
$phone = trim($_POST["phone"]);
$email = trim($_POST["email"]);
$message = "Поступил  запрос  на  консультацию от пользователя: $name \n Телефон: $phone \n Email: $email";

$pagetitle = "Заказ консультации на сайте \"$siteName\"";
mail($recepient, $pagetitle, $message, $headers);

?>
