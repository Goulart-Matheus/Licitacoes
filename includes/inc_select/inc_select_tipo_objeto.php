<?
isset($erro) ?: $erro = null;
isset($edit) ?: $edit = null;
$option_place   = !isset($option_place)  || $option_place   == "" ? "um tipo"   : $option_place;
$where_tipo_objeto  =  isset($where_tipo_objeto) && $where_tipo_objeto  != "" ? $where_tipo_objeto : "";
?>

<option value="" selected>Selecione <? echo $option_place; ?></option>

<?
$query_tipo_objeto = new Query($bd);


$query_tipo_objeto->exec("SELECT id_licitacao_tipo_objeto, descricao FROM public.licitacao_tipo_objeto " . $where_tipo . " ORDER BY descricao");
$n_tipo_objeto = $query_tipo_objeto->rows();    

while ($n_tipo_objeto--) {

    $query_tipo_objeto->proximo();

    $selected = "";

    if (($erro || $edit) && $query_tipo_objeto->record[0] == $form_elemento) {

        $selected = "selected";
    } else {

        if ($query_tipo_objeto->record[0] == $form_elemento) {

            $selected = "selected";
        }
    }

    echo "<option value='" . $query_tipo_objeto->record[0] . "' " . $selected . ">" . $query_tipo_objeto->record[1] . "</option>";
}

$option_place = $where_tipo_objeto = $form_elemento = "";
?>