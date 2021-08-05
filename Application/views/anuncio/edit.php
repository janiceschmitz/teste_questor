<form method="post">

    <div class="mb-3">
        <label>Modelo <span class="required">(*)</span></label>
        <select name="modelo" class="form-control">
            <option>Selecione um modelo</option>
            <?php foreach ($data['modelos'] as $dat) { ?>
                <option value="<?= $dat['id'] ?>"  <?= ($dat['id'] == $data['anuncio']['modelo_id']) ? 'selected' : '' ?>><?= $dat['descricao'] ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="row">

        <div class="mb-3 col">
            <label>Ano<span class="required">(*)</span></label>
            <input type="number" name="ano"  value="<?= $data['anuncio']['ano'] ?>" class="form-control" required>
        </div>
        <div class="mb-3 col">
            <label>Cor<span class="required">(*)</span></label>
            <input type="text" name="cor"  value="<?= $data['anuncio']['cor'] ?>" class="form-control" required>
        </div>
        <div class="mb-3 col">
            <label>Tipo de combustível<span class="required">(*)</span></label>
            <select name="tipo_combustivel" class="form-control" required>
                <option>Selecione um combustível</option>
                <?php foreach ($data['combustiveis'] as $dat) { ?>
                    <option value="<?= $dat['id'] ?>"  <?= ($dat['id'] == $data['anuncio']['tipo_combustivel_id']) ? 'selected' : '' ?>><?= $dat['descricao'] ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="mb-3 col">
            <label for="valor_compra">Valor Compra<span class="required">(*)</span></label>
            <input type="text" name="valor_compra" value="<?= $data['anuncio']['valor_compra'] ?>" id="valor_compra" placeholder="Valor Compra" class="form-control money" required>

        </div>
        <div class="mb-3 col">
            <label>Valor Venda<span class="required">(*)</span></label>
            <input type="text" name="valor_venda" value="<?= $data['anuncio']['valor_venda'] ?>"  class="form-control money" required>
        </div>
        <div class="mb-3 col">
            <label>Data Venda</label>
            <input type="text" name="data_venda"  value="<?= $data['anuncio']['data_venda'] ?>" class="form-control date" data-mask="00/00/0000">
        </div>
    </div>
</form>