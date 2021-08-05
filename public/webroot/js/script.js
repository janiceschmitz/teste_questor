var modalSom = 0;
$(document).ready(function () {

    //Busca
    $('.form-search').submit(function () {
        showLoad();
        var ele = $(this);
        $.ajax({
            url: ele.attr('action'),
            data: ele.serialize(),
            type: 'post',
            success: function (result) {
                hideLoad();
                $('.title-page').html('Busca');
                $('.bg-body').html(result)
            }
        });
        return false;
    })

    //adiciona as mascaras
    mascaras();

})

function alertShow(data) {
    var classType = ' alert-success';
    if (data.alert['type'] == 2) {
        classType = 'warning';
    }
    if (data.alert['type'] == 3) {
        classType = 'dark';
    }
    var htm = '<div style="display: none" class="popup message alert alert-' + classType + '">' +
        '<b>' + data.alert['title'] + '</b> <br />' +
        data.alert['message'] +
        '</div>';

    $('body').append(htm);
    $('.popup.message').fadeOut(10);
    $('.popup.message').fadeIn(300);
    setTimeout(function () {
        $('.popup.message').fadeOut(300, function () {
            $(this).remove();
        });
    }, 5000);

}

function mascaras() {
    $('.date').mask('99/99/9999');
    $('.money').mask('#.##0,00', {reverse: true});
}

function showLoad() {
    var load = $('.load');
    load.fadeIn(300);

}


function hideLoad() {
    var load = $('.load');
    load.fadeOut(200);
}

function modalAjax(ele){

    //se for um lins para deletar
    if (ele.attr('rel') == 'delete-ajax') {

        bootbox.confirm({
            message: ele.attr('title'),
            closeButton: false,
            buttons: {
                confirm: {
                    label: 'Sim'
                },
                cancel: {
                    label: 'Não'
                }
            },
            callback: function (result) {
                if (result) {
                    showLoad();
                    $.ajax({
                        url: ele.attr('href'),
                        dataType: 'json',
                        success: function (result) {
                            alertShow(result);
                            hideLoad();
                            setTimeout(function () {
                                location.reload();
                            }, 600)

                        }
                    });
                }
            }
        });
    }

    //é um link de ajax?
    if (ele.attr('rel') == 'crud-ajax') {
        showLoad();
        //auto incremeta para que não tenha mais divs com mesmo id
        modalSom++;
        $.ajax({
            url: ele.attr('href'),
            success: function (data) {
                hideLoad();

                //monta o html do modal
                var modal = 'myModal' + modalSom;
                var htm = '<div class="modal  modal-ajax" tabindex="-1" id="' + modal + '">' +
                    '  <div class="modal-dialog modal-lg">' +
                    '    <div class="modal-content">' +
                    '<div class="modal-header"> <h5 class="modal-title">' + ele.attr('title') + '</h5>' +
                    '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>' +
                    '</div>';
                htm += data;
                htm += '<div class="modal-footer">' +
                    '        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>';
                if (ele.attr('rel-type') == 'form') {

                    htm += ' <button type="button" class="btn btn-success btn-save">Salvar</button>';
                }
                htm += '      </div>' +
                    '    </div>' +
                    '  </div>' +
                    '</div>'

                //insere o modal no body
                $('body').append(htm);

                //monta as mascaras
                mascaras();

                //abre o modal
                var myModal = new bootstrap.Modal(document.getElementById(modal));
                myModal.show();

                //quando clicado no botão save
                $('#' + modal).find('.btn-save').click(function () {

                    //se for do tipo form
                    if (ele.attr('rel-type') == 'form') {
                        var form = $('#' + modal).find('form');

                        //verifica campos obrigatórios
                        var valid = true;
                        form.find('select, input, textarea').each(function () {
                            if ($(this).attr('required')) {
                                if ($(this).val() == '') {
                                    alert('Verifique os campos obrigatórios!');
                                    valid = false;
                                    return false;
                                }
                            }
                        });
                        //vlaido?
                        if (valid) {
                            showLoad();

                            //executa o ajax enviando os dados do formulário
                            $.ajax({
                                url: ele.attr('href'),
                                data: form.serialize(),
                                type: form.attr('method'),
                                dataType: 'json',
                                success: function (result) {
                                    alertShow(result);
                                    hideLoad();
                                    if (result.success) {
                                        myModal.hide();
                                        //atualiza a página
                                        $("#content").load(location.href + " #content>*", "");
                                    }
                                }
                            });
                        }
                    }
                });

                document.getElementById(modal).addEventListener('hide.bs.modal', function (event) {
                    $('#' + modal).remove();
                });

            }
        })

    }
    return false;

}