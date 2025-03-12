<?php
if($tipo_email == 'Novo Cadastro CPF'){
    $mensagem = "<p  style='width:100%;color:#000; font-size:1rem;padding-left:20px;'>Seu usuário foi cadastrado no sistema <b>TAC </b></p>
                <p  style='width:100%;color:#000; font-size:1rem;padding-left:20px;'>Para acessar utilize somente os números seu <b>CPF</b> no campo <b>Login</b> e sua senha para acesso.</p>
                <div style='width:100%;text-align: center;padding-left:25%;'>
                    <div class='box-senha' style='width:33%; background-color: rgba(247, 160, 89, 0.4);position:relative;left: 13%;padding-top:6.5%; padding-bottom:6.5%; box-shadow: 10px 10px 10px rgba(0, 0, 0, 0.3);'>
                        <p> <img class='px-3' src='https://tacmpt.pelotas.com.br/assets/images/Servidores.jpeg' alt=''></p>
                        <br>
                        <b style='color:#000; font-size:1rem;'>SENHA:<br>$form_senha</b>
                        <br>
                    </div>
                </div>
                <div style='width:100%;'>
                    <h3  style='color:#000; font-size: calc(1.3rem + .6vw);'><b>Instruções para redefinição de senha</b> <img class='p-1' src='https://tacmpt.pelotas.com.br/assets/images/Ouvidoria.jpeg' alt=''></h3>
                    <p style='color:#000;font-size:1rem;'>Ao fazer login no você será rederecionado para a página de redefinição de senha</p>
                    <p style='color:#000;font-size:1rem;'>Insira a senha enviada neste email no campo senha atual</p>
                    <p style='color:#000;font-size:1rem;'>Após insira sua nova senha contendo as seguintes observações:</p>
                    <p style='color:#000;font-size:1rem;'><b><span class='text-danger' style='color:#bf0404'>*</span> Sua senha precisa ter 8 caracteres ou mais </b></p>
                    <p style='color:#000;font-size:1rem;'><b><span class='text-danger' style='color:#bf0404'>*</span> Conter letras minusculas</b></p>
                    <p style='color:#000;font-size:1rem;'><b><span class='text-danger' style='color:#bf0404'>*</span> Conter letras maiusculas </b></p>
                    <p style='color:#000;font-size:1rem;'><b><span class='text-danger' style='color:#bf0404'>*</span> Conter números</b></p>
                </div>";

}elseif($tipo_email == 'Novo Cadastro CNPJ'){
    $mensagem = "<p  style='width:100%;color:#000; font-size:1rem;padding-left:20px;'>Seu usuário foi cadastrado no sistema <b>TAC </b></p>
    <p  style='width:100%;color:#000; font-size:1rem;padding-left:20px;'>Para acessar utilize somente os números seu <b>CNPJ</b> no campo <b>Login</b> e sua senha para acesso.</p>
    <div style='width:100%;text-align: center;padding-left:25%;'>
        <div class='box-senha' style='width:33%; background-color: rgba(247, 160, 89, 0.4);position:relative;left: 13%;padding-top:6.5%; padding-bottom:6.5%; box-shadow: 10px 10px 10px rgba(0, 0, 0, 0.3);'>
            <p> <img class='px-3' src='https://tacmpt.pelotas.com.br/assets/images/Servidores.jpeg' alt=''></p>
            <br>
            <b style='color:#000; font-size:1rem;'>SENHA:<br>$form_senha</b>
            <br>
        </div>
    </div>
    <div style='width:100%;'>
        <h3  style='color:#000; font-size: calc(1.3rem + .6vw);'><b>Instruções para redefinição de senha</b> <img class='p-1' src='https://tacmpt.pelotas.com.br/assets/images/Ouvidoria.jpeg' alt=''></h3>
        <p style='color:#000;font-size:1rem;'>Ao fazer login no você será rederecionado para a página de redefinição de senha</p>
        <p style='color:#000;font-size:1rem;'>Insira a senha enviada neste email no campo senha atual</p>
        <p style='color:#000;font-size:1rem;'>Após insira sua nova senha contendo as seguintes observações:</p>
        <p style='color:#000;font-size:1rem;'><b><span class='text-danger' style='color:#bf0404'>*</span> Sua senha precisa ter 8 caracteres ou mais </b></p>
        <p style='color:#000;font-size:1rem;'><b><span class='text-danger' style='color:#bf0404'>*</span> Conter letras minusculas</b></p>
        <p style='color:#000;font-size:1rem;'><b><span class='text-danger' style='color:#bf0404'>*</span> Conter letras maiusculas </b></p>
        <p style='color:#000;font-size:1rem;'><b><span class='text-danger' style='color:#bf0404'>*</span> Conter números</b></p>
    </div>";

}elseif($tipo_email == 'Contrato gestor contrato'){
    $mensagem = "<p  style='width:100%;color:#000; font-size:1rem;padding-left:20px;'>Um novo contrato foi vinculado ao seu usuário</p>
                 <p  style='width:100%;color:#000; font-size:1rem;padding-left:20px;'>Para acessar faça <b>Login</b> em nosso sistema sistema </p>
                 <p  style='width:100%;color:#000; font-size:1rem;padding-left:20px;'>Acesse o menu  <b>Contrato</b> e confira seus contratros de gerenciamento .</p>";

}elseif($tipo_email == 'Contrato fiscal'){
    $mensagem = "<p  style='width:100%;color:#000; font-size:1rem;padding-left:20px;'>Um novo contrato foi vinculado ao seu usuário</p>
                 <p  style='width:100%;color:#000; font-size:1rem;padding-left:20px;'>Para acessar faça <b>Login</b> em nosso sistema sistema </p>
                 <p  style='width:100%;color:#000; font-size:1rem;padding-left:20px;'>Acesse o menu  <b>Contrato</b> e confira seus contratros de fiscalização .</p>";

}elseif($tipo_email == 'Contrato empresa'){
    $mensagem = "<p  style='width:100%;color:#000; font-size:1rem;padding-left:20px;'>Um novo contrato foi vinculado ao seu usuário</p>
                 <p  style='width:100%;color:#000; font-size:1rem;padding-left:20px;'>Para acessar faça <b>Login</b> em nosso sistema sistema </p>
                 <p  style='width:100%;color:#000; font-size:1rem;padding-left:20px;'>Acesse o menu  <b>Contrato</b> e confira seus contratros vigentes </p>";

}elseif($tipo_email == 'Notificação vencimento'){
    $mensagem = "<p  style='width:100%;color:#000; font-size:1rem;padding-left:20px;'>Seu documento encontrasse com prazo vencido.</p>
                 <p  style='width:100%;color:#000; font-size:1rem;padding-left:20px;'>Para acessar faça <b>Login</b> em nosso sistema </p>
                 <p  style='width:100%;color:#000; font-size:1rem;padding-left:20px; padding-bottom:20px;'>Acesse o menu  <b>Contratos</b> selecione o contrato e click na aba <b>Prestação de Contas</b>  logo após confira o prazo dos documentos enviados</p>";
}elseif($tipo_email == 'Notificação aviso'){
    $mensagem = "<p  style='width:100%;color:#000; font-size:1rem;padding-left:20px;'>Seu documento encontrasse com prazo próximo de vencer, faça a atualização antes do vencimento.</p>
                 <p  style='width:100%;color:#000; font-size:1rem;padding-left:20px;'>Para acessar faça <b>Login</b> em nosso sistema </p>
                 <p  style='width:100%;color:#000; font-size:1rem;padding-left:20px; padding-bottom:20px;'>Acesse o menu  <b>Contratos</b> selecione o contrato e click na aba <b>Prestação de Contas</b>  logo após confira o prazo dos documentos enviados</p>";
}

 
$template_email = "
<html style='width: 100%; height: 100%;'>
<body  style='width:100%; background-color: #fafafa;padding:20px;box-shadow: 5px 10px 5px 10px rgba(0, 0, 0, 0.3);border-radius: 25px;'>

    <div style='width:100%;padding:0px;margin:0px;'>
        <div class='head' style=' background-color: rgb(247, 160, 89);padding-top: 20px;height: 15%; margin:0px; width:100%;'>
            <div style='width:100%; display:flex; align-items:center;'>
                <img src='https://cdn.coinpel.com.br/images/prefeitura.png' alt='' style='width:250px; margin-right: 20px;'>
                <h2 style='color:#fff; margin-top:100px; font-size: calc(1.5rem + .6vw);'><b>TAC - TRANSPARÊNCIA NA ADMINSITRAÇÃO DE CONTRATOS </b></h2>
            </div>        
        </div>
        <img src='https://tacmpt.pelotas.com.br/assets/images/wave-topo.jpeg' style='width:100%; margin-top:0px;margin-bottom:0px; padding:0px; margin:0px;'>
        
        <div style=' background-color: #fff; margin-top:0px;margin-bottom:0px;padding-left:100px;padding-right:100px;'>
            <div class='body' style=' background-color: #fff;margin-top:0px;padding-top: 3rem !important; box-shadow: 5px 10px 5px 10px rgb(0, 0, 0, 0.3);border-radius: 25px; '>
                <h3 style='width:100%;color:#000;font-size: calc(1.3rem + .6vw);padding:20px;'>Bem vindo ao sistema TAC <img class='px-3' src='https://tacmpt.pelotas.com.br/assets/images/Concursos.jpeg' alt=''></h3>
                <p  style='width:100%;color:#000; font-size:1rem; padding-left:20px;'> Olá ".$nome.",</p>
                ".$mensagem."
                <div  style='width:100%; text-align: center;'>
                    <a  href='https://tacmpt.pelotas.com.br' style='background-color: #343a40;color: #fff;padding: 10px 20px;text-decoration: none;border-radius: 5px;'>Acesse Aqui</a>
                </div>
                <p  style='color:#666;text-align: center;'> https://tacmpt.pelotas.com.br </p>
                <br><br>
                <div style='width:100%;text-align: center;'>
                    <img src='https://tacmpt.pelotas.com.br/assets/images/logo.jpeg' style='width:20%;' alt=''>
                    <br>
                    <p  style='color:#000;font-size:1rem;'>Desenvolvido por : <a href=''>Coinpel</a> </p>
                    <br>
                </div>
            </div>
        </div>
    </div>
    <img src='https://tacmpt.pelotas.com.br/assets/images/wave-rodape.jpeg' style='width:100%; margin-top:0px;margin-bottom:0px; padding:0px; margin:0px;'>
    

</body>

</html>";



?>
