<?php

use Application\helpers\Scripts;
use Application\helpers\Url;

$script = new Scripts();
$script->defaultStyle();

$url = new Url();


?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Sistema de Veículos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
    echo $script->styles();
    ?>
</head>
<body>
<div class="container-fluid">
    <div class="row">

