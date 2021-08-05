<h4>Encontrado <?= count($data['data'])?> resultados para a palavra: <?= $data['search'] ?></h4>
<table class="table table-striped mt-5">
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
    if ($data['data']) {
        foreach ($data['data'] as $dat) { ?>
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
                    <a rel="crud-ajax" title="Editar anuncio" rel-type="form" href="<?= $this->url->getUrl() ?>anuncio/edit/<?= $dat['id'] ?>/ajax-layout"> <i class="fas fa-edit"></i></a>
                    <a rel="crud-ajax" title="Dados da anuncio " href="<?= $this->url->getUrl() ?>anuncio/show/<?= $dat['id'] ?>/ajax-layout"> <i class="fas fa-eye"></i></a>
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