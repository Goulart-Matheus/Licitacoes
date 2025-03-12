<style>
    .card-footer {
        position: sticky;
        bottom: 0;
        border-top: 1px solid #ddd;
        /* Linha para separar o footer */
    }
</style>

<?

$query->exec("SELECT lo.id_licitacao_objeto, lo.id_licitacao, lo.descricao, lo.id_licitacao_tipo_objeto, lo.arquivo, lto.descricao AS desc_objeto, 
                     l.abertura, l.arq_abertura, l.arq_situacao, l.tipo
                    FROM licitacao_objeto AS lo
              INNER JOIN licitacao l USING (id_licitacao)
              INNER JOIN licitacao_tipo_objeto lto USING(id_licitacao_tipo_objeto)
                   WHERE lo.id_licitacao = '$id_licitacao'");

$sort = new Sort($query, $sort_icon, $sort_dirname, $sort_style);

if (!$sort_by)   $sort_by  = 1;
if (!$sort_dir)   $sort_dir = 0;

$sort->sortItem($sort_by, $sort_dir);

$report_subtitulo   = "Tipo De Licitação";
$report_periodo     = date('d/m/Y');

$paging = new Paging($query, $paging_maxres, $paging_maxlink, $paging_link, $paging_page, $paging_flag);

if (isset($remove)) {

    if (!isset($licitacao_anexo)) {

        $erro = 'Nenhum item selecionado!';
    } else {

        $querydel = new Query($bd);

        for ($c = 0; $c < sizeof($licitacao_anexo); $c++) {

            $where = array(0 => array('id_licitacao_objeto', $licitacao_anexo[$c]));
            $querydel->deleteTupla('licitacao_objeto', $where);
        }

        unset($_POST['id_licitacao_objeto']);
    }
}

$paging->exec($query->sql . $sort->sort_sql);

$n = $paging->query->rows();

?>

<div class="card border">

    <div class="card-header bg-green">
        <i class="fas fa-paperclip"></i> Anexos e suas informações

        <a type="button" class="btn btn-sm btn-light" style="float: right;" target="_self" href="LICITACOESANEXO_form.php?id_licitacao=<?= $id_licitacao; ?>">
            <i class="text-green fas fa-plus"></i>
        </a>
    </div>

    <div class="card-body overflow-auto table-responsive p-0" <? if (!$n) { ?>style="height: 84px" <? } else { ?>tyle="height: 100px; overflow: auto;" <? } ?>;>

        <div class="col-12 col-md-4 text-center text-md-right mt-2 mt-md-0">

        </div>

        <table class="table">

            <tbody>

                <div class="row text-center <? if (!$n) { ?> m-2 <? } else { ?> m-0 <? } ?>;">

                    <div class="col-12 col-sm-4 offset-sm-4">
                        <?
                        if (!$n) {
                            echo callException('Nenhum registro encontrado!', 2);
                        } else { ?>

                            <tr>

                                <td style=' <? echo $sort->verifyItem(0); ?>' width="2%"></td>
                                <td width="49%"> <? echo $sort->printItem(2, $sort->sort_dir, 'Descrição'); ?> </td>
                                <td width="49%"> <? echo $sort->printItem(2, $sort->sort_dir, 'Anexo'); ?> </td>

                            </tr>



                            <?

                            while ($n--) {

                                $paging->query->proximo();

                                $js_onclick = "OnClick=\"javascript:window.location='../anexos_licitacao/objeto_licitacao/{$paging->query->record['arquivo']}';\"";

                                echo "<tr class='entered'>";

                                echo "<td valign='top'><input type=checkbox class='form-check-value' name='licitacao_anexo[]' value=" . $paging->query->record[0] . "></td>";
                                echo "<td valign='top' " . $js_onclick . ">" . $paging->query->record['descricao'] . "</td>";
                                echo "<td valign='top' " . $js_onclick . ">" . $paging->query->record['arquivo'] . "</td>";

                                echo "</tr>";
                            }

                            ?>

                        <?
                        }
                        if ($erro) {
                            echo callException($erro, 1);
                        }

                        if ($remove) {
                            unset($_POST['remove']);
                        }

                        ?>

                    </div>

                </div>



            </tbody>

        </table>

        <div class="card-footer bg-light-2 fixed-footer">
            <?
            if ($paging->query->rows()) {
                $btns = array('selectAll', 'remove');
                include('../includes/dashboard/footer_forms.php');
                getButtons($btns);
            }
            ?>
        </div>

    </div>

</div>