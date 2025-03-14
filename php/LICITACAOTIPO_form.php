<?

include('../includes/session.php');
include('../includes/variaveisAmbiente.php');
include_once('../includes/dashboard/header.php');
include('../class/class.tab.php');

$tab = new Tab();

$tab->setTab('Tipo de Licitação', 'fa-solid fa-file', ' LICITACAOTIPO_viewDados.php');
$tab->setTab('Novo Tipo de Licitação', 'fas fa-plus', $_SERVER['PHP_SELF']);

$tab->printTab($_SERVER['PHP_SELF']);

?>

<link href="../assets/css/multi-select.css" rel="stylesheet" type="text/css">

<section class="content">

    <form method="post" action="<? echo $_SERVER['PHP_SELF']; ?>">

        <div class="card p-0">

            <div class="card-header border-bottom-1 mb-3 bg-light-2">

                <div class="text-center">
                    <h4>
                        <?= $auth->getApplicationDescription($_SERVER['PHP_SELF']) ?>
                    </h4>
                </div>

                <div class="row text-center">

                    <div class="col-12 col-sm-4 offset-sm-4">

                        <?
                        if (isset($add)) {
                            include "../class/class.valida.php";

                            $valida = new Valida($form_descricao, 'Descrição');
                            $valida->TamMinimo(1);
                            $erro .= $valida->PegaErros();
                        }


                        if (!$erro && isset($add)) {
                            $query->begin();

                            $query->insertTupla(
                                'licitacao_tipo_licitacao',
                                array(
                                    $form_descricao,
                                    $_user,
                                    $_ip,
                                    $_data,
                                    $_hora

                                )
                            );


                            $query->commit();
                        }

                        if ($erro)

                            echo callException($erro, 2);

                        ?>

                    </div>

                </div>

            </div>

            <div class="card-body pt-0">

                <div class="form-row">

                    <div class="form-group col-12 col-md-12">
                        <label for="form_descricao"><span class='text-danger'>*</span> Descrição:</label>
                        <input type="text" class="form-control" name="form_descricao" id="form_descricao" maxlength="100" value="<? if ($erro) echo $form_descricao; ?>">
                    </div>

                </div>

            </div>

            <div class="card-footer bg-light-2">
                <?
                $btns = array('clean', 'save');
                include('../includes/dashboard/footer_forms.php');
                getButtons($btns);
                ?>
            </div>

        </div>

    </form>

</section>
<?
include_once('../includes/dashboard/footer.php');
?>