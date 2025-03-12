<?
isset($erro)                ?: $erro = null;
isset($edit)                ?: $edit = null;
isset($sort_by)             ? : $sort_by = null;
isset($sort_dir)            ? : $sort_dir = null;
isset($print)               ? : $print = null;
isset($paging_page)         ? : $paging_page = null;
?>

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
    <link href="../assets/css/style.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/multi-select.css" rel="stylesheet" type="text/css">
    <link href="../assets/summernote/summernote-bs4.min.css" rel="stylesheet" type="text/css">
</head>
<body class="hold-transition sidebar-mini sidebar-collapse hide_sidebar">
<?include_once('navbar.php')?>