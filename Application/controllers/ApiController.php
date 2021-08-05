<?php
use Application\core\Controller;
use Application\models\database\Anuncio;

class ApiController extends Controller
{

    public function anuncio($id){
        if(!isset($id) || !is_numeric($id) || empty($id)){
            return $this->jsonResponse([
                'success'=>0,
                'message'=>'Erro ao buscar o anúncio.'
            ]);
        }
        $anuncios = new Anuncio();
        $data = current($anuncios->getAnuncio(['id' => $id]));

        return $this->jsonResponse([
            'success'=>1,
            'data'=>$data
        ]);
    }
}