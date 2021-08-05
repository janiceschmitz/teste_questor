<form method="post">
    <div class="mb-3">
        <label>Descrição do modelo</label>
        <input type="text" name="descricao" value="<?= $data['modelo']['descricao'] ?>" class="form-control"  required>
    </div>
    <div class="mb-3">
        <label>Marca</label>
        <select name="marca" class="form-control">
            <option>Selecione uma marca</option>
            <?php foreach ($data['marcas'] as $marca){?>
                <option value="<?= $marca['id'] ?>" <?php echo ($marca['id'] == $data['modelo']['marca_id']) ? 'selected' : ''?>><?= $marca['nome'] ?></option>
            <?php } ?>
        </select>

    </div>
</form>