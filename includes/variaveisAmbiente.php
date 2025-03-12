<?
    date_default_timezone_set('America/Sao_Paulo')      ;

    $data_atual         = new DateTime();
    $_data              = $data_atual->format('Y-m-d'); // Equivalente a strftime("%Y-%m-%d")
    $_hora              = $data_atual->format('H:i'); // Equivalente a strftime("%H:%M")
    $_user              = $auth->getUser()                  ;
    $_ip                = $_SERVER['REMOTE_ADDR']           ;
    $_id_cliente        = $auth->getClientId()              ;
    $_id_orgao          = $auth->getOrgaoId()               ;
    $_name_orgao        = $auth->getOrgaoName()             ;
    $_orgao_gestor      = $auth->getOrgaoGestor($_id_orgao) ;
?>