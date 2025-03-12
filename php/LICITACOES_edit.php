<?

include('../includes/session.php');
include('../includes/variaveisAmbiente.php');
include_once('../includes/dashboard/header.php');
include('../class/class.tab.php');
include('../class/class.report.php');

$tab = new Tab();

$tab->setTab('Licitações', 'fas fa-id-card-alt', 'LICITACOES_viewDados.php');
$tab->setTab('Informações', 'fa-regular fa-file-lines', "LICITACOES_cover.php?id_licitacao={$id_licitacao}");
$tab->setTab('Editar', 'fas fa-pencil-alt', $_SERVER['PHP_SELF'] . "?id_licitacao=$id_licitacao");

$tab->printTab($_SERVER['PHP_SELF'] . "?id_licitacao=$id_licitacao");

// Remoção do Arquivo da Abertura
if (isset($_GET['remover_arq_abertura'])) {
    $caminho = "../anexos_licitacao/arq_abertura/".$_GET['remover_arq_abertura'];
    $query->exec("UPDATE licitacao SET arq_abertura = NULL WHERE id_licitacao = $id_licitacao");
    if (file_exists($caminho)) {
        if (unlink($caminho))  $erro .= "Arquivo da Situação removido com sucesso.";
        else $erro .= "Erro ao remover o arquivo.";
    } 
    else $erro .= "Arquivo não encontrado.";
}

// Remoção do Arquivo da Stiaução
if (isset($_GET['remover_arq_situacao'])) {
    $caminho = "../anexos_licitacao/arq_situacao/".$_GET['remover_arq_situacao'];
    $query->exec("UPDATE licitacao SET arq_situacao = NULL WHERE id_licitacao = $id_licitacao");
    if (file_exists($caminho)) {
        if (unlink($caminho))  $erro .= "Arquivo da Situação removido com sucesso.";
        else $erro .= "Erro ao remover o arquivo.";
    } 
    else $erro .= "Arquivo não encontrado.";
}

$query->exec("SELECT * FROM licitacao WHERE id_licitacao = " . $id_licitacao);
$query->proximo();

// Salvando o arquivo nas variaveis para não perder o arquivo na hora da edit.
$arq_atual_abertura = $query->record['arq_abertura'];
$arq_atual_situacao = $query->record['arq_situacao'];

?>

<link href="../assets/css/multi-select.css" rel="stylesheet" type="text/css">

