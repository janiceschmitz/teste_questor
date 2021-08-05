
<div class="d-flex text-muted pt-3">
</div>

<small class="d-block text-end mt-3">
    <a class="btn btn-info" href="<?= $this->url->getUrl() ?>marca/add/ajax-layout" rel="crud-ajax" rel-type="form" title="Adicionar marca"   onclick="return modalAjax($(this))">Adicionar <?= $this->title ?></a>
</small>

<table class="table table-striped">
    <thead>
    <tr>
        <th scope="col">ID</th>
        <th scope="col">Descrição</th>
        <th>Ações</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if ($data['marcas']) {
        foreach ($data['marcas'] as $dat) { ?>
            <tr>
                <td><?= $dat['id'] ?></td>
                <td><?= $dat['nome'] ?></td>
                <td>
                    <a rel="crud-ajax" title="Editar marca <?= $dat['nome'] ?>" rel-type="form" href="<?= $this->url->getUrl() ?>marca/edit/<?= $dat['id'] ?>/ajax-layout" onclick="return modalAjax($(this))"> <i class="fas fa-edit"></i></a>
                    <a rel="crud-ajax" title="Dados da marca <?= $dat['nome'] ?>" href="<?= $this->url->getUrl() ?>marca/show/<?= $dat['id'] ?>/ajax-layout"  onclick="return modalAjax($(this))"> <i class="fas fa-eye"></i></a>
                    <a rel="delete-ajax" title="Tem certeza que deseja excluir a marca <?= $dat['nome'] ?>?" href="<?= $this->url->getUrl() ?>marca/delete/<?= $dat['id'] ?>" onclick="return modalAjax($(this))"> <i class="fas fa-trash-alt"></i></a>

                </td>
            </tr>
            <?php
        }
    } else {
        ?>
        <tr>
            <td colspan="3">Nada encontrado</td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>
