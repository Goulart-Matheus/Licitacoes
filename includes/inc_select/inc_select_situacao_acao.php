
<?
isset($erro) ?: $erro = null;
isset($edit) ?: $edit = null;
$option_place   = !isset($option_place)  || $option_place   == "" ? "a Sitiação da ação"   : $option_place;
$where_situacao_acao  =  isset($where_situacao_acao) && $where_situacao_acao  != "" ? $where_situacao_acao : "";
?>

<option value="" selected>Selecione <? echo $option_place; ?></option>

<?
$query_situacao_acao = new Query($bd);


$query_situacao_acao->exec("SELECT id_situacao_acao, nome FROM public.situacao_acao " . $where_situacao_acao . " ORDER BY nome");
$n_situacao_acao = $query_situacao_acao->rows();  

while ($n_situacao_acao--) {

    $query_situacao_acao->proximo();

    $selected = "";

    if (($erro || $edit) && $query_situacao_acao->record[0] == $form_elemento) {

        $selected = "selected";
    } else {

        if ($query_situacao_acao->record[0] == $form_elemento) {

            $selected = "selected";
        }
    }

    echo "<option value='" . $query_situacao_acao->record[0] . "' " . $selected . ">" . $query_situacao_acao->record[1] . "</option>";
}

$option_place = $where_situacao_acao = $form_elemento = "";
?>