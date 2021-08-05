<?php


namespace Application\helpers;


class Url
{

    private  $path = 'teste_questor/';

    function getUrl(){
        return "{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['HTTP_HOST']}/{$this->path}";
    }

    function getBaseUrl(){
        return "{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['HTTP_HOST']}/{$this->path}public/";
    }
}