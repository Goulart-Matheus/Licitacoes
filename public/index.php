<?
    
    require_once('../class/Layout.php');

    $layout = new Layout('CADSEC' , 'Cadastro de Secretarias' , 'Pelotas');

    echo $layout->getHeader();

    ?>

        <div class="row">
            <div class="col-6 bg-danger">
                Teste
            </div>
            <div class="col-6">
                <button class="btn btn-pelotas">Teste de Botão</button>
            </div>
        </div>

    <?

    echo $layout->getFooter();

?>