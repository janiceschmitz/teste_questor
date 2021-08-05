<?php

namespace Application\core;

use PDO;

class Database extends PDO
{
    // configuração do banco de dados
    private $DB_NAME = 'sistema_veiculos_2';
    private $DB_USER = 'root';
    private $DB_PASSWORD = '';
    private $DB_HOST = 'localhost';

    // armazena a conexão
    protected $conn;

    protected $data;
    protected $table_name;

    public function __construct()
    {
        // Quando essa classe é instanciada, é atribuido a variável $conn a conexão com o db
        $this->conn = new PDO("mysql:host={$this->DB_HOST};dbname={$this->DB_NAME}", $this->DB_USER, $this->DB_PASSWORD, []);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    }

    /**
     * Este método recebe um objeto com a query 'preparada' e atribui as chaves da query
     * seus respectivos valores.
     * @param PDOStatement $stmt Contém a query ja 'preparada'.
     * @param string $key É a mesma chave informada na query.
     * @param string $value Valor de uma determinada chave.
     */
    private function setParameters($stmt, $key, $value)
    {
        $stmt->bindParam($key, $value);
    }

    /**
     * A responsabilidade deste método é apenas percorrer o array de com os parâmetros
     * obtendo as chaves e os valores para fornecer tais dados para setParameters().
     * @param PDOStatement $stmt Contém a query ja 'preparada'.
     * @param array $parameters Array associativo contendo chave e valores para fornece a query
     */
    private function mountQuery($stmt, $parameters)
    {
        foreach ($parameters as $key => $value) {
            $this->setParameters($stmt, $key, $value);
        }
    }

    /**
     * Este método é responsável por receber a query e os parametros, preparar a query
     * para receber os valores dos parametros informados, chamar o método mountQuery,
     * executar a query e retornar para os métodos tratarem o resultado.
     * @param string $query Instrução SQL que será executada no banco de dados.
     * @param array $parameters Array associativo contendo as chaves informada na query e seus respectivos valores
     *
     * @return PDOStatement
     */
    public function executeQuery(string $query, array $parameters = [])
    {
        $stmt = $this->conn->prepare($query);
        $this->mountQuery($stmt, $parameters);
        $stmt->execute();
        return $stmt;
    }


    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * Insere os dados na tabela
     *
     * @param Model
     *
     * @return array dados
     */
    public function save()
    {

        $data = $this->data;
        if ($data) {
            $campos = [];
            $interrogacao = [];
            $value = [];
            foreach ($data as $key => $dat) {
                $campos[] = $key;
                $value[] = $dat;
                $interrogacao[] = '?';
            }
        }

        $sql = "INSERT INTO {$this->table_name} (".implode(',',$campos ). ") VALUES (".implode(',',$interrogacao ). ")";

        try {
            $this->conn->beginTransaction();
            $stmt= $this->conn->prepare($sql);
            $stmt->execute($value);
            $this->conn->commit();

        }catch (Exception $e){
            $this->conn->rollback();

        }

        return $stmt;

    }


    /**
     * Insere os dados na tabela
     *
     * @param Model
     *
     * @return array dados
     */
    public function update($where)
    {

        $data = $this->data;
        if ($data) {
            $campos = [];
            $value = [];
            foreach ($data as $key => $dat) {
                $campos[$key] = "{$key}=?";
                $value[] = $dat;
            }
        }

        if(!$where){
            throw new \Exception('Necessário passar uma condição', 301);
        }

        $valueWhere = [];
        $campoWhere = [];
        foreach ($where as $key => $dat) {
            $valueWhere[] = $dat;
            $campoWhere[] = "{$key}=?";
        }

        $sql = "UPDATE {$this->table_name}  SET ".implode(',',$campos ). " where ".implode(',',$campoWhere );
        $stmt= $this->conn->prepare($sql);

        try {
            $this->conn->beginTransaction();
            $stmt->execute(array_merge($value, $valueWhere));
            $this->conn->commit();
        }catch (Exception $e){
            $this->conn->rollback();
            throw $e;
        }

        return $stmt;

    }

    /**
     * Este método busca todos os usuários armazenados na base de dados
     *
     * @return   array
     */
    public function findAll()
    {
        $conn = new Database();
        $result = $conn->executeQuery('SELECT * FROM '.$this->table_name);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Este método busca um usuário armazenados na base de dados com um
     * determinado ID
     * @param    int     $id   Identificador único do usuário
     *
     * @return   array
     */
    public  function findById(int $id)
    {
        $conn = new Database();
        $result =  $conn->executeQuery('SELECT * FROM '.$this->table_name.' WHERE id = :ID LIMIT 1', array(
            ':ID' => $id
        ));

        return current($result->fetchAll(PDO::FETCH_ASSOC));
    }

    /**
     * Este método deleta os dados do banco
     *
     * @return   array
     */
    public function delete($where)
    {
        $conn = new Database();
        return $conn->executeQuery('DELETE FROM '.$this->table_name, $where);

    }

}