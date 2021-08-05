<?php

use Application\core\Controller;
use Application\core\Database;
use Application\core\View;
use Application\models\database\Marca;

class MarcaController extends Controller
{

    protected $title = 'Marca';


    public function index()
    {
        $marcas = $this->model('Marca');
        $data = $marcas->findAll();

        $view = new View($this->title);
        $view->render('marca/index', ['marcas' => $data]);
    }

    public function show($id = null, $layout = 'default')
    {
        if (is_numeric($id)) {
            $marca = $this->model('Marca');
            $data = $marca->findById($id);

            $view = new View($this->title);
            $view->render('marca/show', ['marca' => $data], $layout);
        } else {
            $this->pageNotFound();
        }
    }

    public function add($layout = 'default')
    {

        if ($_POST) {
            if (empty($_POST['nome'])) {
                return $this->jsonResponse([
                    'success' => false,
                    'alert' => [
                        'type' => self::ERROR,
                        'message' => "Necessário informar a descrição da marca.",
                        'title' => 'Campos obrigatórios'
                    ]
                ]);
            }


            try {
                $marca = new Marca();
                $marca->setData(['nome' => $_POST['nome']]);
                $marca->save();
            } catch (Exception $e) {
                return $this->jsonResponse([
                    'success' => false,
                    'alert' => [
                        'type' => self::ERROR,
                        'message' => "Erro ao inserir marca",
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

        $view = new View($this->title);
        $view->render('marca/add', [], $layout);

    }

    public function edit($id = null, $layout = 'default')
    {
        if (is_numeric($id)) {

            if ($_POST) {
                if (empty($_POST['nome'])) {
                    return $this->jsonResponse([
                        'success' => false,
                        'alert' => [
                            'type' => self::WARNING,
                            'message' => "Necessário informar a descrição da marca.",
                            'title' => 'Campos obrigatórios'
                        ]
                    ]);
                }
                try {

                    $marca = new Marca();
                    $marca->setData(['nome' => $_POST['nome']]);

                    $marca->update(['id' => $id]);
                } catch (Exception $e) {
                    return $this->jsonResponse([
                        'success' => false,
                        'alert' => [
                            'message' => "Erro ao editar a marca",
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

            $marca = $this->model('Marca');
            $data = $marca->findById($id);

            $view = new View($this->title);
            $view->render('marca/edit', ['marca' => $data, 'modal' => 'edit-marca'], $layout);
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
                    modelos.marca_id,
                    anuncios.modelo_id,
                    anuncios.id  as anuncio_id
                    FROM marcas 
                    LEFT JOIN modelos ON modelos.marca_id = modelos.id
                    LEFT JOIN anuncios ON anuncios.modelo_id = modelos.id
                    WHERE marcas.id = :marca_id";

                $result = $conn->executeQuery($sql, array(
                    ':marca_id' => $id
                ));
                $data = $result->fetchAll(PDO::FETCH_ASSOC);

                if ($data) {
                    foreach ($data as $dat) {
                        if ($dat['anuncio_id']) {
                            $anuncio = new \Application\models\database\Anuncio();
                            $anuncio->delete(['id' => $dat['anuncio_id']]);
                        }
                        if ($dat['modelo_id']) {
                            $modelo = new \Application\models\database\Modelo();
                            $modelo->delete(['id' => $dat['modelo_id']]);
                        }

                        $marca = new \Application\models\database\Marca();
                        $marca->delete(['id' => $dat['marca_id']]);
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