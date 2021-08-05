Conexão de banco de dados alterar em Application\core\Database

Arquivo d 
 
Usuário e senha de acesso 
 *  Usuário: usuario
 * Senha: 123


Alterar em Application\helpers\Url o nome da pasta "teste_questor" para a que será adicionado os arquivos, ou remover no caso de http://localhost/home
```
$path = 'teste_questor/'; 
```
Usuário e senha de acesso
* Usuário: usuario
* Senha: 123


Api Exemplo:
```
http://localhost/teste_questor/api/anuncio/[id_do_anuncio]
Headers: Authorization: XerWtqew
```