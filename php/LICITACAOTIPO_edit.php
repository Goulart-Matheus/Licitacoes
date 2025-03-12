<?

include('../includes/session.php');
include('../includes/variaveisAmbiente.php');
include_once('../includes/dashboard/header.php');
include('../class/class.tab.php');

$tab = new Tab();

$tab->setTab('Tipo de Licitação', 'fa-solid fa-file', 'LICITACAOTIPO_viewDados.php');
$tab->setTab('Editar Tipo de Licitação', 'fas fa-pencil-alt', $_SERVER['PHP_SELF'] . "?id_licitacaotipo=$id_licitacaotipo");

$tab->printTab($_SERVER['PHP_SELF'] . "?id_licitacaotipo=$id_licitacaotipo");


$query->exec("SELECT id_licitacao_tipo_licitacao, descricao 
                FROM public.licitacao_tipo_licitacao
               WHERE id_licitacao_tipo_licitacao = " . $id_licitacaotipo);

$query->proximo();

$id_licitacaotipo = $query->record[0];

?>

<link href="../assets/css/multi-select.css" rel="stylesheet" type="text/css">

<section class="content">

    <form method="post" action="<? echo $_SERVER['PHP_SELF'] . "?id_licitacaotipo=$$id_licitacaotipo"; ?>">

        <input type="hidden" name="id_licitacaotipo" value="<? echo $query->record[0]; ?>">

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
                        if (isset($edit)) {
                            include "../class/class.valida.php";

                            $valida = new Valida($form_descricao, 'Descrição');
                            $valida->TamMinimo(1);
                            $erro .= $valida->PegaErros();
                        }

                        if (!$erro && isset($edit)) {
                            $query->begin();

                            $itens =array(
                                    $form_descricao,
                                    $_user              , 
                                    $_ip                , 
                                    $_data              , 
                                    $_hora 
                            );

                            $where = array(0 => array('id_licitacao_tipo_licitacao', $id_licitacaotipo));
                            $query->updateTupla('licitacao_tipo_licitacao', $itens, $where);

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
                        <label for="form_descricao"><span class='text-danger'>*</span> Descrição</label>
                        <input type="text" class="form-control" name="form_descricao" id="form_descricao" maxlength="100" value="<? if ($edit) echo trim($form_descricao);
                                                                                                                                else echo trim($query->record['descricao']); ?>">
                    </div>

                </div>

            </div>

            <div class="card-footer bg-light-2">
                <?
                $btns = array('clean', 'edit');
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