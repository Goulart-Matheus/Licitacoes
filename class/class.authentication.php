<?
define("EXPIREINSECONDS",floatval(trim($system->getTimeout())) * (796460.17699115*1));

class Session {

      var $name;
      var $record;
      var $count;

      function __construct($name) {
          $this->name = $name;
      }

      function startSession() {
          session_start();
          session_name($this->name);
          $this->record=array();
          $this->count++;
          $this->registerSession();
          $this->verifySession();
      }

      function destroySession() {
          unset($this->name);
          // session_unregister($this->name);
          session_unset();
          $this->record=array();
          $this->count--;
      }

      function registerSession() {
          if (!$this->getSession()) {
              $this->record['ip'] = getenv('REMOTE_ADDR');
              $this->record['time'] = date('U');
              global $record;
			  $_SESSION['record'] = date('U');
          }
      }

      function verifySession() { 
          if (($this->getSession()) && ((date('U') - $_SESSION['record']) > EXPIREINSECONDS)) {
              $this->destroySession();
              return 0;
          }
          else {
              $_SESSION['record'] = date('U');
              return 1;
          }
      }

      function getSession() {
          if ($_SESSION['record'])
              return 1;
          else
              return 0;
      }

      function getUser() {
          return $this->record['user'];
      }

      function getUserName() {
          global $queryauth;
          $queryauth->exec("SELECT nome FROM usuario WHERE id_usuario = ". $this->getUser() );
          $queryauth->proximo();
          return $queryauth->record[0];
      }

      function getUserAviso() {
          global $queryauth;
          $queryauth->exec("SELECT aviso FROM usuario WHERE id_usuario = ".$this->getUser());
          $queryauth->proximo();
          return $queryauth->record[0];
      }

      function getIp() {
          return $this->record['ip'];
      }

      function getAltPass() {
        global $queryauth;
        $queryauth->exec("SELECT alterou_senha FROM usuario WHERE id_usuario = " . $this->getUser() );
        $queryauth->proximo();
        return $queryauth->record[0];
      }

      function getClientId()
      {
        global $queryauth;
        $queryauth->exec("SELECT id_cliente FROM usuario WHERE id_usuario= " . $this->getUser());
        $queryauth->proximo();
        return $queryauth->record[0];
      }

      function getOrgaoId()
      {
        global $queryauth;
        $queryauth->exec("SELECT id_orgao FROM usuario WHERE id_usuario = " . $this->getUser());
        $queryauth->proximo();
        return $queryauth->record[0];
      }

      function getOrgaoName()
      {
        global $queryauth;
        $queryauth->exec("SELECT sigla FROM orgao WHERE id_orgao = " . $this->getOrgaoId());
        $queryauth->proximo();
        return $queryauth->record[0];
      }

      function getOrgaoGestor($id_orgao)
      {
        global $queryauth;
        $queryauth->exec("SELECT orgao_gestor FROM orgao WHERE id_orgao = $id_orgao");
        $queryauth->proximo();
        return $queryauth->record[0];
      }
}

class Authentication extends Session {
      
    var $queryauth;

    public function __construct($queryauth, $session_name = '') {
        $this->queryauth = $queryauth;
        $this->session = new Session($session_name);
    }

    // function __construct($queryauth,$session_name = '') {
    //     $this->queryauth = $queryauth;
    //     $this->session = new Session($session_name);
    // }

    function verifyAccess($user,$pass,$page) {
        if($this->verifyUser($user,$pass)) {
            if($this->verifyApplication($page)){ 
                return 1;
            }
        }
        return 0;
    }

    function verifyUser($user,$pass) {
        
        $sql="SELECT * FROM usuario Where login = '".$user."' AND habilitado='S'";

        $this->queryauth->exec($sql);

            $n=$this->queryauth->rows();

            while($n--){

                $this->queryauth->proximo();
                //verifica se usuario eh valido

                if(($this->queryauth->record['login'] == $user) && ($this->queryauth->record['senha'] == sha1($pass))) 
                {
                    $this->record['user'] = $this->queryauth->record['id_usuario'];
                    $this->record['pass'] = sha1($pass);
                    return 1;
                }

            }

            return 0;
    }

    function verifyApplication($page) {
        $user=$this->record['user'];
        $this->queryauth->exec("SELECT fonte
                                FROM usuario_grupo, grupo_aplicacao, aplicacao
                                WHERE id_usuario = $user                                           
                                    AND usuario_grupo.codgrupo       = grupo_aplicacao.codgrupo 
                                    AND grupo_aplicacao.codaplicacao = aplicacao.codaplicacao
                            ");

        $n = $this->queryauth->rows();
        while($n--){
            $this->queryauth->proximo();
            //verifica se usuario possui acesso a aplicacao
            if($this->getApplicationName($page) == $this->queryauth->record[0]) {
                return 1;
            }
        }
        return 0;
    }

    function getApplicationName($page){
        $tmp = explode("/",$page);
        return $tmp[sizeof($tmp)-1];
    }

    function getApplicationCode($page){
        $this->queryauth->exec("SELECT codaplicacao FROM aplicacao WHERE fonte = '$page'");
        $n = $this->queryauth->rows();
        if($n) {
            $this->queryauth->proximo();
            return $this->queryauth->record[0];
        }
        return 0;
    }

    function getApplicationPath($code) {
        $str = null;
        if(!$code) return;
        $this->queryauth->exec("SELECT a.codaplicacao, b.codaplicacao, a.fonte, a.descricao 
                                FROM aplicacao a 
                            LEFT JOIN aplicacao b ON a.superior=b.codaplicacao 
                                WHERE a.codaplicacao=$code");

        $n = $this->queryauth->rows(); 

        if($n) {
            $this->queryauth->proximo();
            if($this->queryauth->record[0]==1) $str .="&nbsp;";
            else                           $str .="<strong>&nbsp;&raquo;&nbsp;</strong>";
            if($this->queryauth->record[2])    $str .="<span> <a href='".$this->queryauth->record[2]."'>".$this->queryauth->record[3]."</a></span>";
            else                           $str .="<span>".$this->queryauth->record[3]."</span>";
            $this->getApplicationPath($this->queryauth->record[1]);
            echo $str;
        }
    }

    function getApplicationDescription($page) {
        $user=$this->record['user'];
        $this->queryauth->exec("SELECT fonte,descricao
                                FROM usuario_grupo, grupo_aplicacao, aplicacao
                                WHERE id_usuario = $user                                          
                                AND usuario_grupo.codgrupo       = grupo_aplicacao.codgrupo 
                                AND grupo_aplicacao.codaplicacao = aplicacao.codaplicacao");
                                
        $n = $this->queryauth->rows();
        while($n--){
            $this->queryauth->proximo();
            //verifica se usuario possui acesso a aplicacao
            if($this->getApplicationName($page) == $this->queryauth->record[0]) {
                return $this->queryauth->record[1];
            }
        }
        return false;
    }

    function expirationDate($user)
    {
        $this->queryauth->exec("SELECT dt_validade FROM usuario WHERE login =  '" . $user . "'");
        $this->queryauth->proximo();
        
        if($this->queryauth->record[0] < date("Y-m-d"))
        {
            $this->queryauth->exec("UPDATE usuario SET habilitado = 'N' WHERE login =  '" . $user . "'");
            return false;
        }
        else
        {
            $validade = date('Y-m-d', strtotime('+60 days'));
            $this->queryauth->exec("UPDATE usuario SET dt_validade = '{$validade}' WHERE login =  '" . $user . "'");
            return true;
        }
    }

}
?>