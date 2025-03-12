<?

include('../includes/session.php');

$where  = "";

if (isset($filter)) {
    $where .= $form_descricao != "" ? " AND descricao ilike '%{$form_descricao}%' " : "";
    $where .= $form_situacao != "" ? " AND situacao ilike '%{$form_situacao}%' " : "";
    $where .= $form_ano != "" ? " AND ano ilike '%{$form_ano}%' " : "";
    $where .= $form_id_secretaria != "" ? " AND s.id_secretaria = '{$form_id_secretaria}' " : "";
}

    $query->exec("SELECT id_licitacao, abertura, situacao, descricao, id_secretaria, s.nome, ano
                    FROM licitacao 
              INNER JOIN secretaria s USING(id_secretaria)
                   WHERE 1 = 1 " . $where);

               
    $sort = new Sort($query, $sort_icon, $sort_dirname, $sort_style);

if (!$sort_by)   $sort_by  = 6;
if (!$sort_dir)   $sort_dir = 0;

$sort->sortItem($sort_by, $sort_dir);

$report_subtitulo   = "Licitação";
$report_periodo     = date('d/m/Y');

    $paging = new Paging($query, $paging_maxres, $paging_maxlink, $paging_link, $paging_page, $paging_flag);

    if (isset($remove)) {

        if (!isset($id_licitacao)) {

            $erro = 'Nenhum item selecionado!';

        } else {

            $querydel = new Query($bd);

            for ($c = 0; $c < sizeof($id_licitacao); $c++) {

                $where = array(0 => array('id_licitacao', $id_licitacao[$c]));
                $querydel->deleteTupla('licitacao', $where);
            }

            unset($_POST['id_licitacao']);
        }
    }

    $paging->exec($query->sql . $sort->sort_sql);


include_once('../includes/dashboard/header.php');
include('../class/class.tab.php');

$tab = new Tab();

$tab->setTab('Licitações', 'fas fa-id-card-alt', $_SERVER['PHP_SELF']);
$tab->setTab('Nova Licitação', 'fas fa-plus', 'LICITACOES_form.php');

$tab->printTab($_SERVER['PHP_SELF']);

$n = $paging->query->rows();

// INCLUSÂO DO ARQUIVO VIEW COM A MODAL DE PESQUISA
include 'LICITACOES_view.php'
?>

<section class="content">

    <form method="post" action="<? echo $_SERVER['PHP_SELF']; ?>">

        <div class="card p-0">

            <div class="card-header border-bottom-1 mb-3 bg-light-2">

                <div class="row">

                    <div class="col-12 col-md-4 offset-md-4 text-center">
                        <h4><?= $auth->getApplicationDescription($_SERVER['PHP_SELF']) ?></h4>
                    </div>

                    <div class="col-12 col-md-4 text-center text-md-right mt-2 mt-md-0">

                        <!-- Abre Modal de Filtro -->
                        <button type="button" class="btn btn-sm btn-green text-light" data-toggle="modal" data-target="#LICITACOES_view">
                            <i class="fas fa-search"></i>
                        </button>

                    </div>

                </div>

                <div class="row text-center">

                    <div class="col-12 col-sm-4 offset-sm-4">
                        <?
                        if (!$n) {
                            echo callException('Nenhum registro encontrado!', 2);
                        }

                        if ($erro) {
                            echo callException($erro, 1);
                        }

                        if ($remove) {
                            $querydel->commit();
                            unset($_POST['remove']);
                        }

                        ?>

                    </div>

                </div>

            </div>

            <div class="card-body pt-0 table-responsive">

                <table class="table">

                    <thead>

                        <tr>
                            <th colspan="5">

                                Resultados de

                                <span class="range-resultados">
                                    <? echo $paging->getResultadoInicial() . "-" . $paging->getResultadoFinal(); ?>
                                </span>

                                sobre

                                <span class='numero-paginas'>
                                    <? echo $paging->getRows(); ?>
                                </span>

                            </th>
                        </tr>

                    </thead>

                    <tbody>

                        <tr>

                            <td style=' <? echo $sort->verifyItem(0); ?>' width="5px"></td>
                            <td style=' <? echo $sort->verifyItem(6); ?>'> <? echo $sort->printItem(6, $sort->sort_dir, 'Aviso'); ?> </td>
                            <td style=' <? echo $sort->verifyItem(3); ?>'> <? echo $sort->printItem(3, $sort->sort_dir, 'Descrição'); ?> </td>
                            <td style=' <? echo $sort->verifyItem(5); ?>'> <? echo $sort->printItem(5, $sort->sort_dir, 'Secretaria'); ?> </td>
                            <td style=' <? echo $sort->verifyItem(2); ?>'> <? echo $sort->printItem(2, $sort->sort_dir, 'Situação'); ?> </td>

                        </tr>

                        <?

                        while ($n--) {

                            $paging->query->proximo();

                            $js_onclick = "OnClick=javascript:window.location=('LICITACOES_cover.php?id_licitacao=" . $paging->query->record[0] . "')";

                            echo "<tr class='entered'>";

                            echo "<td valign='top'><input type=checkbox class='form-check-value' name='id_licitacao[]' value=" . $paging->query->record['id_licitacao'] . "></td>";
                            echo "<td valign='top' " . $js_onclick . ">" . $paging->query->record[1] . "</td>";
                            echo "<td valign='top' " . $js_onclick . ">" . $paging->query->record[3] . "</td>";
                            echo "<td valign='top' " . $js_onclick . ">" . $paging->query->record[5] . "</td>";
                            echo "<td valign='top' " . $js_onclick . ">" . $paging->query->record[2] . "</td>";

                            echo "</tr>";
                        }

                        ?>

                    </tbody>

                    <tfoot>

                        <tr>
                            <td colspan="5">

                                <div class="text-center pt-2">
                                    <? echo $paging->viewTableSlice(); ?>
                                </div>

                            </td>

                        </tr>

                    </tfoot>

                </table>

            </div>

            <div class="card-footer bg-light-2">
                <?
                if ($paging->query->rows()) {
                    $btns = array('selectAll', 'remove');
                    include('../includes/dashboard/footer_forms.php');
                    getButtons($btns);
                }
                ?>
            </div>

        </div>

    </form>

</section>

<?
include_once('../includes/dashboard/footer.php');
?>