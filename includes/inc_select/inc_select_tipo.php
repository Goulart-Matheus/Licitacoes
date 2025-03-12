<?
isset($erro) ?: $erro = null;
isset($edit) ?: $edit = null;
$option_place   = !isset($option_place)  || $option_place   == "" ? "um tipo"   : $option_place;
$where_tipo  =  isset($where_tipo) && $where_tipo  != "" ? $where_tipo : "";
?>

<option value="" selected>Selecione <? echo $option_place; ?></option>

<?
$query_tipo = new Query($bd);


$query_tipo->exec("SELECT id_licitacao_tipo_licitacao, descricao FROM public.licitacao_tipo_licitacao " . $where_tipo . " ORDER BY descricao");
$n_tipo = $query_tipo->rows();    

while ($n_tipo--) {

    $query_tipo->proximo();

    $selected = "";

    if (($erro || $edit) && $query_tipo->record[0] == $form_elemento) {

        $selected = "selected";
    } else {

        if ($query_tipo->record[0] == $form_elemento) {

            $selected = "selected";
        }
    }

    echo "<option value='" . $query_tipo->record[0] . "' " . $selected . ">" . $query_tipo->record[1] . "</option>";
}

$option_place = $where_tipo = $form_elemento = "";
unset($form_elemento);
?>