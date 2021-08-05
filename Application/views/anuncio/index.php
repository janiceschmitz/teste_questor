
<div class="d-flex text-muted pt-3">
</div>

<small class="d-block text-end mt-3">
    <a class="btn btn-info" href="<?= $this->url->getUrl() ?>anuncio/add/ajax-layout" rel="crud-ajax" rel-type="form" title="Adicionar modelo" onclick="return modalAjax($(this))" >Adicionar <?= $this->title ?></a>
</small>

<table class="table table-striped">
    <thead>
    <tr>
        <th scope="col">ID</th>
        <th scope="col">Modelo</th>
        <th scope="col">Marca</th>
        <th scope="col">Ano</th>
        <th scope="col">Cor</th>
        <th scope="col">Tipo Combustível</th>
        <th scope="col">Valor Compra</th>
        <th scope="col">Valor Venda</th>
        <th scope="col">Data Venda</th>
        <th>Ações</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if ($data['anuncios']) {
        foreach ($data['anuncios'] as $dat) { ?>
            <tr>
                <td><?= $dat['id'] ?></td>
                <td><?= $dat['modelo_desc'] ?></td>
                <td><?= $dat['marca_desc'] ?></td>
                <td><?= $dat['ano'] ?></td>
                <td><?= $dat['cor'] ?></td>
                <td><?= $dat['combustivel'] ?></td>
                <td><?= $dat['valor_compra'] ?></td>
                <td><?= $dat['valor_venda'] ?></td>
                <td><?= $dat['data_venda'] ?></td>
                <td>
                    <a rel="crud-ajax" title="Editar anuncio" rel-type="form" href="<?= $this->url->getUrl() ?>anuncio/edit/<?= $dat['id'] ?>/ajax-layout" onclick="return modalAjax($(this))"> <i class="fas fa-edit"></i></a>
                    <a rel="crud-ajax" title="Dados da anuncio " href="<?= $this->url->getUrl() ?>anuncio/show/<?= $dat['id'] ?>/ajax-layout" onclick="return modalAjax($(this))"> <i class="fas fa-eye"></i></a>
                    <a rel="delete-ajax" title="Tem certeza que deseja excluir o anúncio?" href="<?= $this->url->getUrl() ?>anuncio/delete/<?= $dat['id'] ?>" onclick="return modalAjax($(this))"> <i class="fas fa-trash-alt"></i></a>

                </td>
            </tr>
            <?php
        }
    } else {
        ?>
        <tr>
            <td colspan="10">Nada encontrado</td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>
