
<?
isset($erro) ?: $erro = null;
isset($edit) ?: $edit = null;
$option_place   = !isset($option_place)  || $option_place   == "" ? "um endereço"   : $option_place;
$where_endereco  =  isset($where_endereco) && $where_endereco  != "" ? $where_endereco : "";
?>

<option value="" selected>Selecione <? echo $option_place; ?></option>

<?
$query_endereco = new Query($bd);


$query_endereco->exec("SELECT id_logradouro, nomlog FROM public.logradouro " . $where_endereco . " ORDER BY nomlog");
$n_endereco = $query_endereco->rows();  

while ($n_endereco--) {

    $query_endereco->proximo();

    $selected = "";

    if (($erro || $edit) && $query_endereco->record[0] == $form_elemento) {

        $selected = "selected";
    } else {

        if ($query_endereco->record[0] == $form_elemento) {

            $selected = "selected";
        }
    }

    echo "<option value='" . $query_endereco->record[0] . "' " . $selected . ">" . $query_endereco->record[1] . "</option>";
}

$option_place = $where_endereco = $form_elemento = "";
?>