<?php
declare(strict_type=1);
require __DIR__ . '/vendor/autoload.php';

//ini_set('display_errors', '1');
//ini_set('display_startup_errors', '1');
//error_reporting(E_ALL);

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

//var_dump($_ENV);
//echo $_ENV['DB_HOST'];

$conn = mysqli_connect($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS'], $_ENV['DB_NAME']);
?>
