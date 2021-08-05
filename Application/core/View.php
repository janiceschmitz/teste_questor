<?php


namespace Application\core;


use Application\helpers\Url;
use Application\helpers\Form;

class View
{

    protected $url;
    protected $form;
    protected $title;

    function __construct($title)
    {
        $this->url = new Url();
        $this->form = new Form();
        $this->title = $title;
    }

    /**
     * Este método é responsável por chamar uuma determinada view (página).
     *
     * @param  string  $view   A view que será chamada (ou requerida)
     * @param  array   $data   São os dados que serão exibido na view
     */
    public function render(string $view, $data = [], $layout = 'default')
    {
        require '../Application/views/layout/' . $layout . '/header.php';
        require '../Application/views/' . $view . '.php';
        require '../Application/views/layout/' . $layout . '/footer.php';
    }
}