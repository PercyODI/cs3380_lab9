<?php
$SERVER = 'us-cdbr-azure-central-a.cloudapp.net';
$USER = 'bf7f0622e9427e';
$PASS = '720ad0bb';
$DATABASE = 'cs3380-pah9qd';

$mylink = new PDO("mysql:host=$SERVER;dbname=$DATABASE", $USER, $PASS);
$mylink->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

session_start();
?>