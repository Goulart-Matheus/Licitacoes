
<?
isset($erro) ?: $erro = null;
isset($edit) ?: $edit = null;
$option_place   = !isset($option_place)  || $option_place   == "" ? "um Responsável"   : $option_place;
$where_responsavel  =  isset($where_responsavel) && $where_responsavel  != "" ? $where_responsavel : "";
?>

<option value="" selected>Selecione <? echo $option_place; ?></option>

<?
$query_responsavel = new Query($bd);


$query_responsavel->exec("SELECT id_responsavel, nome FROM public.responsavel " . $where_nome . " ORDER BY nome");
$n_responsavel = $query_responsavel->rows();  

while ($n_responsavel--) {

    $query_responsavel->proximo();

    $selected = "";

    if (($erro || $edit) && $query_responsavel->record[0] == $form_elemento) {

        $selected = "selected";
    } else {

        if ($query_responsavel->record[0] == $form_elemento) {

            $selected = "selected";
        }
    }

    echo "<option value='" . $query_responsavel->record[0] . "' " . $selected . ">" . $query_responsavel->record[1] . "</option>";
}

$option_place = $where_responsavel = $form_elemento = "";
?>