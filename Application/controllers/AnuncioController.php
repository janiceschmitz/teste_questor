<?php

use Application\core\Controller;
use Application\core\View;
use Application\models\database\Anuncio;
use Application\core\Database;

class AnuncioController extends Controller
{

    protected $title = 'Anúncio';


    public function index()
    {
        $anuncios = new Anuncio();
        $data = $anuncios->getAnuncio();

        if ($data) {
            foreach ($data as $key => $dat) {
                if (!empty($dat['data_venda'])) {
                    $data[$key]['data_venda'] = \DateTime::createFromFormat('Y-m-d', $dat['data_venda'])->format('d/m/Y');
                }
            }
        }

        $view = new View($this->title);
        $view->render('anuncio/index', ['anuncios' => $data]);
    }

    public function show($id = null, $layout = 'default')
    {
        if (is_numeric($id)) {
            $anuncios = new Anuncio();
            $data = current($anuncios->getAnuncio(['id' => $id]));

            if (!empty($data['data_venda']))
                $data['data_venda'] = \DateTime::createFromFormat('Y-m-d', $data['data_venda'])->format('d/m/Y');

            $view = new View($this->title);
            $view->render('anuncio/show', ['anuncio' => $data], $layout);
        } else {
            $this->pageNotFound();
        }
    }

    public function add($layout = 'default')
    {

        if ($_POST) {

            if (!$this->camposObrigatorios($_POST)) {
                return $this->jsonResponse([
                    'success' => false,
                    'alert' => [
                        'type' => self::ERROR,
                        'message' => "Campos com (*) são obrigatórios. Favor verificar.",
                        'title' => 'Campos obrigatórios'
                    ]
                ]);
            }
            if (!$this->formatValores($_POST)) {
                return $this->jsonResponse([
                    'success' => false,
                    'alert' => [
                        'type' => self::WARNING,
                        'message' => "Data incorreta. Favor verifique!",
                        'title' => 'Ocorreu algum erro.'
                    ]
                ]);
            }
            try {
                $anuncio = new Anuncio();
                $anuncio->setData([
                    'modelo_id' => $_POST['modelo'],
                    'ano' => $_POST['ano'],
                    'cor' => $_POST['cor'],
                    'tipo_combustivel_id' => $_POST['tipo_combustivel'],
                    'valor_compra' => $_POST['valor_compra'],
                    'valor_venda' => $_POST['valor_venda'],
                    'data_venda' => (!empty($_POST['data_venda']) ? $_POST['data_venda'] : null)
                ]);
                $anuncio->save();
            } catch (Exception $e) {
                return $this->jsonResponse([
                    'success' => false,
                    'alert' => [
                        'type' => self::ERROR,
                        'message' => "Erro ao inserir anuncio. Erro :" . $e->getMessage(),
                        'title' => 'Ocorreu algum erro.'
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


        $modelos = $this->model('Modelo');
        $dataModelos = $modelos->findAll();

        $combustiveis = $this->model('TipoCombustivel');
        $dataCombustiveis = $combustiveis->findAll();

        $view = new View($this->title);
        $view->render('anuncio/add', [
            'modelos' => $dataModelos,
            'combustiveis' => $dataCombustiveis
        ], $layout);

    }

    public function edit($id = null, $layout = 'default')
    {
        if (is_numeric($id)) {

            if ($_POST) {
                if (!$this->camposObrigatorios($_POST)) {
                    return $this->jsonResponse([
                        'success' => false,
                        'alert' => [
                            'type' => self::ERROR,
                            'message' => "Campos com (*) são obrigatórios. Favor verificar.",
                            'title' => 'Campos obrigatórios'
                        ]
                    ]);
                }


                if (!$this->formatValores($_POST)) {
                    return $this->jsonResponse([
                        'success' => false,
                        'alert' => [
                            'type' => self::WARNING,
                            'message' => "Data incorreta. Favor verifique!",
                            'title' => 'Ocorreu algum erro.'
                        ]
                    ]);
                }


                try {

                    $anuncio = new Anuncio();
                    $anuncio->setData([
                        'modelo_id' => $_POST['modelo'],
                        'ano' => $_POST['ano'],
                        'cor' => $_POST['cor'],
                        'tipo_combustivel_id' => $_POST['tipo_combustivel'],
                        'valor_compra' => $_POST['valor_compra'],
                        'valor_venda' => $_POST['valor_venda'],
                        'data_venda' => (!empty($_POST['data_venda']) ? $_POST['data_venda'] : null)
                    ]);
                    $anuncio->update(['id' => $id]);

                } catch (Exception $e) {
                    return $this->jsonResponse([
                        'success' => false,
                        'alert' => [
                            'message' => "Erro ao editar a anuncio Erro :" . $e->getMessage(),
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

            $anuncios = new Anuncio();
            $data = current($anuncios->getAnuncio(['id' => $id]));

            if (!empty($data['data_venda'])) {
                $data['data_venda'] = \DateTime::createFromFormat('Y-m-d', $data['data_venda'])->format('d/m/Y');
            }

            $modelos = $this->model('Modelo');
            $dataModelos = $modelos->findAll();

            $combustiveis = $this->model('TipoCombustivel');
            $dataCombustiveis = $combustiveis->findAll();

            $view = new View($this->title);
            $view->render('anuncio/edit', [
                'anuncio' => $data,
                'modelos' => $dataModelos,
                'combustiveis' => $dataCombustiveis
            ], $layout);
        } else {
            $this->pageNotFound();
        }
    }

    function camposObrigatorios($campos)
    {
        if (empty($campos['modelo'])
            || empty($campos['ano'])
            || empty($campos['cor'])
            || empty($campos['tipo_combustivel'])
            || empty($campos['valor_compra'])
            || empty($campos['valor_venda'])
        ) {
            return false;
        }
        return true;
    }

    function formatValores(&$campos)
    {
        $campos['valor_compra'] = str_replace('.', '', $_POST['valor_compra']);
        $campos['valor_venda'] = str_replace('.', '', $_POST['valor_venda']);
        $campos['valor_compra'] = str_replace(',', '.', $_POST['valor_compra']);
        $campos['valor_venda'] = str_replace(',', '.', $_POST['valor_venda']);
        if (!empty($campos['data_venda'])) {
            if (!preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/[0-9]{4}$/", $campos['data_venda'])) {
                return false;
            }
            $campos['data_venda'] = \DateTime::createFromFormat('d/m/Y', $campos['data_venda'])->format('Y-m-d');
        }
        return true;

    }


    public function delete($id = null)
    {
        if (is_numeric($id)) {
            try {
                $anuncio = new Anuncio();
                $anuncio->delete(['id' => $id]);

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