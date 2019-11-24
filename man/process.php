<?php
// INIT + RUN SETTINGS
set_time_limit(0);
$each = 5;
$pause = 1;

// DATABASE SETTINGS
define('DB_HOST', 'localhost');
define('DB_NAME', 'man');
define('DB_CHARSET', 'utf8');
define('DB_USER', 'man');
define('DB_PASSWORD', 'man');

// LOAD LIBRARY + EMAIL TEMPLATE FROM FILE
require __DIR__ . DIRECTORY_SEPARATOR . "newsletter.php";
$news = new Newsletter();
$template = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . "template.html");

// EMAIL SETTINGS
$subject = "[STORE] Crazy sales";
$headers = "From: abc@xyz.com" . PHP_EOL;
$headers .= "Reply-To: abc@xyz.com" . PHP_EOL;
$headers .= "MIME-Version: 1.0" . PHP_EOL;
$headers .= "Content-Type: text/html; charset=ISO-8859-1" . PHP_EOL;
$news->prime($headers, $subject);
unset($subject); unset($headers);

// NOW TO SEND THE EMAIL - BATCH BY BATCH
$all = $news->count();
for ($i=0; $i<$all; $i+=$each) {
	$subscribers = $news->get($i,$each);
	foreach ($subscribers as $sub) {
		$msg = str_replace("[NAME]", $sub['name'], $template);
		$news->send($sub['email'], $msg);
	}
	sleep($pause);
}
?>