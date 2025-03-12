<?

include('../includes/session.php');
include('../includes/variaveisAmbiente.php');
include_once('../includes/dashboard/header.php');
include('../class/class.tab.php');

$tab = new Tab();


$tab->setTab('Licitações', 'fas fa-id-card-alt', 'LICITACOES_viewDados.php');
$tab->setTab('Nova Licitação', 'fas fa-plus', $_SERVER['PHP_SELF']);

$tab->printTab($_SERVER['PHP_SELF']);

?>

<link href="../assets/css/multi-select.css" rel="stylesheet" type="text/css">

<section class="content">

    <form method="post" action="<? echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" >

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

                            $valida_descricao = new Valida($form_descricao, 'Descrição');
                            $valida_descricao->TamMinimo(1);
                            $erro .= $valida_descricao->PegaErros();          

                            $valida_tipo = new Valida($form_tipo, 'Tipo');
                            $valida_tipo->TamMinimo(1);
                            $erro .= $valida_tipo->PegaErros();
                            
                            $valida_data = new Valida($form_data, 'Data');
                            $valida_data->TamMinimo(1);
                            $erro .= $valida_data->PegaErros();

                            $valida_id_secretaria = new Valida($form_id_secretaria, 'Secretaria');
                            $valida_id_secretaria->TamMinimo(1);
                            $erro .= $valida_id_secretaria->PegaErros();

                            $valida_ano = new Valida($form_ano, 'Ano');
                            $valida_ano->TamMinimo(1);
                            $erro .= $valida_ano->PegaErros();

                            $valida_encerrado = new Valida($form_encerrado, 'Encerrado');
                            $valida_encerrado->TamMinimo(1);
                            $erro .= $valida_encerrado->PegaErros();
                        }

                        if (!$erro && isset($add)) {
                            $query->begin();
                            
                            {
                                //Adicionando arquivo na pasta anexos_licitacao/arq_abertura
                                if (trim($_FILES["form_arq_abertura"]["error"] === UPLOAD_ERR_OK)) {
                                    $arquivo = $_FILES["form_arq_abertura"];
                                    $diretorio = "../anexos_licitacao/arq_abertura/";
                                    $form_arq_abertura = str_replace(" ", "", $arquivo['name']);
                                    $arquivo_dir = $diretorio . $form_arq_abertura;

                                    // Validação de formato do arquivo
                                    if (!preg_match("/\.(xls|xlsx|doc|pdf|gif|png|jpg|jpeg|zip|odt|ods)$/i", $arquivo["name"])) {
                                        $erro .= "Arquivo em formato inválido! O arquivo deve ser xls, xlsx, doc, pdf, jpg, gif, odt, ods, png ou zip.<br>";
                                        $form_arq_abertura = 'NULL';
                                    } else {
                                        // Gerar um nome único para o arquivo
                                        $ext = pathinfo($arquivo["name"], PATHINFO_EXTENSION);
                                        $form_arq_abertura = md5(uniqid(time())) . "." . $ext;
                                        $arquivo_dir = $diretorio . $form_arq_abertura;

                                        // Tentativa de mover o arquivo
                                        if (!move_uploaded_file($arquivo["tmp_name"], $arquivo_dir)) {
                                            $erro .= "Erro ao enviar o arquivo da Abertura!<br>";
                                            $form_arq_abertura = 'NULL';
                                        }
                                    }
                                } else {
                                    // Caso nenhum arquivo tenha sido selecionado
                                    $form_arq_abertura = 'NULL';
                                }

                                //Adicionando arquivo na pasta anexos_licitacao/arq_situacao
                                if (trim($_FILES["form_arq_situacao"]["error"] === UPLOAD_ERR_OK)) {
                                    $arquivo = $_FILES["form_arq_situacao"];
                                    $diretorio = "../anexos_licitacao/arq_situacao/";
                                    $form_arq_situacao = str_replace(" ", "", $arquivo['name']);
                                    $arquivo_dir = $diretorio . $form_arq_situacao;

                                    // Validação de formato do arquivo
                                    if (!preg_match("/\.(xls|xlsx|doc|pdf|gif|png|jpg|jpeg|zip|odt|ods)$/i", $arquivo["name"])) {
                                        $erro .= "Arquivo em formato inválido! O arquivo deve ser xls, xlsx, doc, pdf, jpg, gif, odt, ods, png ou zip.<br>";
                                        $form_arq_situacao = 'NULL';
                                    } else {
                                        // Gerar um nome único para o arquivo
                                        $ext = pathinfo($arquivo["name"], PATHINFO_EXTENSION);
                                        $form_arq_situacao = md5(uniqid(time())) . "." . $ext;
                                        $arquivo_dir = $diretorio . $form_arq_situacao;

                                        // Tentativa de mover o arquivo
                                        if (!move_uploaded_file($arquivo["tmp_name"], $arquivo_dir)) {
                                            $erro .= "Erro ao enviar o arquivo da Situaçao!<br>";
                                            $form_arq_situacao = 'NULL';
                                        }
                                    }
                                } else {
                                    // Caso nenhum arquivo tenha sido selecionado
                                    $form_arq_situacao = 'NULL';
                                }
                            }

                            if ($form_exclusivo == '') {
                                $form_exclusivo = "N";
                            }

                            if (!$erro && isset($add)) {
                                $query->begin();
                                $query->insertTupla('licitacao', 
                                                    array($form_abertura, 
                                                    $form_arq_abertura, 
                                                    $form_situacao, 
                                                    $form_arq_situacao, 
                                                    $form_descricao, 
                                                    'NULL', 
                                                    $form_encerrado, 
                                                    $form_tipo, 
                                                    $form_data, 
                                                    $form_id_secretaria, 
                                                    $form_ano, 
                                                    $form_exclusivo,
                                                    $form_tipo,
                                                    $_user              , 
                                                    $_ip                , 
                                                    $_data              , 
                                                    $_hora    ));
                            }

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

                    <div class="form-group col-3 col-md-3">
                        <label for="form_data"><span class="text-danger">*</span> Data</label>
                        <input required type="date" class="form-control" name="form_data" id="form_data" maxlength="100" value="<? if ($erro) echo ($form_data) ?>">
                    </div>

                    <div class="form-group col-2 col-md-2">
                        <label for="form_data"><span class="text-danger">*</span> Ano da Licitação</label>
                        <input required type="text" name="form_ano" class="form-control" value="<? if ($erro) echo $form_ano; ?>" size="4" maxlength="4">
                    </div>

                    <div class="form-group col-7 col-md-7">
                        <label for="form_descricao"><span class="text-danger">*</span> Descrição</label>
                        <input required type="text" class="form-control" name="form_descricao" id="form_descricao" maxlength="100" value="<? if ($erro) echo $form_descricao; ?>">
                    </div>

                </div>

                <div class="form-row">

                    <div class="form-group col-12 col-md-6">
                        <label for="form_abertura">Aviso</label>
                        <input type="text" class="form-control" name="form_abertura" id="form_abertura" maxlength="100" value="<? if ($erro) echo $form_abertura; ?>">
                    </div>

                    <div class="form-group col-12 col-md-6">
                        <label for="form_arq_abertura">Arquivo do Aviso</label>
                        <input type="file" class="form-control" name="form_arq_abertura" id="form_arq_abertura" maxlength="100" value="<? if ($erro) echo $form_arq_abertura; ?>">
                    </div>

                </div>

                <div class="form-row">

                    <div class="form-group col-12 col-md-6">
                        <label for="form_situacao">Situação</label>
                        <input type="text" class="form-control" name="form_situacao" id="form_situacao" maxlength="100" value="<? if ($erro) echo $form_situacao; ?>">
                    </div>

                    <div class="form-group col-12 col-md-6">
                        <label for="form_arq_situacao">Arquivo da Situação</label>
                        <input type="file" class="form-control" name="form_arq_situacao" id="form_arq_situacao" maxlength="100" value="<? if ($erro) echo $form_arq_situacao; ?>">
                    </div>

                </div>

                <div class="form-row">

                    <div class="form-group col-6 col-md-6">
                        <label for="form_id_secretaria"><span class="text-danger">*</span> Secretaria</label>
                        <select required name="form_id_secretaria" id="form_id_secretaria" class="form-control">
                            <?
                            $form_elemento = $erro ? $form_id_secretaria : "";
                            include("../includes/inc_select/inc_select_secretaria.php");
                            ?>
                        </select>
                    </div>

                    <div class="form-group col-2 col-md-2">
                        <label for="form_encerrado" class="col-12 px-0"><span class="text-danger">*</span> Encerrado:
                        </label>
                        <div class="btn-group btn-group-toggle mx-3" data-toggle="buttons">
                            <? if (!$erro) unset($form_encerrado) ?>
                            <label class="btn btn-light">
                                <input required class="form-control" type="radio" name="form_encerrado" id="form_encerrado" value="s" <? if ($form_encerrado == "s") {
                                                                                                                                    echo " checked";
                                                                                                                                } ?>>Sim<br>
                            </label> &nbsp;

                            <label class="btn btn-light">
                                <input required class="form-control" type="radio" name="form_encerrado" id="form_encerrado" value="n" <? if ($form_encerrado == "n") {
                                                                                                                                    echo " checked";
                                                                                                                                } ?>>Não
                            </label> &nbsp;
                        </div>
                    </div>

                    <div class="form-group col-2 col-md-2">
                        <label for="form_exclusivo" class="col-12 px-0"> Licitações Exclusivas:
                        </label>
                        <div class="btn-group btn-group-toggle mx-3" data-toggle="buttons">
                            <? if (!$erro) unset($form_exclusivo) ?>
                            <label class="btn btn-light">
                                <input class="form-control" type="radio" name="form_exclusivo" id="form_exclusivo" value="S" <? if ($form_exclusivo == "S") {
                                                                                                                                    echo " checked";
                                                                                                                                } ?>>Sim<br>
                            </label> &nbsp;

                            <label class="btn btn-light">
                                <input class="form-control" type="radio" name="form_exclusivo" id="form_exclusivo" value="N" <? if ($form_exclusivo == "S") {
                                                                                                                                    echo " checked";
                                                                                                                                } ?>>Não
                            </label> &nbsp;
                        </div>
                    </div>

                    <div class="form-group col-2 col-md-2">
                        <label for="form_tipo" class="col-12 px-0"><span class="text-danger">*</span> Tipo:
                        </label>
                        <div class="btn-group btn-group-toggle mx-3" data-toggle="buttons">
                            <select required name="form_tipo" id="form_tipo" class="form-control">
                                <?
                                $form_elemento = $erro ? $form_tipo : "";
                                include("../includes/inc_select/inc_select_tipo.php");
                                ?>
                            </select>

                        </div>
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

<script src="../assets/js/jquery.multi-select.js"></script>
<script src="../assets/js/jquery.quicksearch.js"></script>

<script>
    if ($(".select2_form_tipo").length > 0) {
        $(".select2_form_tipo").attr('data-live-search', 'true');

        $(".select2_form_tipo").select2({
            width: '100%'
        });
    }
</script>