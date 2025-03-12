<?

$c = count($_FILES['form_image']['name']);

$in                = [];
$out               = [];
$config            = array();
$config["tamanho"] = 900000;
$config["largura"] = 300000;
$config["altura"]  = 300000;

for($i = 0 ; $i < $c; $i++){
    $in[$i] = array( 'name'     =>$_FILES['form_image']['name'][$i],
                     'type'     =>$_FILES['form_image']['type'][$i],
                     'tmp_name' =>$_FILES['form_image']['tmp_name'][$i],
                     'error'    =>$_FILES['form_image']['error'][$i],
                     'size'     =>$_FILES['form_image']['size'][$i]
    );

}

for($i = 0 ; $i < $c ; $i++){

    $arquivo = $in[$i];


    if (!preg_match("/^image|^application|^text\/(vnd.oasis.opendocument.spreadsheet|vnd.oasis.opendocument.text|octet-stream|plain|msword|pdf|pjpeg|jpeg|png|gif|bmp|odt|ods)$/", $arquivo["type"] , $matches)) { // Verifica o Tipo do Arquivo

        if (!preg_match("/\.(xls|doc|pdf|txt|gif|png|jpg|jpeg|odt|ods){1}$/i", $arquivo["name"])) { // Verifica a extens�o

            $erro = "Arquivo em formato inválido! O arquivo deve ser xls, doc, txt, pdf, jpg, gif, odt, ods ou png.<br>";

        }    
    } else {

        //if ($arquivo["size"] > $config["tamanho"]) $erro = "Arquivo em tamanho muito grande! A imagem deve ser de no máximo " . $config["tamanho"] . " bytes.<br>";

        //$tamanhos = getimagesize($arquivo["tmp_name"]);

        //if ($tamanhos[0] > $config["largura"]) $erro = "Largura da imagem não deve ultrapassar " . $config["largura"] . " pixels<br>";

        //if ($tamanhos[1] > $config["altura"])  $erro = "Altura da imagem n�o deve ultrapassar " . $config["altura"] . " pixels";

    }

    if ($erro=="") {

        preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $arquivo["name"], $ext);

        $imagem_nome    = md5(uniqid(time())) . "." . $ext[1];
        $imagem_dir     = "$diretorio" . $imagem_nome;

        $out[$i] = $imagem_nome;

        if (!move_uploaded_file($arquivo['tmp_name'], $imagem_dir)) $erro = "Erro ao enviar o arquivo !<br>";
        
    }

}

?>
