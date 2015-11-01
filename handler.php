<?php
// куда отправлять почтовое сообщение
$to  = 'tigramypost@gmail.com' . ', '; // обратите внимание на запятую
$to .= 'scrobot91@gmail.com';


$message = '';
$error = true;
$url = 'order.html';

if(isset($_POST['form_submit'])) {
	$name = (isset($_POST['form_name']))? $_POST['form_name']: '';
	$mail = (isset($_POST['form_mail']))? $_POST['form_mail']: '';
	$tel = (isset($_POST['form_tel']))? $_POST['form_tel']: '';
	$address = (isset($_POST['form_address']))? $_POST['form_address']: '';
	$text = (isset($_POST['order_text']))? $_POST['order_text']: '';

	if($name == '' || $mail == '' || $tel == '' || $address == '' || $text == '') 
		$message = 'Ошибка заполнения формы. Заполните все поля формы';
	else {
		$post_message = '<h2>Заказ на товары</h2>'.
			'Фамилия, Имя: <b>'.$name.'</b>'.
			'<br>Электропочта: '.$mail.'<br>Телефон: '.$tel.
			'<br>Адрес: '.$address.'<br><br>'.
			'<table border="1" cellspacing="0" >'.$text.'</table>';
			// строка сообщения не должна быть более 70 символов
			
		$post_message = wordwrap(stripslashes($post_message), 70);
		
		$subject ='Заказ на товары';
			
		$headers = "From: ".$mail."\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=utf-8\r\n";

		if(mail($to, $subject, $post_message, $headers)) {
			$message = "Ваш заказ принят";
			$error = false;
			$url = 'index.html';
		}
		else
			$message = 'Ошибка отправки почты. Попробуйте, пожалуйста позднее';
	}
}
?>
<!doctype html>
<meta charset="utf-8">
<title>Заказ на товары</title>
<META HTTP-EQUIV="Refresh" CONTENT="5; URL=<?php echo $url ?>"> 

<style>
body {margin:0}
.wrapper {
	position:absolute;
	top:0;
	left:0;
	bottom:0;
	right:0;
	background:rgba(0,0,0,0.8);
}
.message {
	width:600px;
	margin:50px auto;
	font-family:Arial, Helvetica, sans-serif;
	text-align:center;
	background:#eee;
	border:solid 2px #009933;
	border-radius:5px;
	padding:20px;
}
.error {
	background:#FFFF66;
	color:red;
	border-color:red;
}
</style>

<div class="wrapper">
	<div class="message <?php if($error) echo 'error' ?>">
		<?php echo $message ?>
		<p><a href="index.html">На главную</a><br>
			<a href="order.html">Заказать еще</a></p>
	</div>
</div>