<?php

namespace Application\helpers;

class Form extends Url
{


    private  $linkStyle;
    private  $styles;


    function styles(){
        return $this->styles;
    }

    function addStyle($link){
        $this->linkStyle[] = $link;
        $this->mountStyle();

    }

    function mountStyle(){
        foreach ($this->linkStyle as $style){
            $this->styles .=  "<link rel='stylesheet' href='{$style}' />";
        }
    }

    function defaultStyle(){
        $this->linkStyle = [
            "{$this->getBaseUrl()}/webroot/bootstrap/css/bootstrap.min.css",
        ] ;
        $this->mountStyle();
    }

}