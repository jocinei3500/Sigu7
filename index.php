<?php
session_start();
if (isset($_SESSION['erro'])) {
    if ($_SESSION['erro'] != 1) {
        $_SESSION['erro'] = 0;
    }
}
if (isset($_POST['edUser'])) {
    $user = $_POST['edUser'];
    $senha = $_POST['edSenha'];
    include 'conecta.php';
    $validaUser = mysql_query("select * from usuario where senha='$senha' and login='$user'");
    if (mysql_num_rows($validaUser) > 0) {
        $valores = mysql_fetch_array($validaUser);
        $_SESSION['usuario'] = $valores['nome'];
        $_SESSION['e-mail'] = $valores['e-mail'];
        $_SESSION['codigo'] = $valores['cod_user'];
        $_SESSION['logado'] = 'sim';
        $_SESSION['user_nivel']=$valores['nivel'];
        $_SESSION['user_status']=$valores['status'];
    } else {
        $erroLogin =1;
    }
}
if (empty($_SESSION['usuario'])) {
    $msg = 'Usuário não logado!';
} else {
    $msg = 'Olá ' . $_SESSION['usuario'];
}
?>
<html><head>
        <meta  charset="utf-8">
        <title>SIGU7.NET SOLUÇOES EM SISTEMAS WEB</title>
        <style type="text/css">

            body{
                background-color: #333333;
                background-image: url(none);
                color: #000000;
            }
            p, span, div, ol, ul, li, td, button, input, textarea, form
            {
                margin: 0;
                padding: 0;
            }

            a{
                color: #0000FF;
                outline: none;
                text-decoration: none;
            }
            a:visited{
                color: #800080;
            }
            a:active{
                color: #0000FF;
            }
            a:hover{
                color: #376BAD;
                text-decoration: underline;
            }

            #Image1
            {
                border: 0px #000000 solid;
            }
            #Image2
            {
                border: 0px #000000 solid;
            }
            #Image3
            {
                border: 0px #000000 solid;
            }
            #Image6
            {
                border: 0px #000000 solid;
            }
            #Image7
            {
                border: 0px #000000 solid;
            }
            #Image4
            {
                border: 0px #000000 solid;
            }
            #Image5
            {
                border: 0px #000000 solid;
            }
            #Image9
            {
                border: 0px #000000 solid;
            }
            #Image10
            {
                border: 0px #000000 solid;
            }
            #Image11
            {
                border: 0px #000000 solid;
            }
            #Image12
            {
                border: 0px #000000 solid;
            }
            #Image13
            {
                border: 0px #000000 solid;
            }
            #Image14
            {
                border: 0px #000000 solid;
            }
            #Image15
            {
                border: 0px #000000 solid;
            }
            #Image16
            {
                border: 0px #000000 solid;
            }
            #Image18
            {
                border: 0px #000000 solid;
            }
            #Image19
            {
                border: 0px #000000 solid;
            }
            #wb_Text2{
                background-color: transparent;
                border: 0px #000000 solid;
                padding: 0;
            }
            #wb_Text2 div{
                text-align: center;
            }
            #wb_Text3 
            {
                background-color: transparent;
                border: 0px #000000 solid;
                padding: 0;
            }
            #wb_Text3 div
            {
                text-align: left;
            }
            #Image17
            {
                border: 0px #000000 solid;
            }
            #wb_Text4 
            {
                background-color: transparent;
                border: 0px #000000 solid;
                padding: 0;
            }
            #wb_Text4 div
            {
                text-align: left;
            }
            #wb_Text13 
            {
                background-color: transparent;
                border: 0px #000000 solid;
                padding: 0;
            }
            #wb_Text13 div
            {
                text-align: left;
            }
            #wb_Text14 
            {
                background-color: transparent;
                border: 0px #000000 solid;
                padding: 0;
            }
            #wb_Text14 div
            {
                text-align: center;
            }
            #wb_Text15 
            {
                background-color: transparent;
                border: 0px #000000 solid;
                padding: 0;
            }
            #wb_Text15 div
            {
                text-align: left;
            }
            #wb_Text16 
            {
                background-color: transparent;
                border: 0px #000000 solid;
                padding: 0;
            }
            #wb_Text16 div
            {
                text-align: center;
            }
            #wb_Text17 
            {
                background-color: transparent;
                border: 0px #000000 solid;
                padding: 0;
            }
            #wb_Text17 div
            {
                text-align: left;
            }
            #Image40
            {
                border: 0px #000000 solid;
            }
            #Editbox1
            {
                border: 1px #C0C0C0 solid;
                background-color: #FFFFFF;
                color :#000000;
                font-family: 'Courier New';
                font-size: 13px;
                text-align: left;
                vertical-align: middle;
            }
            #Editbox2
            {
                border: 1px #C0C0C0 solid;
                background-color: #FFFFFF;
                color :#000000;
                font-family: 'Courier New';
                font-size: 13px;
                text-align: left;
                vertical-align: middle;
            }
            #Button1
            {
                color: #000000;
                font-family: Arial;
                font-size: 13px;
            }
            #wb_Text18 
            {
                background-color: transparent;
                border: 0px #000000 solid;
                padding: 0;
            }
            #wb_Text18 div
            {
                text-align: left;
            }
            #wb_Text19 
            {
                background-color: transparent;
                border: 0px #000000 solid;
                padding: 0;
            }
            #wb_Text19 div
            {
                text-align: left;
            }
            #Image41
            {
                border: 0px #000000 solid;
            }
            #wb_Text20 
            {
                background-color: transparent;
                border: 0px #000000 solid;
                padding: 0;
            }
            #wb_Text20 div
            {
                text-align: left;
            }
            #wb_Text21 
            {
                background-color: transparent;
                border: 0px #000000 solid;
                padding: 0;
            }
            #wb_Text21 div
            {
                text-align: left;
            }
            #wb_Text22 
            {
                background-color: transparent;
                border: 0px #000000 solid;
                padding: 0;
            }
            #wb_Text22 div
            {
                text-align: left;
            }
            #wb_Text23 
            {
                background-color: transparent;
                border: 0px #000000 solid;
                padding: 0;
            }
            #wb_Text23 div
            {
                text-align: left;
            }
            #wb_Text24 
            {
                background-color: transparent;
                border: 0px #000000 solid;
                padding: 0;
            }
            #wb_Text24 div
            {
                text-align: left;
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
            #Image8
            {
                border: 0px #000000 solid;
            }
            #wb_Text5 
            {
                background-color: transparent;
                border: 0px #000000 solid;
                padding: 0;
            }
            #wb_Text5 div
            {
                text-align: left;
            }
            #Image32
            {
                border: 0px #000000 solid;
            }
            #wb_CssMenu1 a
            {
                display: block;
                margin: 0px 0px 0px 0px;
                color: #FFFFFF;
                border: 0px #E6E6FA none;
                background-color: #666666;
                font-family: Arial;
                font-size: 13px;
                font-weight: normal;
                font-style: normal;
                text-decoration: none;
                width: 158px;
                height: 33px;
                vertical-align: middle;
                line-height: 33px;
                text-align: center;
            }
            #wb_CssMenu1 a:hover
            {
                color: #376BAD;
                background-color: #C0C0C0;
                border: 1px #376BAD none;
            }
            #RollOver1 a
            {
                display: block;
                position: relative;
            }
            #RollOver1 a img
            {
                position: absolute;
                z-index: 1;
                border-width: 0px;
            }
            #RollOver1 span
            {
                display: block;
                height: 31px;
                width: 30px;
                position: absolute;
                z-index: 2;
            }
            #RollOver1 a .hover
            {
                visibility: hidden;
            }
            #RollOver1 a:hover .hover
            {
                visibility: visible;
            }
            #RollOver1 a:hover span
            {
                visibility: hidden;
            }
        </style>
        <script type="text/javascript">
            <!--
            function MM_reloadPage(init) {  //reloads the window if Nav4 resized
                if (init == true)
                    with (navigator) {
                        if ((appName == "Netscape") && (parseInt(appVersion) == 4)) {
                            document.MM_pgW = innerWidth;
                            document.MM_pgH = innerHeight;
                            onresize = MM_reloadPage;
                        }
                    }
                else if (innerWidth != document.MM_pgW || innerHeight != document.MM_pgH)
                    location.reload();
            }
            MM_reloadPage(true);
            //-->

            function linkIndex() {
                window.location = 'sign_up.php';
            }

            function v_login() {
                if (document.getElementById('edLogin').value == '') {
                    alert('Campo usuário em branco!');
                    document.getElementById('edLogin').focus();
                } else if (document.login.edSenha.value == '') {
                    alert('Campo Senha em branco!');
                    document.getElementById('edSenha').focus();
                } else {
                    document.login.submit();
                }

            }
        </script>

    </head>
    <body onload="
    <?php
    if (isset($_SESSION['erro'])) {
        if ($_SESSION['erro']==1){
            echo'alert(`Você nõo está logado faça seu login!`);document.getElementById(`edLogin`).focus();'; 
            $_SESSION['erro'] == 0;
        }
    }
    
    if(isset($erroLogin)){
        if($erroLogin=1){
            echo 'alert(Usuário ou senha incorretos);';
        }  
    }
        }
  
    ?>
          ">
        <div id="wb_Image1" style="position:absolute;left:152px;top:1px;width:995px;height:734px;z-index:0;padding:0;">
            <img src="SIGU7_arquivos/img0001.png" id="Image1" alt="" style="width:995px;height:734px;" border="0"></div>
        <div id="wb_Image2" style="position:absolute;left:169px;top:346px;width:1px;height:300px;z-index:1;padding:0;">
            <img src="SIGU7_arquivos/img0002.gif" id="Image2" alt="" style="width:1px;height:300px;" border="0"></div>
        <div id="wb_Image3" style="position:absolute;left:916px;top:346px;width:1px;height:300px;z-index:2;padding:0;">
            <img src="SIGU7_arquivos/img0003.gif" id="Image3" alt="" style="width:1px;height:300px;" border="0"></div>
        <div id="wb_Image6" style="position:absolute;left:154px;top:66px;width:994px;height:50px;z-index:3;padding:0;">
            <img src="SIGU7_arquivos/img0005.gif" id="Image6" alt="" style="width:994px;height:50px;" border="0"></div>
        <div id="wb_Image7" style="position:absolute;left:151px;top:115px;width:997px;height:22px;z-index:4;padding:0;">
            <img src="SIGU7_arquivos/img0006.gif" id="Image7" alt="" style="width:997px;height:22px;" border="0"></div>
        <div id="wb_Image4" style="position:absolute;left:154px;top:137px;width:991px;height:50px;z-index:5;padding:0;">
            <img src="SIGU7_arquivos/img0004.gif" id="Image4" alt="" style="width:991px;height:50px;" border="0"></div>
        <div id="wb_Image9" style="position:absolute;left:169px;top:157px;width:236px;height:137px;z-index:7;padding:0;">
            <img src="SIGU7_arquivos/img0007.png" id="Image9" alt="" style="width:236px;height:137px;" border="0"></div>
        <div id="wb_Image10" style="position:absolute;left:385px;top:166px;width:10px;height:119px;z-index:8;padding:0;">
            <img src="SIGU7_arquivos/img0008.png" id="Image10" alt="" style="width:10px;height:119px;" border="0"></div>
        <div id="wb_Image11" style="position:absolute;left:413px;top:157px;width:236px;height:137px;z-index:9;padding:0;">
            <img src="SIGU7_arquivos/img0009.png" id="Image11" alt="" style="width:236px;height:137px;" border="0"></div>
        <div id="wb_Image12" style="position:absolute;left:631px;top:164px;width:10px;height:119px;z-index:10;padding:0;">
            <img src="SIGU7_arquivos/img0010.png" id="Image12" alt="" style="width:10px;height:119px;" border="0"></div>
        <div id="wb_Image13" style="position:absolute;left:657px;top:157px;width:236px;height:137px;z-index:11;padding:0;">
            <img src="SIGU7_arquivos/img0011.png" id="Image13" alt="" style="width:236px;height:137px;" border="0"></div>
        <div id="wb_Image14" style="position:absolute;left:873px;top:166px;width:10px;height:119px;z-index:12;padding:0;">
            <img src="SIGU7_arquivos/img0012.png" id="Image14" alt="" style="width:10px;height:119px;" border="0"></div>
        <div id="wb_Image15" style="position:absolute;left:168px;top:308px;width:776px;height:367px;z-index:13;padding:0;">
            <img src="SIGU7_arquivos/img0013.png" id="Image15" alt="" style="width:776px;height:367px;" border="0"></div>
        <div id="wb_Image16" style="position:absolute;left:289px;top:8px;width:991px;height:89px;z-index:14;padding:0;">
            <img src="SIGU7_arquivos/img0014.png" id="Image16" alt="" style="width:991px;height:89px;" border="0"></div>
        <div id="wb_Image18" style="position:absolute;left:190px;top:334px;width:215px;height:327px;z-index:15;padding:0;">
            <img src="SIGU7_arquivos/img0024.png" id="Image18" alt="" style="width:215px;height:327px;" border="0"></div>
        <div id="wb_Image19" style="position:absolute;left:156px;top:713px;width:988px;height:22px;z-index:16;padding:0;">
            <img src="SIGU7_arquivos/img0025.gif" id="Image19" alt="" style="width:988px;height:22px;" border="0"></div>
        <div id="wb_Text2" style="position:absolute;left:204px;top:164px;width:156px;height:120px;text-align:center;z-index:17;">
            <span style="color:#CC0000;font-family:Impact;font-size:48px;">SGU.NET</span></div>
        <div id="wb_Text3" style="position:absolute;left:427px;top:162px;width:186px;height:120px;z-index:18;">
            <span style="color:#FFCC00;font-family:Impact;font-size:48px;">SGU.DESK</span></div>
        <div id="wb_Image17" style="position:absolute;left:287px;top:7px;width:860px;height:84px;z-index:19;padding:0;">
            <img src="SIGU7_arquivos/img0015.png" id="Image17" alt="" style="width:860px;height:84px;" border="0"></div>
        <div id="wb_Text4" style="position:absolute;left:670px;top:161px;width:195px;height:120px;z-index:20;">
            <span style="color:#3C3CFF;font-family:Impact;font-size:48px;">DATABASE</span></div>
        <div id="wb_Text13" style="position:absolute;left:672px;top:217px;width:188px;height:26px;z-index:21;">
            <span style="color:#7F7F7F;font-family:Verdana;font-size:11px;">Banco de dados MYSQL 5.0<br>ORACLE ENTERPRISE.</span></div>
        <div id="wb_Text14" style="position:absolute;left:216px;top:591px;width:166px;height:52px;text-align:center;z-index:22;">
            <span style="color:#7F7F7F;font-family:Tahoma;font-size:11px;">Copyright � 2013 Jocinei da Rosa<br>Todos os direitos reservados<br>E-Mail: jocinei300@gmail.com</span></div>
        <div id="wb_Text15" style="position:absolute;left:404px;top:120px;width:128px;height:12px;z-index:23;">
            <span style="color:#FFFFFF;font-family:Arial;font-size:9.3px;">Criado por Jocinei da Rosa</span></div>
        <div id="wb_Text16" style="position:absolute;left:170px;top:716px;width:528px;height:26px;text-align:center;z-index:24;">
            <span style="color:#7F7F7F;font-family:Tahoma;font-size:11px;">Copyright
                � 2013 Jocinei da Rosa&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; 
                &nbsp;&nbsp; &nbsp;&nbsp; Todos os direitos reservados&nbsp;&nbsp; 
                &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; E-Mail: 
                jocinei300@gmail.com</span></div>

        <div id="Layer2" style="position:absolute; left:922px; top:117px; width:198px; height:20px; z-index:45"><font color="#CCCCCC"><?php echo$msg; ?></font></div>



        <div id="wb_Image5" style="position:absolute;left:900px;top:157px;width:236px;height:137px;z-index:6;padding:0;"> 
            <img src="SIGU7_arquivos/img0011.png" id="Image13" alt="" style="width:236px;height:137px;" border="0">
        </div>
        <!-- Se est� logado --> 


        <?php
        if (isset($_SESSION['logado'])) {
            if ($_SESSION['logado'] == 'sim') {
                echo '
                    <div id="wb_Text6" style="position:absolute;left:1018px;top:163px;width:127px;height:17px;z-index:100;">
<span style="color:#FF6820;font-family:Arial;font-size:15px;">';
                echo$_SESSION['usuario'];
                echo'</span></div>

<div id="wb_Text6" style="position:absolute;left:910px;top:170px;width:190px;height:17px;z-index:100;">
<img alt="" title="configura��es" src="mostra_foto_user.php?cod=' . $_SESSION['codigo'] . '" style="left:0px;top:0px;width:70px;height:65px"></div>

<div id="wb_Text7" style="position:absolute;left:995px;top:188px;width:160px;height:16px;z-index:100;">
<span style="color:#FF6820;font-family:Arial;font-size:13px;">';
                echo$_SESSION['e-mail'];
                echo'</span></div>                    
<div id="wb_Image5" style="position:absolute;left:902px;top:246px;width:236px;height:1px;z-index:100;padding:0;">
                       <img src="images/line_division.gif" id="Image5" alt="" title="" style="width:236px;height:1px;"></div>
<input type="submit" id="Button1" name="btSair" value="Sair" style="position:absolute;left:1035px;top:252px;width:96px;height:25px;z-index:100;" onClick="linkIndex();">                       
<div id="RollOver1" style="position:absolute;overflow:hidden;left:913px;top:252px;width:30px;height:31px;z-index:100"> 
  <a href=""> <img class="hover" alt="" title="configura��es" src="images/conf2.png" style="left:0px;top:0px;width:30px;height:31px;"> 
  <span><img alt="" title="configura��es" src="images/conf1.png" style="left:0px;top:0px;width:30px;height:31px"></span> 
  </a> </div>

';
            } else {
                echo'
                    <div id="wb_Text17" style="position:absolute;left:910px;top:160px;width:65px;height:68px;z-index:25;"> 
                      <span style="color:#FF6820;font-family:Impact;font-size:27px;">LOGIN</span></div>
                    <div id="wb_Image40" style="position:absolute;left:1120px;top:170px;width:10px;height:119px;z-index:26;padding:0;"> 
                      <img src="SIGU7_arquivos/img0017.png" id="Image40" alt="" style="width:10px;height:119px;" border="0"></div>  
                            <form action="" name="login" method="post" enctype="multipart/form-data">     
                      <input id="edLogin" style="position:absolute;left:910px;top:200px;width:116px;height:18px;line-height:18px;z-index:27;" name="edUser" type="text">       
                      <input id="edSenha" style="position:absolute;left:910px;top:225px;width:116px;height:18px;line-height:18px;z-index:28;" name="edSenha" type="password">      
                      <input id="btEntrar" name="btEntrar" value="ENTRAR" style="position:absolute;left:910px;top:260px;width:118px;height:25px;z-index:29;" type="button" onClick="v_login();">     
                    <div id="wb_Text18" style="position:absolute;left:1040px;top:230px;width:41px;height:26px;z-index:30;"> 
                      <span style="color:#7F7F7F;font-family:Verdana;font-size:11px;">SENHA</span></div> 
                    <div id="wb_Text19" style="position:absolute;left:1040px;top:200px;width:56px;height:26px;z-index:31;"> 
                      <span style="color:#7F7F7F;font-family:Verdana;font-size:11px;">USU�RIO</span></div>
                             </form>
                        ';
            }
        } else {
            echo'
                    <div id="wb_Text17" style="position:absolute;left:910px;top:160px;width:65px;height:68px;z-index:25;"> 
                      <span style="color:#FF6820;font-family:Impact;font-size:27px;">LOGIN</span></div>
                    <div id="wb_Image40" style="position:absolute;left:1120px;top:170px;width:10px;height:119px;z-index:26;padding:0;"> 
                      <img src="SIGU7_arquivos/img0017.png" id="Image40" alt="" style="width:10px;height:119px;" border="0"></div>  
                            <form action="" name="login" method="post" enctype="multipart/form-data">     
                      <input id="edLogin" style="position:absolute;left:910px;top:200px;width:116px;height:18px;line-height:18px;z-index:27;" name="edUser" type="text">       
                      <input id="edSenha" style="position:absolute;left:910px;top:230px;width:116px;height:18px;line-height:18px;z-index:28;" name="edSenha" type="password">      
                      <input id="btEntrar" name="btEntrar" value="ENTRAR" style="position:absolute;left:910px;top:260px;width:118px;height:25px;z-index:29;" type="button"  onClick="v_login();">     
                    <div id="wb_Text18" style="position:absolute;left:1040px;top:230px;width:41px;height:26px;z-index:30;"> 
                      <span style="color:#7F7F7F;font-family:Verdana;font-size:11px;">SENHA</span></div> 
                    <div id="wb_Text19" style="position:absolute;left:1040px;top:200px;width:56px;height:26px;z-index:31;"> 
                      <span style="color:#7F7F7F;font-family:Verdana;font-size:11px;">USU�RIO</span></div>
                             </form>
                        ';
        }
        ?>


        <div id="wb_Image41" style="position:absolute;left:415px;top:23px;width:131px;height:64px;z-index:32;padding:0;">
            <img src="SIGU7_arquivos/img0018.png" id="Image41" alt="" style="width:131px;height:64px;" border="0"></div>

        <div id="wb_Text20" style="position:absolute;left:427px;top:24px;width:79px;height:120px;z-index:33;"> 
            <span style="color:#3C3CFF;font-family:Impact;font-size:48px;">S<font size="6">i</font>GU</span></div>

        <div id="wb_Text21" style="position:absolute;left:516px;top:24px;width:30px;height:120px;z-index:34;"> 
            <span style="color:#CC0000;font-family:Impact;font-size:48px;">7.</span></div>

        <div id="wb_Text22" style="position:absolute;left:556px;top:29px;width:59px;height:106px;z-index:35;"> 
            <span style="color:#FFFFFF;font-family:Impact;font-size:43px;">net</span></div>
        <div id="wb_Text23" style="position:absolute;left:191px;top:220px;width:177px;height:65px;z-index:36;">
            <span style="color:#7F7F7F;font-family:Verdana;font-size:11px;">Sistema de gerenciamento de usina de asfalto, acompanhamento di�rio de produ��o e controle de maquin�rio.</span></div>
        <div id="wb_Text24" style="position:absolute;left:437px;top:220px;width:181px;height:52px;z-index:37;">
            <span style="color:#7F7F7F;font-family:Verdana;font-size:11px;">Baixe a vers�o sgu desktop e instale em seu computador, esta vers�o s� fucniona com o computador ligado � internet.</span></div>
        <div id="wb_Text1" style="position:absolute;left:316px;top:31px;width:94px;height:106px;z-index:38;">
            <span style="color:#FFFFFF;font-family:Impact;font-size:43px;">www.</span></div>

        <div id="wb_Image8" style="position:absolute;left:108px;top:0px;width:158px;height:158px;z-index:39;padding:0;"> 
            <img src="SIGU7_arquivos/banco-de-dados-web.png" id="Image8" alt="" style="width:158px;height:158px;" border="0"></div>


        <div id="wb_Text5" style="position:absolute;left:857px;top:53px;width:283px;height:29px;z-index:40;"> 
            <span style="color:#FFFFFF;font-family:Impact;font-size:24px;">Solu��es web 
                &amp; desktop</span></div>

        <div id="wb_Image32" style="position:absolute;left:413px;top:410px;width:501px;height:340px;z-index:42;padding:0;">
            <img src="SIGU7_arquivos/banner-4.png" id="Image32" alt="" style="width:501px;height:340px;" border="0"></div>
        <div id="wb_CssMenu1" style="position:absolute;left:212px;top:348px;width:160px;height:208px;text-align:center;z-index:43;padding:0;">
            <a href="index.php">IN�CIO</a>
            <a href="escolha_usina.php">SISTEMA&nbsp;SGU1.0</a>
            <a href="">SOBRE&nbsp;N�S</a>
            <a href="">CONTATO</a>
            <a href="">SUPORTE&nbsp;TÉCNICO</a>
            <a href="cadastro_usinas.php">CADASTRO DE USINA</a>
        </div>


        <div id="Layer1" style="position:absolute; left:987px; top:300px; width:146px; height:200px; z-index:44"> 
            <iframe src='http://selos.climatempo.com.br/selos/MostraSelo.php?CODCIDADE=4195,278,277,1316,271&SKIN=preto' scrolling='no' frameborder='0' width=150 height='170' marginheight='0' marginwidth='0'></iframe>
        </div>
        <input type="hidden" name="erro" value="0">
        <img src="SIGU7_arquivos/img0016.png" id="Image5" alt="" style="width:236px;height:137px;" border="0"> 
    </body></html>