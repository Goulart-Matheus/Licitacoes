<?php
    error_reporting (0);

    $base = !isset($base) ? "../": "";

    require_once($base . "class/class.connection.php");

   
    $bd               =new DataBase("192.168.0.56", "5432", "cadsec", "postgres", "postgres");
    
    $query            =new Query($bd);
    $queryauth        =new Query($bd);

