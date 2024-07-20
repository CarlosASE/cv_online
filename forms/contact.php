<?php

$receiving_email_address = 'carlos_ase@outlook.com';

if (file_exists($php_email_form = '../assets/vendor/php-email-form/php-email-form.php')) {
    include($php_email_form);
} else {
    die('Unable to load the "PHP Email Form" Library!');
}

// Validación y sanitización de los datos del formulario
$name = htmlspecialchars(strip_tags(trim($_POST['name'])));
$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
$subject = htmlspecialchars(strip_tags(trim($_POST['subject'])));
$message = htmlspecialchars(strip_tags(trim($_POST['message'])));

if (!$email) {
    die('Invalid email address!');
}

$contact = new PHP_Email_Form;
$contact->ajax = true;

$contact->to = $receiving_email_address;
$contact->from_name = $name;
$contact->from_email = $email;
$contact->subject = $subject;

// Configuración para el envío de correos mediante SMTP (opcional)
/*
$contact->smtp = array(
    'host' => 'example.com',
    'username' => 'example',
    'password' => 'pass',
    'port' => '587'
);
*/

$contact->add_message($name, 'From');
$contact->add_message($email, 'Email');
$contact->add_message($message, 'Message', 10);

echo $contact->send();

?>
