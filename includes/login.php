<?

#VARIAVEIS DE CONTOLE DA SECAO

$secao_name = $system->getSession(); //Define o nome da seção que será utilizada pelo sistema
session_start();

$class_footer = $class_invalid = $class_disabled = "d-none";

if($_SESSION['c01npel'] == "permitido")
{  
    include('../class/class.authentication.php');
    $auth = new Authentication($queryauth,$secao_name);
    $auth->startSession();

    if (!$auth->verifyAccess($_SESSION['PHP_AUTH_USER2'],$_SESSION['PHP_AUTH_PW2'],$_SERVER['PHP_SELF']))
    {
        header("location: /php/401.php");
        exit;
    }

    if($auth->getAltPass() == 'N' && !isset($dispensa_validacao_senha)){
        header("location: /php/USUARIO_formPass.php");
        exit;
    }

}

if(isset($_POST['submit']))
{
    include('../class/class.authentication.php');
    $auth = new Authentication($queryauth,$secao_name);
    $auth->startSession();

    if(!$auth->verifyAccess($_POST['PHP_AUTH_USER'],$_POST['PHP_AUTH_PW'],$_SERVER['PHP_SELF']))
    {
        $auth->destroySession();
        $class_footer = $class_invalid = "";
    }
    else if(!$auth->expirationDate($_POST['PHP_AUTH_USER']))
    {
        $auth->destroySession();
        $class_footer = $class_disabled = "";
    }
    else
    {
        $_SESSION['c01npel']        = "permitido";
        $_SESSION['PHP_AUTH_USER2'] = $_POST['PHP_AUTH_USER'];
        $_SESSION['PHP_AUTH_PW2']   = $_POST['PHP_AUTH_PW'];
        $_SESSION['_login']         = $_POST['PHP_AUTH_USER'];
    
        if($auth->getAltPass() == 'N' && !isset($dispensa_validacao_senha))
        {
            header("location: /php/USUARIO_formPass.php");
            exit;
        }

        header("location: /php/index.php");

        exit;
    }

} 

if($_SESSION['c01npel'] != "permitido")
{
    include_once('auth/header.php');

    ?>
        <div class="container">

            <div class="row justify-content-center align-items-center">

                <div class="col-12 col-lg-6 text-center text-lg-left text-light d-none d-lg-block">

                    <div class="row">

                        <div class="col-12 col-lg-4">
                            <img src="../assets/images/logo-company-light.png" class="img-fluid" alt="Logo">
                            <span class="border-right d-none d-lg-inline p-2"></span>
                        </div>

                        <div class="col-12 col-lg-8 text-lg py-0 py-lg-2">
                            <? echo $system->getTitulo(); ?>
                        </div>

                    </div>

                </div>

                <div class="col-12 col-lg-6">

                    <div class="row">

                        <div class="col-12 text-center text-light d-block d-lg-none py-5">

                            <div class="row">

                                <div class="col-12 col-lg-4">
                                    <img src="../assets/images/logo-company-light.png" class="img-fluid" alt="Logo">
                                </div>

                                <div class="col-12 col-lg-8 text-lg py-0 py-lg-2">
                                    <? echo $system->getTitulo(); ?>
                                </div>

                            </div>

                        </div>

                        <div class="col-12 col-lg-10 offset-lg-2">
                            
                            <div class="card">

                                <div class="card-body">

                                    <div class="p-3">

                                        <p class="text-muted text-center">Entre para iniciar uma nova sessão</p>

                                        <form class="form-horizontal m-t-30" method="POST" action="<? echo $_SERVER['PHP_SELF']; ?>">

                                            <div class="form-row pb-3">
                                                <div class="form-group col-12">
                                                    <input type="text" id="PHP_AUTH_USER" name="PHP_AUTH_USER" value="<?=isset($PHP_AUTH_USER) ? $PHP_AUTH_USER : ""?>" class="form-control" placeholder="Usuário">
                                                </div>
                                            </div>

                                            <div class="form-row pb-3">
                                                <div class="form-group col-12">
                                                    <input type="password" id="PHP_AUTH_PW" name="PHP_AUTH_PW" class="form-control" placeholder="Senha">
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-12">
                                                    <button class="btn btn-green w-md waves-effect waves-light col-12" name="submit" type="submit">Entrar</button>
                                                </div>
                                            </div>

                                        </form>

                                    </div>

                                </div>                                

                                <div class="card-footer <?= $class_footer ?>">

                                    <div class="row">
                                        <div class="col-12 text-center text-danger <?= $class_invalid ?>">
                                            <i class="fa-solid fa-triangle-exclamation"></i>
                                            Usuário e/ou senha inválidos
                                        </div>
                                        <div class="col-12 text-center text-danger <?= $class_disabled ?>">
                                            <i class="fa-solid fa-triangle-exclamation"></i>
                                            A data de validade de seu usuário expirou. Contate a administração do sistema para atualização.
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    <?
    
    include_once('auth/footer.php');
    
    ?>

        <script>
            $( "#PHP_AUTH_USER" ).focus();
            //document.PHP_AUTH_USER.focus();
        </script>

    <? 

    exit;
}
?>