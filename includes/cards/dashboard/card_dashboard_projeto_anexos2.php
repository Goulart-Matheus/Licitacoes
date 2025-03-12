<style>
    .card-footer {
        position: sticky;
        bottom: 0;
        border-top: 1px solid #ddd;
        /* Linha para separar o footer */
    }
</style>

<?

$query->exec("SELECT id_licitacao, abertura, arq_abertura, situacao, arq_situacao
                    FROM licitacao
                   WHERE id_licitacao = '$id_licitacao' ");

$query->proximo();

// Salvando o arquivo nas variaveis para não perder o arquivo na hora da edit.
$arq_atual_abertura = $query->record['arq_abertura'];
$arq_atual_situacao = $query->record['arq_situacao'];

?>

<div class="card border">

    <div class="card-header bg-green"><i class="fas fa-paperclip"></i> Dados da Licitação</div>

    <div class="card-body overflow-auto table-responsive p-0 m-0" style="height: 105px;">


        <table class="table">

            <tbody>

                <tr>

                    <td width="60%"> <? echo $sort->printItem(1, $sort->sort_dir, 'Descrição do Arquivo'); ?> </td>
                    <td width="40%"> <? echo $sort->printItem(2, $sort->sort_dir, 'Arquivo'); ?> </td>

                </tr>

                <tr class="entered">

                    <?$js_onclick = "OnClick=\"javascript:window.location='../anexos_licitacao/arq_abertura/{$arq_atual_abertura}';\"";?>
                  
                    <td valign='top' <?= $js_onclick?>><?= empty($query->record['abertura']) ? 'Não Possui Descrição ' : $paging->query->record['abertura'] ; ?></td>
                    <td valign="top" <?= $js_onclick?>>
                        <?= empty($query->record['arq_abertura']) ? 'Não Possui Arquivo ' : $paging->query->record['arq_abertura']; ?>
                    </td>

                </tr>

                <tr class="entered">

                    <?$js_onclick = "OnClick=\"javascript:window.location='../anexos_licitacao/arq_situacao/{$arq_atual_situacao}';\"";?>
                  
                    <td valign='top' <?= $js_onclick?>><?= empty($query->record['situacao']) ? 'Não Possui Descrição ' : $paging->query->record['situacao'] ; ?></td>
                    <td valign="top" <?= $js_onclick?>>
                        <?= empty($query->record['arq_situacao']) ? 'Não Possui Arquivo ' : $paging->query->record['arq_situacao']; ?>
                    </td>

                </tr>


            </tbody>





        </table>
    </div>

</div>