<section class="content">

    <form method="post" action="<? echo $_SERVER['PHP_SELF'] . "?id_licitacao=$id_licitacao" ?>" enctype="multipart/form-data">

        <input type="hidden" name="id_licitacao" value="<? echo $query->record[0]; ?>">

        <div class="card p-0">

            <div class="card-header border-bottom-1 mb-3 bg-light-2">

                <div class="text-center">
                    <h4><?= $auth->getApplicationDescription($_SERVER['PHP_SELF']) ?></h4>
                </div>

                <div class="row text-center">

                    <div class="col-12 col-sm-4 offset-sm-4">

                        <?
                        if (isset($edit)) {
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

                            $valida_id_secretaria = new Valida($form_id_secretaria, 'id_secretaria');
                            $valida_id_secretaria->TamMinimo(1);
                            $erro .= $valida_id_secretaria->PegaErros();

                            $valida_ano = new Valida($form_ano, 'Ano');
                            $valida_ano->TamMinimo(1);
                            $erro .= $valida_ano->PegaErros();

                            $valida_encerrado = new Valida($form_encerrado, 'Encerrado');
                            $valida_encerrado->TamMinimo(1);
                            $erro .= $valida_encerrado->PegaErros();
                        }

                        if (!$erro && isset($edit)) {
                            $query->begin();


                            //Adicionando arquivo na pasta anexos_licitacao/arq_abertura
                            if (trim($_FILES["form_arq_abertura"]["name"] != "")) {
                                $arquivo = $_FILES["form_arq_abertura"];
                                $diretorio = "../anexos_licitacao/arq_abertura/";
                                $form_arq_abertura = str_replace(" ", "", $arquivo['name']);
                                $arquivo_dir = $diretorio . $form_arq_abertura;

                                // Validação de formato do arquivo
                                if (!preg_match("/\.(xls|xlsx|doc|pdf|gif|png|jpg|jpeg|zip|odt|ods)$/i", $arquivo["name"])) {
                                    $erro .= "Arquivo em formato inválido! O arquivo deve ser xls, xlsx, doc, pdf, jpg, gif, odt, ods, png ou zip.<br>";
                                    $form_arq_abertura = '';
                                } else {
                                    // Gerar um nome único para o arquivo
                                    $ext = pathinfo($arquivo["name"], PATHINFO_EXTENSION);
                                    $form_arq_abertura = md5(uniqid(time())) . "." . $ext;
                                    $arquivo_dir = $diretorio . $form_arq_abertura;

                                    // Tentativa de mover o arquivo
                                    if (!move_uploaded_file($arquivo["tmp_name"], $arquivo_dir)) {
                                        $erro .= "Erro ao enviar o arquivo da Abertura!<br>";
                                        $form_arq_abertura = '';
                                    }
                                }
                            } 
                            
                            //Adicionando arquivo na pasta anexos_licitacao/arq_situacao
                            if (trim($_FILES["form_arq_situacao"]["name"] != "")) {
                                $arquivo = $_FILES["form_arq_situacao"];
                                $diretorio = "../anexos_licitacao/arq_situacao/";
                                $form_arq_situacao = str_replace(" ", "", $arquivo['name']);
                                $arquivo_dir = $diretorio . $form_arq_situacao;

                                // Validação de formato do arquivo
                                if (!preg_match("/\.(xls|xlsx|doc|pdf|gif|png|jpg|jpeg|zip|odt|ods)$/i", $arquivo["name"])) {
                                    $erro .= "Arquivo em formato inválido! O arquivo deve ser xls, xlsx, doc, pdf, jpg, gif, odt, ods, png ou zip.<br>";
                                    $form_arq_situacao = '';
                                } else {
                                    // Gerar um nome único para o arquivo
                                    $ext = pathinfo($arquivo["name"], PATHINFO_EXTENSION);
                                    $form_arq_situacao = md5(uniqid(time())) . "." . $ext;
                                    $arquivo_dir = $diretorio . $form_arq_situacao;

                                    // Tentativa de mover o arquivo
                                    if (!move_uploaded_file($arquivo["tmp_name"], $arquivo_dir)) {
                                        $erro .= "Erro ao enviar o arquivo da Situaçao!<br>";
                                        $form_arq_situacao = '';
                                    
                                    }
                                }
                            }

                            if ($form_exclusivo == '') {
                                $form_exclusivo = "N";
                            }


                            if (!$erro && isset($edit)) {
                                $query->begin();

                                // Verificação para manter ou atualizar os arquivos
                                $form_arq_abertura_final = ($form_arq_abertura == '') ? "NULL" : $form_arq_abertura;
                                $form_arq_situacao_final = ($form_arq_situacao == '') ? "NULL" : $form_arq_situacao;

                                $itens = array(
                                    $form_abertura,
                                    $form_arq_abertura_final,
                                    $form_situacao,
                                    $form_arq_situacao_final,
                                    $form_descricao,
                                    'NULL',
                                    $form_encerrado,
                                    $form_tipo,
                                    $form_data,
                                    $form_id_secretaria,
                                    $form_ano,
                                    $form_exclusivo,
                                    $form_tipo,
                                    $_user,
                                    $_ip,
                                    $_data,
                                    $_hora
                                );

                                $where = array(0 => array('id_licitacao', $id_licitacao));
                                $query->updateTupla('licitacao', $itens, $where);
                            }

                            $query->commit();
                            $arq_atual_abertura = $form_arq_abertura;
                            $arq_atual_situacao = $form_arq_situacao;
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
                        <input required type="date" class="form-control" name="form_data" id="form_data" maxlength="100" value="<? if ($edit) echo trim($form_data);
                                                                                                                        else echo trim($query->record['data']); ?>">
                    </div>

                    <div class="form-group col-2 col-md-2">
                        <label for="form_data"><span class="text-danger">*</span> Ano da Licitação</label>
                        <input maxlength="4"  required type="text" name="form_ano" class="form-control" value="<? if ($edit) echo trim($form_ano);
                                                                                        else echo trim($query->record['ano']); ?>" size="4" maxlength="10" tabIndex="14">
                    </div>

                    <div class="form-group col-12 col-md-6">
                        <label for="form_descricao"><span class="text-danger">*</span> Descrição</label>
                        <input required type="text" class="form-control" name="form_descricao" id="form_descricao" value="<? if ($edit) echo trim($form_descricao);
                                                                                                                    else echo trim($query->record['descricao']); ?>">
                    </div>

                </div>

                <div class="form-row">

                    <div class="form-group col-12 col-md-6">
                        <label for="form_abertura">Aviso</label>
                        <input type="text" class="form-control" name="form_abertura" id="form_abertura" maxlength="100" value="<? if ($edit) echo trim($form_abertura);
                                                                                                                                else echo trim($query->record['abertura']); ?>">
                    </div>

                    <div class="form-group col-12 col-md-6">
                        <label for="form_arq_abertura">Arquivo do Aviso</label>
                        <? if($arq_atual_abertura == ''){?>
                            <input type="file" class="form-control" name="form_arq_abertura" id="form_arq_abertura" maxlength="100" value="">
                        <?}
                         else {?>
                         <input type="hidden" class="form-control" name="form_arq_abertura" id="form_arq_abertura"  value="<?=$arq_atual_abertura?>">
                        <a class="ml-1" target="_self" href="<?= $_SERVER['PHP_SELF']; ?>?remover_arq_abertura=<? echo $arq_atual_abertura; ?>&id_licitacao=<? echo $id_licitacao; ?>"
                            onclick="return confirm('Tem certeza de que deseja remover este arquivo?');">
                            [remover]
                        </a>
                        <?} if(file_exists("../anexos_licitacao/arq_abertura/$arq_atual_abertura") && $arq_atual_abertura != ''){?>
                        <a class="ml-3" href="../anexos_licitacao/arq_abertura/<? echo $arq_atual_abertura; ?>" target="_new"><i class="fas fa-download"></i></a>
                        <?}else if($arq_atual_abertura != ''){?>
                        <label for="form_arq_abertura" class="text-green ml-2" style="font-weight: normal;"> Arquivo não encontrado no Servidor</label>
                        <?}?>
                    </div>

                </div>

                <div class="form-row">

                    <div class="form-group col-12 col-md-6">
                        <label for="form_situacao">Situação</label>
                        <input type="text" class="form-control" name="form_situacao" id="form_situacao" maxlength="100" value="<? if ($edit) echo trim($form_situacao);
                                                                                                                                else echo trim($query->record['situacao']); ?>">
                    </div>

                    <div class="form-group col-12 col-md-6">
                        <label for="form_arq_situacao">Arquivo da Situação</label>
                        <?if($arq_atual_situacao == ''){?>
                        <input type="file" class="form-control" name="form_arq_situacao" id="form_arq_situacao" maxlength="100" value="">
                        <?}
                        else{?>
                        <input type="hidden" class="form-control" name="form_arq_situacao" id="form_arq_situacao"  value="<?=$arq_atual_situacao?>">
                        <a class="ml-1" target="_self" href="<?= $_SERVER['PHP_SELF']; ?>?remover_arq_situacao=<? echo $arq_atual_situacao; ?>&id_licitacao=<? echo $id_licitacao; ?>"
                            onclick="return confirm('Tem certeza de que deseja remover este arquivo?');">
                            [remover]
                        </a>
                        <?} if(file_exists("../anexos_licitacao/arq_situacao/$arq_atual_situacao") && $arq_atual_situacao != ''){?>
                        <a class="ml-3" href="../anexos_licitacao/arq_situacao/<? echo $arq_atual_situacao; ?>" target="_new"><i class="fas fa-download"></i></a>
                        <?}else if($arq_atual_situacao != ''){?>
                        <label for="form_arq_situacao" class="text-green ml-2" style="font-weight: normal;"> Arquivo não encontrado no Servidor</label>
                        <?}?>
                    </div>
                    

                </div>

                <div class="form-row">

                    <div class="form-group col-6 col-md-6">
                        <label for="form_id_secretaria"><span class="text-danger">*</span>Secretaria</label>
                        <select required name="form_id_secretaria" id="form_id_secretaria" class="form-control">
                            <?
                            $form_elemento = $erro ? $form_id_secretaria :  $query->record['id_secretaria'];
                            if(isset($_GET['remover_arq_abertura']) || isset($_GET['remover_arq_situacao'])){
                                $form_elemento = $query->record['id_secretaria'];
                            }
                            include("../includes/inc_select/inc_select_secretaria.php");
                            ?>
                        </select>
                    </div>

                    <div class="form-group col-2 col-md-2">
                        <label for="form_encerrado" class="col-12 px-0"><span class="text-danger">*</span> Encerrado:
                        </label>
                        <div class="btn-group btn-group-toggle mx-3" data-toggle="buttons">
                            <? if (!isset($edit)) $form_encerrado = $query->record["encerrado"]; ?>
                            <label class="btn btn-light">
                                <input required class="form-control" type="radio" name="form_encerrado" id="form_encerrado" value="s" <? if ($form_encerrado == "s") echo "checked"; ?>>Sim<br>
                            </label> &nbsp;

                            <label class="btn btn-light">
                                <input required class="form-control" type="radio" name="form_encerrado" id="form_encerrado" value="n" <? if ($form_encerrado == "n") echo "checked"; ?>>Não
                            </label> &nbsp;
                        </div>
                    </div>

                    <div class="form-group col-2 col-md-2">
                        <label for="form_exclusivo" class="col-12 px-0"> Licitações Exclusivas:
                        </label>
                        <div class="btn-group btn-group-toggle mx-3" data-toggle="buttons">
                            <? if (!isset($edit)) $form_exclusivo=$query->record["exclusiva"]; ?>
                            <label class="btn btn-light">
                                <input class="form-control" type="radio" name="form_exclusivo" id="form_exclusivo" value="S" <? if ($form_exclusivo == "S") echo "checked"; ?>>Sim<br>
                            </label> &nbsp;

                            <label class="btn btn-light">
                                <input class="form-control" type="radio" name="form_exclusivo" id="form_exclusivo" value="N" <? if ($form_exclusivo == "N") echo "checked"; else if($query->record["exclusiva"] == "") echo "checked"; ?>>Não
                            </label> &nbsp;
                        </div>
                    </div>

                    <div class="form-group col-2 col-md-2">
                        <label for="form_tipo" class="col-12 px-0"><span class="text-danger">*</span> Tipo:
                        </label>
                        <div class="btn-group btn-group-toggle mx-3" data-toggle="buttons" >
                            <select required name="form_tipo" id="form_tipo" class="form-control" >
                                <?
                                $form_elemento = $erro ? $form_tipo :  $query->record['id_licitacao_tipo_licitacao'];
                                if(isset($_GET['remover_arq_abertura']) || isset($_GET['remover_arq_situacao'])){
                                    $form_elemento = $query->record['id_licitacao_tipo_licitacao'];
                                }
                                include("../includes/inc_select/inc_select_tipo.php");
                                ?>
                            </select>
                        </div>
                    </div>


                </div>

            </div>

            <div class="card-footer bg-light-2">
                <?
                include('../includes/dashboard/footer_forms.php');
                $btns = array('clean', 'edit');
                getButtons($btns);
                ?>
            </div>

        </div>

    </form>

</section>

<?
include_once('../includes/dashboard/footer.php');
?>
