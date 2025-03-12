<?
isset($erro) ?: $erro = null;
isset($edit) ?: $edit = null;
$option_place   = !isset($option_place)  || $option_place   == "" ? "uma Licitação"   : $option_place;
$where_licitacao  =  isset($where_licitacao) && $where_licitacao  != "" ? $where_licitacao : "";
?>

<option value="" selected>Selecione <? echo $option_place; ?></option>

<?
$query_licitacao = new Query($bd);


$query_licitacao->exec("SELECT id_licitacao, abertura, ano FROM public.licitacao " . $where_licitacao . " ORDER BY ano");
$n_licitacao = $query_licitacao->rows();    

while ($n_licitacao--) {

    $query_licitacao->proximo();

    $selected = "";

    if (($erro || $edit) && $query_licitacao->record[0] == $form_elemento) {

        $selected = "selected";
    } else {

        if ($query_licitacao->record[0] == $form_elemento) {

            $selected = "selected";
        }
    }

    echo "<option value='" . $query_licitacao->record[0] . "' " . $selected . ">" . $query_licitacao->record[1] . "</option>";
}

$option_place = $where_licitacao = $form_elemento = "";
?>