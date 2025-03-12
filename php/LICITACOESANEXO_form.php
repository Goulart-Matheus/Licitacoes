<?

include('../includes/session.php');
include('../includes/variaveisAmbiente.php');
include_once('../includes/dashboard/header.php');
include('../class/class.tab.php');

$tab = new Tab();


$tab->setTab('Licitações', 'fas fa-id-card-alt', 'LICITACOES_viewDados.php');
$tab->setTab('Informações', 'fa-regular fa-file-lines', "LICITACOES_cover.php?id_licitacao={$id_licitacao}");
$tab->setTab('Novo Anexo', 'fas fa-plus', $_SERVER['PHP_SELF'] . "?id_licitacao=$id_licitacao");

$tab->printTab($_SERVER['PHP_SELF'] . "?id_licitacao=$id_licitacao");

$query->exec("SELECT * 
                FROM licitacao_objeto
          INNER JOIN licitacao USING (id_licitacao)
               WHERE 1 = 1"); 
	
$query->proximo();

?>

<link href="../assets/css/multi-select.css" rel="stylesheet" type="text/css">

<section class="content" id="LICITACOES_form">

    <form method="post" action="<? echo $_SERVER['PHP_SELF'] . "?id_licitacao=$id_licitacao"; ?>" enctype="multipart/form-data">

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

                            $valida_arq_situacao = new Valida($form_arquivo, 'Arquivo da Situação');
                            $valida_arq_situacao->TamMinimo(0);
                            $erro .= $valida_arq_situacao->PegaErros();

                            $valida_descricao = new Valida($form_descricao, 'Descrição');
                            $valida_descricao->TamMinimo(1);
                            $erro .= $valida_descricao->PegaErros();

                            $valida_tipo = new Valida($form_tipo, 'Tipo');
                            $valida_tipo->TamMinimo(1);
                            $erro .= $valida_tipo->PegaErros();
                        }

                        if (!$erro && isset($add)) {
                            $query->begin();

                            if ($_FILES["form_arquivo"]["error"] === UPLOAD_ERR_OK) {
                                $arquivo = $_FILES["form_arquivo"];
                                $diretorio = "../anexos_licitacao/objeto_licitacao/";
                                $form_arquivo = str_replace(" ", "", $arquivo['name']);
                                $arquivo_dir = $diretorio . $form_arquivo;

                                // Validação de formato do arquivo
                                if (!preg_match("/\.(xls|xlsx|doc|pdf|gif|png|jpg|zip|jpeg|odt|ods)$/i", $arquivo["name"])) {
                                    $erro .= "Arquivo em formato inválido! O arquivo deve ser xls, xlsx, doc, pdf, jpg, gif, odt, ods ou png.<br>";
                                } else {
                                    // Gerar um nome único para o arquivo
                                    $ext = pathinfo($arquivo["name"], PATHINFO_EXTENSION);
                                    $form_arquivo = md5(uniqid(time())) . "." . $ext;
                                    $arquivo_dir = $diretorio . $form_arquivo;
                                    }
                                    if (!move_uploaded_file($arquivo["tmp_name"], $arquivo_dir)) {
                                        $erro .= "Erro ao enviar o arquivo! <br>";
                                        $form_arquivo = 'NULL';
                                    }
                            } else {
                                // Caso nenhum arquivo tenha sido selecionado
                                $form_arquivo = 'NULL';
                            }


                            if ($form_exclusivo == '') {
                                $form_exclusivo = "N";
                            }
                            if (!$erro) {
                                $query->begin();
                                $query->insertTupla('licitacao_objeto',
                                               array($id_licitacao    ,
                                                $form_descricao       ,
                                                $form_arquivo         , 
                                                $form_tipo            ,                                                    
                                                $_user                , 
                                                $_ip                  , 
                                                $_data                , 
                                                $_hora    ));

                                        $query->commit();
                            }

                        }

                        if ($erro){
                            echo callException($erro, 2);
                        }
                        
                        ?>

                    </div>

                </div>

            </div>



            <div class="card-body pt-0">

                <div class="form-row">

                    <div class="form-group col-12 col-md-12">
                        <label for="form_descricao">Descrição</label>
                        <input type="text" name="form_descricao" class="form-control" value="<? if ($erro) echo $form_descricao; ?>" size="4" maxlength="10" tabIndex="14">
                    </div>

                </div>

                <div class="form-row">

                    <div class="form-group col-6 col-md-6">
                        <label for="form_arquivo">Arquivo</label>
                        <input type="file" class="form-control" name="form_arquivo" id="form_arquivo" maxlength="100" value="<? if ($erro) echo htmlspecialchars($form_arquivo) ; ?>">
                    </div>


                    <div class="form-group col-6 col-md-6">
                        <label for="form_tipo" class="col-12 px-0"> Tipo:
                        </label>
                        <div>
                            <select name="form_tipo" id="form_tipo" class="form-control">
                                <?
                                $form_elemento = $erro ? $form_tipo : "";
                                include("../includes/inc_select/inc_select_tipo_objeto.php");
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
    if ($(".select2_form_descricao").length > 0) {
        $(".select2_form_descricao").attr('data-live-search', 'true');

        $(".select2_form_descricao").select2({
            width: '100%'
        });
    }
</script>