<?php
namespace Application\core;
use Application\models\Users;

/**
 * Esta classe é responsável por obter da URL o controller, método (ação) e os parâmetros
 * e verificar a existência dos mesmo.
 */
class App
{
    protected $controller = 'Admin';
    protected $method = 'index';
    protected $page404 = false;
    protected $params = [];
    // Método construtor
    public function __construct()
    {

        $access = false;
        $headers = apache_request_headers();
        if(isset($headers['Authorization'])){
            if($headers['Authorization'] == 'XerWtqew'){
                $access = true;
            }
        }
        //Não está logado? Força o login
        $user =new Users();
        $logged = $user->isLogged();
        if(!$logged && !$access){
            $this->controller = 'UserController';
            $this->method = 'login';
            $this->setController();
        } else {

            $URL_ARRAY = $this->parseUrl();
            $this->getControllerFromUrl($URL_ARRAY);
            $this->getMethodFromUrl($URL_ARRAY);
            $this->getParamsFromUrl($URL_ARRAY);
        }

        // chama um método de uma classe passando os parâmetros
        call_user_func_array([$this->controller, $this->method], $this->params);
    }
    /**
     * Este método pega as informações da URL (após o dominio do site) e retorna esses dados
     *
     * @return array
     */
    private function parseUrl()
    {
        $REQUEST_URI = explode('/', substr(filter_input(INPUT_SERVER, 'REQUEST_URI'), 1));
        return $REQUEST_URI;
    }
    /**
     * Este método verifica se o array informado possui dados na psoição 0 (controlador)
     * caso exista, verifica se existe um arquivo com aquele nome no diretório Application/controllers
     * e instancia um objeto contido no arquivo, caso contrário a variável $page404 recebe true.
     *
     * @param  array  $url   Array contendo informações ou não do controlador, método e parâmetros
     */
    private function getControllerFromUrl($url)
    {
        if ( !empty($url[1]) && isset($url[1]) ) {
            $controller = $url[1].'Controller';
            if ( file_exists('../Application/controllers/' . ucfirst($controller)  . '.php') ) {
                $this->controller = ucfirst($controller);
            } else {
                $this->page404 = true;
            }
        }

        $this->setController();
    }
    /**
     * Este método verifica se o array informado possui dados na psoição 1 (método)
     * caso exista, verifica se o método existe naquele determinado controlador
     * e atribui a variável $method da classe.
     *
     * @param  array  $url   Array contendo informações ou não do controlador, método e parâmetros
     */
    private function getMethodFromUrl($url)
    {
        if ( !empty($url[2]) && isset($url[2]) ) {
            if ( method_exists($this->controller, $url[2]) && !$this->page404) {
                $this->method = $url[2];
            } else {
                // caso a classe ou o método informado não exista, o método pageNotFound
                // do Controller é chamado.
                $this->method = 'pageNotFound';
            }
        }
    }
    /**
     * Este método verifica se o array informador possui a quantidade de elementos maior que 2
     * ($url[0] é o controller e $url[1] o método/ação a executar), caso seja, é atrbuido
     * a variável $params da classe um novo array  apartir da posição 2 do $url
     *
     * @param  array  $url   Array contendo informações ou não do controlador, método e parâmetros
     */
    private function getParamsFromUrl($url)
    {
        if (count($url) > 3) {
            $this->params = array_slice($url, 3);
        }
    }

    /**
     * Seta o controller
     */
    private function setController()
    {
        require '../Application/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller();
    }

}