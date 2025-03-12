$(document).ready(function(){
 
    if($(".select2_ano_letivo").length > 0)
    {
        $(".select2_ano_letivo").attr('data-live-search','true');
        $(".select2_ano_letivo").select2({width: '100%'});
    }

    if($(".select2_tipo_ensino").length > 0)
    {
        $(".select2_tipo_ensino").attr('data-live-search','true');
        $(".select2_tipo_ensino").select2({width: '100%'});
    }

    if($(".select2_serie").length > 0)
    {
        $(".select2_serie").attr('data-live-search','true');
        $(".select2_serie").select2({width: '100%'});
    }

    if($(".select2_turma").length > 0)
    {
        $(".select2_turma").attr('data-live-search','true');
        $(".select2_turma").select2({width: '100%'});
    }

    if($(".select2_situacao_turma").length > 0)
    {
        $(".select2_situacao_turma").attr('data-live-search','true');
        $(".select2_situacao_turma").select2({width: '100%'});
    }

});

function validate_form_ajax(form) {

    var isValid = true;
    
    if (form.checkValidity() === false) 
    {
        isValid = false;
    }

    form.classList.add('was-validated');

    return isValid;

};


(function() {

    'use strict';

    window.addEventListener('load', function() {

        // Pega todos os formulários que nós queremos aplicar estilos de validação Bootstrap personalizados.
        var forms = document.getElementsByClassName('needs-validation');

        // Faz um loop neles e evita o envio
        var validation = Array.prototype.filter.call(forms, function(form) {

            form.addEventListener('submit', function(event) {

                if(form.classList.contains('not-submit') === true)
                {
                    event.preventDefault();
                    event.stopPropagation();
                }

                if (form.checkValidity() === false) 
                {
                    event.preventDefault();
                    event.stopPropagation();

                    form.classList.remove('form-success');
                    form.classList.add('form-error');

                }
                else
                {
                    form.classList.remove('form-error');
                    form.classList.add('form-success');
                }

                form.classList.add('was-validated');

            }, false);

        });

    }, false);

})();