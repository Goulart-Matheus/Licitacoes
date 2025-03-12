<?
isset($erro) ?: $erro = null;
isset($edit) ?: $edit = null;
$option_place   = !isset($option_place)  || $option_place   == "" ? "uma Aplicação"   : $option_place;
$where_aplicacao  =  isset($where_aplicacao) && $where_aplicacao  != "" ? $where_aplicacao : "";
?>

<option value="" selected>Selecione <? echo $option_place; ?></option>

<?
$query_aplicacao = new Query($bd);

$query_aplicacao->exec("SELECT id_aplicacao, descricao FROM aplicacao " . $where_aplicacao . " ORDER BY descricao");
$n_aplicacao = $query_aplicacao->rows();

while ($n_aplicacao--) {

    $query_aplicacao->proximo();

    $selected = "";

    if (($erro || $edit) && $query_aplicacao->record[0] == $form_elemento) {

        $selected = "selected";
    } else {

        if ($query_aplicacao->record[0] == $form_elemento) {

            $selected = "selected";
        }
    }

    echo "<option value='" . $query_aplicacao->record[0] . "' " . $selected . ">" . $query_aplicacao->record[1] . "</option>";
}

$option_place = $where_aplicacao = $form_elemento = "";
?>