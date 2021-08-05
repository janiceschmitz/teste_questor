<?php

use Application\core\Controller;
use Application\core\Database;
use Application\core\View;
use Application\helpers\Url;


class UserController extends Controller
{


    /**
     * chama a view index.php da seguinte forma /user/index   ou somente   /user
     * e retorna para a view todos os usuários no banco de dados.
     */
    public function login()
    {
        $view = new View('Users');
        $data = [];

        if($_POST){

            if(empty($_POST['login']) || empty($_POST['senha'])){
                $data['mensagem_error'] = 'Campos obrigatórios';
            }

            $conn = new Database();
            $sql= 'SELECT * FROM users where login = :login and senha = :senha';

            $result = $conn->executeQuery($sql, [ ':login' => $_POST['login'], ':senha' =>sha1($_POST['senha'])]);
            $usuario = current($result->fetchAll(PDO::FETCH_ASSOC));


            if(!$usuario){
                $data['mensagem_error'] = 'Usuário não encontrado';
            } else {
                $_SESSION['users'] = $usuario;
                $url = new Url();
                header('Location: '.$url->getUrl().'home');
            }

        }

        $view->render('user/login', $data, 'login');
    }

    public function logout(){
       unset($_SESSION['users']);
        $url = new Url();
        header('Location: '.$url->getUrl().'user/login');
    }


}