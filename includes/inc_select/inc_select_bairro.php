
<?
isset($erro) ?: $erro = null;
isset($edit) ?: $edit = null;
$option_place   = !isset($option_place)  || $option_place   == "" ? "um bairro"   : $option_place;
$where_bairro  =  isset($wherebairro) && $wherebairro  != "" ? $where_bairro : "";
?>

<option value="" selected>Selecione <? echo $option_place; ?></option>

<?
$query_bairro = new Query($bd);


$query_bairro->exec("SELECT id_bairro, descricao FROM public.bairro " . $where_bairro . " ORDER BY descricao");
$n_bairro = $query_bairro->rows();  

while ($n_bairro--) {

    $query_bairro->proximo();

    $selected = "";

    if (($erro || $edit) && $query_bairro->record[0] == $form_elemento) {

        $selected = "selected";
    } else {

        if ($query_bairro->record[0] == $form_elemento) {

            $selected = "selected";
        }
    }

    echo "<option value='" . $query_bairro->record[0] . "' " . $selected . ">" . $query_bairro->record[1] . "</option>";
}

$option_place = $where_bairro = $form_elemento = "";
?>