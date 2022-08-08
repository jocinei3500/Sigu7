<?php
include 'logado.php';
?>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">

        <title>SIGU7  - SELECIONE A FILIAL QUE DESEJA VIZUALIZAR</title>
        <meta name="generator" content="WYSIWYG Web Builder 8 - http://www.wysiwygwebbuilder.com">
        <style type="text/css">
            body
            {
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
                color: #C8D7EB;
                outline: none;
                text-decoration: underline;
            }
            a:visited
            {
                color: #C8D7EB;
            }
            a:active
            {
                color: #C8D7EB;
            }
            a:hover
            {
                color: #376BAD;
                text-decoration: underline;
            }
        </style>
        <style type="text/css">
            #Combobox1
            {
                border: 1px #C0C0C0 solid;
                background-color: #FFFFFF;
                color: #000000;
                font-family: Arial;
                font-size: 13px;
            }
            #Button1
            {
                color: #000000;
                font-family: Arial;
                font-size: 13px;
            }
        </style>
        <script>
            function vSelect()
            {
            if (document.fEscolhaUsina.unidade_usina.value != '0') {
            document.fEscolhaUsina.submit();
            } else {
            alert('Escolha uma unidade de Usina');
            document.fEscolhaUsina.unidade_usina.focus;
            }

            }


        </script>
    </head>
    <body>


        <form action="diaria_usina.php" method="post" name="fEscolhaUsina">
            <div id="wb_Shape1" style="position:absolute;left:90px;top:78px;width:702px;height:430px;z-index:0;padding:0;"> 
                <img src="images/img0002.gif" alt="" width="702" height="430" id="Shape1" style="border-width:0;width:702px;height:430px;" title=""></div>
            <img src="images/img0003.jpg" alt="Escolha a Unidade Industrial" width="539" height="43" id="Banner1" style="position:absolute;left:140px;top:116px;width:539px;height:43px;border-width:0;z-index:1;"> 
            <select name='unidade_usina' size='1' id='unidade_usina' style='position:absolute;left:252px;top:169px;width:315px;height:20px;z-index:2;'>
                <option value="0">Escolha uma Unidade de Usina</option>


                <?php
                include 'conecta.php';
                $sql_cat = mysql_query("SELECT * FROM usinas") or die(mysql_error());
                while ($valor = mysql_fetch_array($sql_cat)) {
                    echo "<option value=$valor[0]>$valor[2]</option>";
                }
                ?>
            </select>
            <input type="button" id="Button1" name="btOk" value="    Ok    " 
                   style="position:absolute;left:471px;top:192px;width:96px;height:25px;z-index:3;" 
                   onClick="vSelect();">
        </form>
    </body></html>