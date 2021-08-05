<?php

namespace Application\core;

use Application\helpers\Helpers;

/**
 * Esta classe é responsável por instanciar um model e chamar a view correta
 * passando os dados que serão usados.
 */
class Controller
{


    const WARNING = 2,
        SUCCESS = 1,
        ERROR = 3;

    /**
     * Este método é responsável por chamar uma determinada view (página).
     *
     * @param string $model É o model que será instanciado para usar em uma view, seja seus métodos ou atributos
     */
    public function model($model)
    {
        require '../Application/models/database/' . $model . '.php';
        $classe = 'Application\\models\\database\\' . $model;
        return new $classe();

    }


    /**
     * Este método é herdado para todas as classes filhas que o chamaram quando
     * o método ou classe informada pelo usuário nçao forem encontrados.
     */
    public function pageNotFound()
    {
        $view = new View('Erro');
        $view->render('erro404');
    }

    public function jsonResponse($json){
         die(json_encode($json));
    }
}