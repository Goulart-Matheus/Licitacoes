
<?
isset($erro) ?: $erro = null;
isset($edit) ?: $edit = null;
$option_place   = !isset($option_place)  || $option_place   == "" ? "um Setor"   : $option_place;
$where_setor  =  isset($where_setor) && $where_setor  != "" ? $where_setor : "";
?>

<option value="" selected>Selecione <? echo $option_place; ?></option>

<?
$query_setor = new Query($bd);


$query_setor->exec("SELECT id_setor, nome FROM public.setor " . $where_nome . " ORDER BY nome");
$n_setor = $query_setor->rows();  

while ($n_setor--) {

    $query_setor->proximo();

    $selected = "";

    if (($erro || $edit) && $query_setor->record[0] == $form_elemento) {

        $selected = "selected";
    } else {

        if ($query_setor->record[0] == $form_elemento) {

            $selected = "selected";
        }
    }

    echo "<option value='" . $query_setor->record[0] . "' " . $selected . ">" . $query_setor->record[1] . "</option>";
}

$option_place = $where_setor = $form_elemento = "";
?>