<?
isset($erro) ?: $erro = null;
isset($edit) ?: $edit = null;
$option_place   = !isset($option_place)  || $option_place   == "" ? "uma secretaria"   : $option_place;
$where_secretaria  =  isset($where_secretaria) && $where_secretaria  != "" ? $where_secretaria : "";
?>

<option value="" selected>Selecione <? echo $option_place; ?></option>

<?
$query_secretaria = new Query($bd);


$query_secretaria->exec("SELECT id_secretaria, nome FROM public.secretaria " . $where_secretaria . " ORDER BY nome");
$n_secretaria = $query_secretaria->rows();    

while ($n_secretaria--) {

    $query_secretaria->proximo();

    $selected = "";

    if (($erro || $edit) && $query_secretaria->record[0] == $form_elemento) {

        $selected = "selected";
    } else {

        if ($query_secretaria->record[0] == $form_elemento) {

            $selected = "selected";
        }
    }

    echo "<option value='" . $query_secretaria->record[0] . "' " . $selected . ">" . $query_secretaria->record[1] . "</option>";
}

$option_place = $where_secretaria = $form_elemento = "";
unset($form_elemento);
?>