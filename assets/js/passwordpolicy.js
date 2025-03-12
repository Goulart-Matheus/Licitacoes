function generatePassword(){

    var pwd_aux = "";

    var preg = ["abcdefghijklmnopqrstuvwxyz",
                "ABCDEFGHIJKLMNOPQRSTUVWXYZ",
                "0123456789"                /*,
                "!@#$%&?"*/
                ];

    //var preg = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    
    for(var j = 0; j < 3 ; j++){

        for(var i = 4; i > j; i--){
            pwd_aux += preg[j].charAt(Math.floor(Math.random() * preg[j].length));
        }

    }

    var pwd_s = pwd_aux.split("");

    for(var i = 0; i < pwd_s.length ; i++){
        var j = Math.floor(Math.random() * (i + 1));
        var tmp = pwd_s[i];
        pwd_s[i] = pwd_s[j];
        pwd_s[j] = tmp;
    }

    var pwd = pwd_s.join("");

    document.getElementById("form_senha").value = pwd;

    validarSenhaForca(pwd);

    document.getElementById('form_senha').type = 'text';

    //return pwd;
}

function validarSenhaForca(){

    var senha = document.getElementById('form_senha').value;
    var forca = 0;

    if(senha.length >= 8)
    {
      forca += 10;
    }

    if((senha.length >= 8) && (senha.match(/[a-z]+/)))
    {
      forca += 25;
    }

    if((senha.length >= 8) && (senha.match(/[A-Z]+/)))
    {
      forca += 25;
    }

    // if((senha.length >= 8) && (senha.match(/[@#$%&;*!]/))){
    //   forca += 25;
    // }

    if(senha.match(/[0-9]+/g))
    {
        forca += 40;
    }

    mostrarForca(forca);
}

function mostrarForca(forca){

    if(forca < 30 )
    {
        document.getElementById("erroSenhaForca").innerHTML = '<div class="progress"><div class="progress-bar bg-danger" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div></div>';
    }
    else if((forca >= 30) && (forca < 50))
    {
        document.getElementById("erroSenhaForca").innerHTML = '<div class="progress"><div class="progress-bar bg-warning" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div></div>';
    }
    else if((forca >= 50) && (forca < 70))
    {
        document.getElementById("erroSenhaForca").innerHTML = '<div class="progress"><div class="progress-bar bg-info" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div></div>';
    }
    else if((forca >= 70) && (forca <= 100))
    {
        document.getElementById("erroSenhaForca").innerHTML = '<div class="progress"><div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">Forte</div></div>';
    }
}