<?php session_start();
$_SESSION["token"] = $token=bin2hex(openssl_random_pseudo_bytes(10));
