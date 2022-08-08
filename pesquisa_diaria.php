<?php
if (isset($_POST['edData'])) {
    session_start();
    $unidade_usina = $_SESSION['cod_usina'];
    $data = $_POST['edData'];
    $_SESSION['dt_pesq_D']=$data;
    $data=  explode('/', $data);
    $data=$data[2].'/'.$data[1].'/'.$data[0];
    include 'conecta.php';
    $con = mysql_query("select * from op_usina where usina=$unidade_usina and data='$data'");
    if ($con) {
        $_SESSION['data_cons_d'] = $data;
        header('location:filter_diaria.php');
    } else {
        header('location:pesquisa_diaria.php');
    }
}

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <title>Pesquisa Diária por data</title>
        <meta name="generator" content="WYSIWYG Web Builder - http://www.wysiwygwebbuilder.com">
        <style type="text/css">
            div#container
            {
                width: 800px;
                position: relative;
                margin-top: 0px;
                margin-left: auto;
                margin-right: auto;
                text-align: left;
            }
            body
            {
                text-align: center;
                margin: 0;
                background-color: #FFFFFF;
                color: #000000;
            }
        </style>
        <style type="text/css">
            p, span, div, ol, ul, li, td, button, input, textarea, form
            {
                margin: 0;
                padding: 0;
            }
            a
            {
                color: #0000FF;
                outline: none;
                text-decoration: underline;
            }
            a:visited
            {
                color: #800080;
            }
            a:active
            {
                color: #FF0000;
            }
            a:hover
            {
                color: #0000FF;
                text-decoration: underline;
            }
        </style>
        <link rel="stylesheet" href="./ui-lightness/jquery.ui.all.css" type="text/css">

        <style type="text/css">
            #wb_Text8 
            {
                background-color: transparent;
                border: 0px #000000 solid;
                padding: 0;
            }
            #wb_Text8 div
            {
                text-align: left;
            }
            #edData
            {
                border: 1px #C0C0C0 solid;
                background-color: #FFFFFF;
                color :#000000;
                font-family: Arial;
                font-size: 13px;
                text-align: left;
                vertical-align: middle;
            }
            .ui-datepicker
            {
                font-family: Arial;
                font-size: 13px;
                z-index: 1003 !important;
                display: none;
            }
            #wb_Text1 
            {
                background-color: transparent;
                border: 0px #000000 solid;
                padding: 0;
            }
            #wb_Text1 div
            {
                text-align: left;
            }
            #jQueryButton1
            {
                font-family: Arial;
                font-size: 13px;
                font-weight: normal;
                font-style: normal;
            }
            #jQueryButton1 .ui-button
            {
                position: absolute;
            }
            #jQueryButton1 .ui-button-icon-primary
            {
                left: 10px;
            }
            #jQueryButton2
            {
                font-family: Arial;
                font-size: 13px;
                font-weight: normal;
                font-style: normal;
            }
            #jQueryButton2 .ui-button
            {
                position: absolute;
            }
            #jQueryButton2 .ui-button-icon-primary
            {
                left: 10px;
            }
        </style>
        <script type="text/javascript" src="./jquery-1.6.4.min.js"></script>
        <script type="text/javascript" src="./jquery.ui.core.min.js"></script>
        <script type="text/javascript" src="./jquery.ui.widget.min.js"></script>
        <script type="text/javascript" src="./jquery.ui.datepicker.min.js"></script>
         <script type="text/javascript" src="./jquery.ui.datepicker-pt-BR.js"></script>
        <script type="text/javascript" src="./jquery.ui.button.min.js"></script>
        
        <script type="text/javascript">
            $(document).ready(function()
            {
                var edDataOpts =
                        {
                            dateFormat: 'dd/mm/yy',
                            changeMonth: false,
                            changeYear: false,
                            showButtonPanel: false,
                            showAnim: 'fadeIn'
                        };
                $("#edData").datepicker(edDataOpts);
                $("#jQueryButton1").button({icons: {primary: 'ui-icon-check'}});
                $("#jQueryButton2").button({icons: {primary: 'ui-icon-closethick'}});
            });

            function submit_my() {
                if (document.pesquisa_D.edData.value == '') {
                    alert('Você deve escolher uma data!');
                    document.pesquisa_D.edData.focus();
                } else {
                    document.pesquisa_D.submit();
                }

            }
        </script>
    </head>
    <body>
        <form name="pesquisa_D" action="" enctype="multipart/form-data" method="post">
            <div id="container"> 
                <div id="wb_Shape33" style="position:absolute;left:93px;top:188px;width:761px;height:151px;z-index:0;padding:0;"> 
                    <img src="images/body0232.gif" alt="" width="761" height="151" id="Shape33" style="border-width:0;width:761px;height:151px;" title=""></div>
                <div id="wb_Shape36" style="position:absolute;left:114px;top:194px;width:10px;height:136px;z-index:1;padding:0;"> 
                    <img src="images/img00190.png" alt="" width="10" height="136" id="Shape36" style="border-width:0;width:10px;height:136px;" title=""></div>
                <div id="wb_Text8" style="position:absolute;left:137px;top:197px;width:602px;height:18px;z-index:2;"> 
                    <span style="color:#000000;font-family:Verdana;font-size:15px;"><strong>Serviço 
                            de pesquisa - SGU</strong></span></div>
                <input type="text" id="edData" style="position:absolute;left:405px;top:231px;width:180px;height:18px;line-height:18px;z-index:4;" name="edData" value="" >
                <div id="wb_Text1" style="position:absolute;left:136px;top:234px;width:276px;height:16px;z-index:5;"> 
                    <span style="color:#000000;font-family:Verdana;font-size:13px;"><strong>Escolha 
                            uma data mostrar a diária</strong></span></div>
                <input type="button" id="jQueryButton1" name="btOK" value="OK" style="position:absolute;left:211px;top:293px;width:159px;height:35px;z-index:6;" onClick="submit_my();">
                </form>

            </div>
    </body>
</html>