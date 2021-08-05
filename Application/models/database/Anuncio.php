<?php

namespace Application\models\database;

use Application\core\Database;
use PDO;

class Anuncio extends Database
{

    protected $table_name = 'anuncios';

    public function getAnuncio($where = []){

        $conn = new Database();
        $result = $conn->executeQuery('
        SELECT '.$this->table_name.'.*, 
        modelos.descricao as modelo_desc,
         marcas.nome as marca_desc,
         tipo_combustiveis.descricao as combustivel,
         modelos.marca_id 
         FROM '.$this->table_name.'
        inner join modelos on modelos.id = '.$this->table_name.'.modelo_id
        inner join marcas on modelos.marca_id = marcas.id
        inner join tipo_combustiveis on tipo_combustiveis.id = '.$this->table_name.'.tipo_combustivel_id
        ', $where);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

}