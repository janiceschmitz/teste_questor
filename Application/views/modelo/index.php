
<div class="d-flex text-muted pt-3">
</div>

<small class="d-block text-end mt-3">
    <a class="btn btn-info" href="<?= $this->url->getUrl() ?>modelo/add/ajax-layout" rel="crud-ajax" rel-type="form" title="Adicionar modelo"  onclick="return modalAjax($(this))" >Adicionar <?= $this->title ?></a>
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
    if ($data['modelos']) {
        foreach ($data['modelos'] as $dat) { ?>
            <tr>
                <td><?= $dat['id'] ?></td>
                <td><?= $dat['descricao'] ?></td>
                <td>
                    <a rel="crud-ajax" title="Editar modelo <?= $dat['descricao'] ?>" rel-type="form" href="<?= $this->url->getUrl() ?>modelo/edit/<?= $dat['id'] ?>/ajax-layout" onclick="return modalAjax($(this))"> <i class="fas fa-edit"></i></a>
                    <a rel="crud-ajax" title="Dados da modelo <?= $dat['descricao'] ?>" href="<?= $this->url->getUrl() ?>modelo/show/<?= $dat['id'] ?>/ajax-layout" onclick="return modalAjax($(this))"> <i class="fas fa-eye"></i></a>
                    <a rel="delete-ajax" title="Tem certeza que deseja excluir o modelo <?= $dat['descricao'] ?>?" href="<?= $this->url->getUrl() ?>modelo/delete/<?= $dat['id'] ?>" onclick="return modalAjax($(this))"> <i class="fas fa-trash-alt"></i></a>

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
