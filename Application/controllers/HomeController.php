<?php

use Application\core\Controller;
use Application\core\View;
use  Application\core\Database;

class HomeController extends Controller
{

    protected $title = 'Home';
    /*
    * chama a view index.php do  /home   ou somente   /
    */
    public function index()
    {
        $view =  new View($this->title);
        $view->render('home/index');
    }

    public function search(){

        if($_POST){

            $conn = new Database();
            $sql = "SELECT 
                    anuncios.*, 
                    modelos.descricao as modelo_desc,
                    marcas.nome as marca_desc,
                    tipo_combustiveis.descricao as combustivel 
                    FROM anuncios 
                    INNER JOIN modelos ON modelos.id = anuncios.modelo_id
                    INNER JOIN marcas ON marcas.id = modelos.marca_id
                    INNER JOIN tipo_combustiveis ON tipo_combustiveis.id = anuncios.tipo_combustivel_id
                    WHERE UPPER(modelos.descricao) LIKE UPPER(:like_modelo) 
                    OR UPPER(marcas.nome) LIKE UPPER(:like_marca)
                    OR UPPER(tipo_combustiveis.descricao) LIKE UPPER(:like_combustivel)";


            $result =  $conn->executeQuery($sql, array(
                ':like_modelo' => "%{$_POST['search']}%",
                ':like_marca' => "%{$_POST['search']}%",
                ':like_combustivel' => "%{$_POST['search']}%",
            ));

            $data = $result->fetchAll(PDO::FETCH_ASSOC);

            if ($data) {
                foreach ($data as $key => $dat) {
                    if (!empty($dat['data_venda'])) {
                        $data[$key]['data_venda'] = \DateTime::createFromFormat('Y-m-d', $dat['data_venda'])->format('d/m/Y');
                    }
                }
            }

            $view =  new View($this->title);
            $view->render('home/search',['data'=>$data, 'search'=>$_POST['search']],'ajax-layout');

        }

    }

}