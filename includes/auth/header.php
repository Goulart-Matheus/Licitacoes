<!DOCTYPE html>

<html lang="pt-br">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,minimal-ui">
        
        <title><? echo $system->getTitulo(); ?></title>
        
        <meta content="<? echo $system->getTitulo(); ?>" name="description">
        <meta content="Eng.Renato Müller Jr." name="author">
        
        <link rel="shortcut icon" href="../assets/images/logo-short.png">

        <link href="../assets/css/app.css" rel="stylesheet" type="text/css">

        <style>
            .container, .row 
            {
                height                          : 100%;
                min-height                      : 100%;
            }

            html, body 
            {
                height                          : 100%;
            }

            .card
            {
                background-color                : transparent;
                background-image                : linear-gradient(to right, rgba(255,255,255,0.7), rgba(255,255,255,1));
            }

            .card input
            {
                outline                         : none !important;
                background-color                : transparent;
                border                          : none;
                border-bottom                   : 1px solid #CCCCCC;
                box-shadow                      : none !important;
                border-radius                   : 0px;
                font-size                       : 13pt;
                font-weight                     : lighter;
            }

            .card input:focus
            {
                outline                         : none !important;
                background-color                : transparent;
                border                          : none;
                border-bottom                   : 1px solid #28a745;
                box-shadow                      : 0 6px 5px -5px #28a745 !important;
            }

        </style>

    </head>

    <body class="bg-auth">
