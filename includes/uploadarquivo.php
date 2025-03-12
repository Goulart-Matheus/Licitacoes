<?

$config  = array();
$arquivo = isset($_FILES["form_image"]) ? $_FILES["form_image"] : FALSE;

if ($arquivo) {
    
    if (!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $arquivo["type"])) {

        $erro = "Arquivo em formato inválido! A imagem deve ser jpg, jpeg, bmp, gif ou png.<br>";

    }

    if ($erro == "") {

        preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $arquivo["name"], $ext);

        $imagem_nome = md5(uniqid(time())) . "." . $ext[1];
        $imagem_dir = "$diretorio" . $imagem_nome;

        if (!move_uploaded_file($arquivo["tmp_name"], $imagem_dir)) $erro="Erro ao enviar o arquivo !<br>";
        
    }
}
?>
