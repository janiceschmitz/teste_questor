<?php

use Application\core\Controller;
use Application\core\Database;
use Application\core\View;
use Application\models\database\Modelo;

class ModeloController extends Controller
{

    protected $title = 'Modelo';


    public function index()
    {
        $modelos = $this->model('Modelo');
        $data = $modelos->findAll();

        $view = new View($this->title);
        $view->render('modelo/index', ['modelos' => $data]);
    }

    public function show($id = null, $layout = 'default')
    {
        if (is_numeric($id)) {
            $modelo = $this->model('Modelo');
            $data = $modelo->findById($id);

            $marca = $this->model('Marca');
            $dataMarca = ($marca->findById($data['marca_id']));

            $data['marca'] = $dataMarca['nome'];

            $view = new View($this->title);
            $view->render('modelo/show', ['modelo' => $data], $layout);
        } else {
            $this->pageNotFound();
        }
    }

    public function add($layout = 'default')
    {

        if ($_POST) {
            if (empty($_POST['descricao']) || empty($_POST['marca'])) {
                return $this->jsonResponse([
                    'success' => false,
                    'alert' => [
                        'type' => self::ERROR,
                        'message' => "Necessário informar a descrição e a marca do modelo.",
                        'title' => 'Campos obrigatórios'
                    ]
                ]);
            }


            try {
                $modelo = new Modelo();
                $modelo->setData(['descricao' => $_POST['descricao'], 'marca_id' => $_POST['marca']]);
                $modelo->save();
            } catch (Exception $e) {
                return $this->jsonResponse([
                    'success' => false,
                    'alert' => [
                        'type' => self::ERROR,
                        'message' => "Erro ao inserir modelo",
                        'title' => 'Ocorreu algum erro'
                    ]
                ]);
            }
            return $this->jsonResponse([
                'success' => true,
                'alert' => [
                    'type' => self::SUCCESS,
                    'message' => "Dados inseridos com sucesso.",
                    'title' => 'Sucesso!'
                ]
            ]);

        }

        $marcas = $this->model('Marca');
        $data = $marcas->findAll();

        $view = new View($this->title);
        $view->render('modelo/add', ['marcas' => $data], $layout);

    }

    public function edit($id = null, $layout = 'default')
    {
        if (is_numeric($id)) {

            if ($_POST) {
                if (empty($_POST['descricao']) || empty($_POST['marca'])) {
                    return $this->jsonResponse([
                        'success' => false,
                        'alert' => [
                            'type' => self::WARNING,
                            'message' => "Necessário informar a descrição e a marca do modelo.",
                            'title' => 'Campos obrigatórios'
                        ]
                    ]);
                }
                try {

                    $modelo = new Modelo();
                    $modelo->setData(['descricao' => $_POST['descricao'], 'marca_id' => $_POST['marca']]);
                    $modelo->update(['id' => $id]);

                } catch (Exception $e) {
                    return $this->jsonResponse([
                        'success' => false,
                        'alert' => [
                            'message' => "Erro ao editar a modelo",
                            'title' => 'Ocorreu algum erro',
                            'type' => self::ERROR,

                        ]
                    ]);
                }

                return $this->jsonResponse([
                    'success' => true,
                    'alert' => [
                        'type' => self::SUCCESS,
                        'message' => "Dados inseridos com sucesso.",
                        'title' => 'Sucesso!'
                    ]
                ]);

            }

            $modelo = $this->model('Modelo');
            $data = $modelo->findById($id);

            $marcas = $this->model('Marca');
            $dataMarcas = $marcas->findAll();

            $view = new View($this->title);
            $view->render('modelo/edit', ['modelo' => $data, 'marcas' => $dataMarcas, 'modal' => 'edit-modelo'], $layout);
        } else {
            $this->pageNotFound();
        }
    }

    public function delete($id = null)
    {
        if (is_numeric($id)) {
            try {
                $conn = new Database();
                $sql = "SELECT 
                    anuncios.modelo_id,
                    anuncios.id  as anuncio_id
                    FROM modelos 
                    
                    LEFT JOIN anuncios ON anuncios.modelo_id = modelos.id
                    WHERE modelos.id = :modelo_id";

                $result = $conn->executeQuery($sql, array(
                    ':modelo_id' => $id
                ));
                $data = $result->fetchAll(PDO::FETCH_ASSOC);

                if ($data) {
                    foreach ($data as $dat) {
                        if ($dat['anuncio_id']) {
                            $anuncio = new \Application\models\database\Anuncio();
                            $anuncio->delete(['id' => $dat['anuncio_id']]);
                        }

                        $modelo = new \Application\models\database\Modelo();
                        $modelo->delete(['id' => $dat['modelo_id']]);

                    }


                }
            } catch (Exception $e) {
                return $this->jsonResponse([
                    'success' => false,
                    'alert' => [
                        'message' => "Erro ao deletar a marca",
                        'title' => 'Ocorreu algum erro',
                        'type' => self::ERROR,

                    ]
                ]);
            }

            return $this->jsonResponse([
                'success' => true,
                'alert' => [
                    'type' => self::SUCCESS,
                    'message' => "Dados excluídos com sucesso.",
                    'title' => 'Sucesso!'
                ]
            ]);
        }
        return $this->jsonResponse([
            'success' => false,
            'alert' => [
                'message' => "Campos inválidos!",
                'title' => 'Ocorreu algum erro',
                'type' => self::WARNING,

            ]
        ]);

    }


}