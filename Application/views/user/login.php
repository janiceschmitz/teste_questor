
<div class="container-fluid text-center">
    <div class="row justify-content-md-center">
        <div class="col-6">
            <form class="form-signin" method="POST" action="<?= $this->url->getUrl() ?>user/login">
                <i class="fas fa-car fa-10x main-car"></i>
                <h1 class="h3 mb-3 font-weight-normal">Login</h1>

                <?php
                if(isset($data['mensagem_error'])){
                    ?>
                    <div class="alert alert-danger m-2 mt-3">
                        <?= $data['mensagem_error'] ?>
                    </div>
                    <?php
                }

                ?>

                <div class="mb-3">
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="fas fa-user"></i></span>
                        <input type="text" name="login" class="form-control" placeholder="Usuário" required
                               autofocus>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="fas fa-unlock-alt"></i></span>
                        <input type="password" name="senha" class="form-control" placeholder="Senha" required>
                    </div>
                </div>
                <button class="btn btn-lg btn-primary btn-block" type="submit">Acessar</button>
            </form>

        </div>
    </div>
</div>