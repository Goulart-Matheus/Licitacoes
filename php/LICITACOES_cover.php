<?
include('../includes/session.php');
include('../includes/variaveisAmbiente.php');
include_once('../includes/dashboard/header.php');
include('../class/class.tab.php');
include('../class/class.report.php');

$tab = new Tab();

$tab->setTab('Licitações', 'fas fa-id-card-alt', 'LICITACOES_viewDados.php');
$tab->setTab('Informações', 'fa-regular fa-file-lines', $_SERVER['PHP_SELF'] . "?id_licitacao=$id_licitacao");
$tab->setTab('Editar', 'fas fa-plus', "LICITACOES_edit.php?id_licitacao={$id_licitacao}");
$tab->printTab($_SERVER['PHP_SELF'] . "?id_licitacao=$id_licitacao");

$query->exec("SELECT lo.id_licitacao_objeto, lo.id_licitacao, lo.descricao, lo.id_licitacao_tipo_objeto, lo.arquivo, lto.descricao AS desc_objeto, 
                     l.abertura, l.arq_abertura, l.arq_situacao, l.tipo
                    FROM licitacao_objeto AS lo
              INNER JOIN licitacao l USING (id_licitacao)
              INNER JOIN licitacao_tipo_objeto lto USING(id_licitacao_tipo_objeto)
                   WHERE lo.id_licitacao = '$id_licitacao'");

$query->proximo(0);

$sort = new Sort($query, $sort_icon, $sort_dirname, $sort_style);

if (!$sort_by)   $sort_by  = 1;
if (!$sort_dir)   $sort_dir = 0;

$sort->sortItem($sort_by, $sort_dir);

$report_subtitulo   = "Licitação";
$report_periodo     = date('d/m/Y');

if ($print) {
    include('../class/class.report.php');

    unset($_GET['print']);

    $report_cabecalho = array(
        array('Código',     10, 0),
        array('Descricao',     190, 1)
    );

    $query->exec($query->sql . $sort->sort_sql);

    $report = new PDF($query, $report_titulo, $report_subtitulo, $report_periodo, $report_cabecalho, $report_orientation, $report_unit, $report_format, $report_flag);

    exit;
} else {
    $paging = new Paging($query, $paging_maxres, $paging_maxlink, $paging_link, $paging_page, $paging_flag);

    $paging->exec($query->sql . $sort->sort_sql);
}
 
$n = $paging->query->rows();

// INCLUSÂO DO ARQUIVO VIEW E FORM COM A MODAL DE PESQUISA FORMULARIO E ADIÇÃO
include_once('LICITACOESANEXO_view.php');
?>

<section class="content">

    <form method="post" action="<? echo $_SERVER['PHP_SELF'] . "?id_licitacao=$id_licitacao"; ?>" enctype="multipart/form-data">

        <div class="card p-0">

            <div class="card-header border-bottom-1 mb-3 bg-light-2">

                <div class="row">

                    <div class="col-12 col-md-4 offset-md-4 text-center">
                        <h4><? print_r($query->record['abertura']) ?></h4>
                    </div>

                </div>

            </div>

            <div class="card-body col-12">

                <div class="row col-12">

                    <div class="col-12">
                        <?
                        include("../includes/cards/dashboard/card_dashboard_projeto_dados_gerais.php");
                        ?>
                    </div>

                </div>

                <div class="row">

                    <div class="col-12 col-md-12">
                        <?
                        include("../includes/cards/dashboard/card_dashboard_projeto_anexos.php");
                        ?>
                    </div>

                    <div class="col-12 col-md-12">
                        <?
                        include("../includes/cards/dashboard/card_dashboard_projeto_anexos2.php");
                        ?>
                    </div>

                </div>



            </div>

        </div>

    </form>

</section>


<?
include_once('../includes/dashboard/footer.php');
?>