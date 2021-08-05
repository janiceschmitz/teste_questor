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
<body class="bg-light">
<div class="load">
    <div class="loader">Loading...</div>
</div>
<nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark" aria-label="Main navigation">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Sistema de veículos</a>
        <button class="navbar-toggler p-0 border-0" type="button" id="navbarSideCollapse"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="<?= $url->getUrl() ?>home">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $url->getUrl() ?>marca/index">Marca</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $url->getUrl() ?>modelo/index">Modelo</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $url->getUrl() ?>anuncio/index">Anúncio</a>
                </li>

            </ul>
            <form class="d-flex form-search" method="post" action="<?= $url->getUrl() ?>home/search">
                <input class="form-control me-2" type="text" name="search">
                <button class="btn btn-outline-success" type="submit">Buscar</button>
            </form>
        </div>
    </div>
</nav>
<main class="container">
    <div class="d-flex align-items-center p-3 my-3 text-white bg-purple rounded shadow-sm">
        <i class="fas fa-home m-1"></i>
        <div class="lh-1">
            <h1 class="h6 mb-0 text-white lh-1 title-page"><?= $this->title ?></h1>
        </div>
    </div>

    <div class="my-3 p-3 bg-body rounded shadow-sm" id="content">

