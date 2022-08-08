<?php
include 'logado.php';
date_default_timezone_set('America/Sao_Paulo');
$data = date("d/m/Y");
$datadb=  explode('/', $data);
$datadb=$datadb[2].'-'.$datadb[1].'-'.$datadb[0];
include 'conecta.php';
$unidadeusina = $_POST['unidade_usina'];
$_SESSION['cod_usina'] = $unidadeusina;
$consulta = mysql_query("select * from usinas where cod_usina= $unidadeusina");
$valor = mysql_fetch_array($consulta);
$endereco = $valor['endereco'];
$cidade = $valor['cidade'];
$obra_contrato = $valor['Obra_contrato'];
$rodovia_trecho = $valor['Rodovia_trecho'];
$cap_cap = $valor['capacidade_cap'];
$cap_xisto = $valor['capacidade_xisto'];
$cap_die_cald = $valor['capacidade_die_cald'];
$cap_ger = $valor['capacidade_gerador'];
$cap_res_die = $valor['capacidade_res_diesel'];

//engenheiro respons√°vel----------------------------

$eng_responsavel = $valor['eng_responsavel'];
if ($eng_responsavel == null) {
	$eng_responsavel2 = '<font><strong><a href="cadastro_usinas.php">cadastre o engenheiro respons&aacute;vel</a> </strong></font>  ';
} else {

	$consulta2 = mysql_query("select nome,sobrenome from colaborador where cod_colaborador= $eng_responsavel");
	$valor2 = mysql_fetch_array($consulta2);
	$eng_responsavel2 = $valor2['nome'] . " " . $valor2['sobrenome'];
}

//engenheiro de opera√ß√£o------------------------------

$eng_operacao = $valor['eng_operacao'];
if ($eng_operacao == null) {
	$eng_operacao2 = '<font><strong><a href="cadastro_usinas.php">cadastre o engenheiro de opera&ccedil;&atilde;o</a> </strong></font> ';
} else {

	$consulta3 = mysql_query("select nome,sobrenome from colaborador where cod_colaborador= $eng_operacao");
	$valor3 = mysql_fetch_array($consulta3);
	$eng_operacao2 = $valor3['nome'] . " " . $valor3['sobrenome'];
}

//encarregado-----------------------------------------------

$encarregado = $valor['encarregado'];
if ($encarregado == null) {
	$encarregado2 = '<font><strong><a href="cadastro_usinas.php">cadastre o encarregado de usina</a> </strong></font> ';
} else {
	$consulta4 = mysql_query("select nome,sobrenome from colaborador where cod_colaborador= $encarregado");
	$valor4 = mysql_fetch_array($consulta4);
	$encarregado2 = $valor4['nome'] . " " . $valor4['sobrenome'];
}

//operador da usina--------------------------------------------------

$operador = $valor['operador'];
if ($operador == null) {
	$operador2 = '<font><strong><a href="cadastro_usinas.php">cadastre o operador da usina</a> </strong></font>';
} else {
	$consulta5 = mysql_query("select nome,sobrenome from colaborador where cod_colaborador= $operador");
	$valor5 = mysql_fetch_array($consulta5);
	$operador2 = $valor5['nome'] . " " . $valor5['sobrenome'];
}

//_____________________________________________________________________________
//busca hor√≠metro final da usina
$consUsina = mysql_query("select horimetro_final from op_usina where data=(select max(data) from op_usina where data< '$datadb')");
$val_op_usina = mysql_fetch_array($consUsina);
$horimetro_inicial = $val_op_usina['horimetro_final'];
//______________________________________________________________________________________
//Busca hor√≠tro final do gerador
$consHorimGerador = mysql_query("select max(horimetro_final) as horim_final from op_gerador");
$val_horim_ger = mysql_fetch_array($consHorimGerador);
$horim_ini_ger = $val_horim_ger['horim_final'];
//------------------------------------------------------------------------------------------
//Busca hor√≠metro final da caldeira
$consHorimCaldeira = mysql_query("select max(horimetro_final) as horim_final from op_caldeira");
$val_horim_cald = mysql_fetch_array($consHorimCaldeira);
$horim_ini_cald = $val_horim_cald['horim_final'];

//-----------------------------------------------------------------------------------------------
//DEFINE ESTOQUE FINAL DE CAP
$consEntradaCap = mysql_query("select sum(quant) as quant_cap from entrada_material where usina=$unidadeusina and material=1");
$total_ent_cap = mysql_fetch_array($consEntradaCap);
$total_ent_cap = $total_ent_cap[0];
$consConsumoCap = mysql_query("select sum(quant) as consumo_cap from consumo_material where equipamento=2");
$total_Consumo_cap = mysql_fetch_array($consConsumoCap);
$total_Consumo_cap = $total_Consumo_cap['consumo_cap'];
$EstoqueFinal = $total_ent_cap - $total_Consumo_cap;
//------------------------------------------------------------------------------------------
//DEFINE ESTOQUE FINAL DE XISTO
$consEstqXisto = mysql_query("select sum(quant) as t_ent_x from entrada_material where usina=$unidadeusina and material=3");
$val_ent_x = mysql_fetch_array($consEstqXisto);
$total_ent_x = $val_ent_x['t_ent_x'];
$consEstqXisto = mysql_query("select sum(quant) as t_c_x from consumo_material where equipamento=5 ");
$val_cons_x = mysql_fetch_array($consEstqXisto);
$total_cons_x = $val_cons_x['t_c_x'];
$estqFinalX = $total_ent_x - $total_cons_x;
//----------------------------------------------
//DEFINE ESTOQUE DE DIESEL DA CALDEIRA
$consEstqDieCald = mysql_query("select sum(quant) as t_ent_die_cald from abastecimentos where equipamento=1");
$val_ent_die_cald = mysql_fetch_array($consEstqDieCald);
$total_ent_die_cald = $val_ent_die_cald['t_ent_die_cald'];
$consEstqDieCald = mysql_query("select sum(quant) as t_c_d_c from consumo_material where equipamento=1");
$val_cons_die_cald = mysql_fetch_array($consEstqDieCald);
$total_cons_die_cald = $val_cons_die_cald['t_c_d_c'];
$estqFinalDieCald = $total_ent_die_cald - $total_cons_die_cald;
//---------------------------------------------------------------------------------------
//DEFINE ESTOQUE FINAL DE DIESEL GERADOR
$consEstqDieGer = mysql_query("select sum(quant) as t_ent_die_ger from abastecimentos where equipamento=3 ");
$val_ent_die_ger = mysql_fetch_array($consEstqDieGer);
$total_ent_die_ger = $val_ent_die_ger['t_ent_die_ger'];
$consEstqDieGer = mysql_query("select sum(quant) as t_c_d_g from consumo_material where equipamento=3");
$val_cons_die_ger = mysql_fetch_array($consEstqDieGer);
$total_cons_die_ger = $val_cons_die_ger['t_c_d_g'];
$estqFinalDieGer = $total_ent_die_ger - $total_cons_die_ger;
//----------------------------------------------------------------------------------------
//DEFINE ESTOQUE FINAL DE CAL
$consEstqCal = mysql_query("select sum(quant) as t_ent_cal from entrada_material where usina=$unidadeusina and material=8");
$val_ent_cal = mysql_fetch_array($consEstqCal);
$total_ent_cal = $val_ent_cal['t_ent_cal'];
$consEstqCal = mysql_query("select sum(quant) as t_c_c from consumo_material where equipamento =9");
$val_cons_cal = mysql_fetch_array($consEstqCal);
$total_cons_cal = $val_cons_cal['t_c_c'];
$estqFinalCal = $total_ent_cal - $total_cons_cal;

//----------------------------------------------------------------------------------------
//DEFINE ESTOQUE FINAL DE DIESEL
$consEstqD = mysql_query("select sum(quant) as t_ent_d from entrada_material where usina=$unidadeusina and material=4");
$val_ent_d = mysql_fetch_array($consEstqD);
$total_ent_d = $val_ent_d['t_ent_d'];
$consEstqD = mysql_query("select sum(quant) as t_c_d from consumo_material where material=4");
$val_cons_d = mysql_fetch_array($consEstqD);
$total_cons_d = $val_cons_d['t_c_d'];
$estqFinalD = $total_ent_d - $total_cons_d;
//----------------------------------------------------------------
?>
 
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Usina de Asfalto de <?php echo "$cidade"; ?></title>
<script src='verifica_erros.js'></script>
<script src="diaria_usina.js"></script>
<script src="medidas.js"></script>
<script src="jquery-1.6.4.min.js" ></script>
<script src="jquery.maskedinput.min.js"></script>
<link rel="stylesheet" href="diaria_usina.css">
<style type="text/css">
#wb_Form1 {
	-moz-border-radius: 9px;
	-webkit-border-radius: 9px;
	border-radius: 9px;
}
</style>
<script language="JavaScript" type="text/JavaScript">
            <!--
            function MM_reloadPage(init) {  //reloads the window if Nav4 resized
            if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
            document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
            else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
            }
            MM_reloadPage(true);

            function MM_preloadImages() { //v3.0
            var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
            var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
            if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
            }

            function MM_swapImgRestore() { //v3.0
            var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
            }

            function MM_findObj(n, d) { //v4.01
            var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
            d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
            if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
            for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
            if(!x && d.getElementById) x=d.getElementById(n); return x;
            }

            function MM_swapImage() { //v3.0
            var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
            if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
            }
            //-->
        </script>
       <script type="text/javascript">
       function cancelBack()
    {
        if ((event.keyCode == 8 ||
           (event.keyCode == 37 && event.altKey) ||
           (event.keyCode == 39 && event.altKey))
            &&
           (event.srcElement.form == null || event.srcElement.isTextEdit == false)
          )
        {
            event.cancelBubble = true;
            event.returnValue = false;
        }
    }
  
</script>  
</head>


<body onkeydown="cancelBack();"
    onLoad="MM_preloadImages('images/13.bmp', 'images/9_.bmp', 'images/home.bmp', 'images/7.bmp', 'images/limpar.bmp', 'images/email.bmp', 'images/fechar.bmp');
" onkeydown="return backspace;">
	<table
		style="position: absolute; left: 112px; top: 0px; width: 946px; height: 67px; z-index: 10;"
		cellpadding="0" cellspacing="0" id="tabelaLabel">
		<tbody>
			<tr>
				<td width="70" height="51"
					style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;">
					<a href="#" onMouseOut="MM_swapImgRestore()"
					onMouseOver="MM_swapImage('home', '', 'images/home.bmp', 1)" onClick="
                                        if(confirm('Voltar a p·gina inicial?')){
                                            location.href=('index.php')
                                        }
                                        "> <img
						src="images/home.png" name="home" width="48" height="48"
						border="0"> </a></td>

				<td width="70"
					style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;">
					<a href="#" onMouseOut="MM_swapImgRestore()"
					onMouseOver="MM_swapImage('salvar', '', 'images/7.bmp', 1)"
					onClick="
                                             <?php
                                       if($_SESSION['user_nivel']>1) {
                                           echo" verificaErros();";
                                               }else{
                                           echo"alert('Usu·rio sem permiss„o para esta funÁ„o\\n\Se necess·rio peÁa permiss„o para o supervisor\\n\Ou entre em contato pelo e-mail: jocinei300@gmail.com!\\n\ Jocinei(c)2013');"; 
                                            }?>
                            "> <img src="images/7_.png" name="salvar"
						width="48" height="48" border="0"> </a></td>

				<td width="70"
					style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;">
					<a href="#" onMouseOut="MM_swapImgRestore()"
					onMouseOver="MM_swapImage('pesquisar', '', 'images/pesquisar.bmp', 0)"
                                        onClick="
                                        if(confirm('Pesquisar di·ria?')){
                                            location.href=('pesquisa_diaria.php')
                                        }
                                        ">
						<img src="images/pesquisar.png" name="pesquisar" width="48"
						height="48" border="0"> </a>
				</td>
				<td width="70"
					style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;"><a
					href="#" onMouseOut="MM_swapImgRestore()"
					onMouseOver="MM_swapImage('editar', '', 'images/13.bmp', 1)"><img
						src="images/13_.png" name="editar" width="48" height="48"
						border="0"> </a></td>
				<td width="70"
					style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;"><a
					href="#" onMouseOut="MM_swapImgRestore()"
					onMouseOver="MM_swapImage('excluir', '', 'images/9_.bmp', 1)"><img
						src="images/9.png" name="excluir" width="48" height="48"
						border="0"> </a></td>
				<td width="70"
					style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;"><a
					href="#" onMouseOut="MM_swapImgRestore()"
					onMouseOver="MM_swapImage('limpar', '', 'images/limpar.bmp', 1)"><img
						src="images/limpar.png" name="limpar" width="48" height="48"
						border="0"> </a></td>
				<td width="70"
					style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;"><a
					href="#" onMouseOut="MM_swapImgRestore()"
					onMouseOver="MM_swapImage('email', '', 'images/email.bmp', 1)"><img
						src="images/74.png" name="email" width="48" height="48" border="0">
				</a></td>
				<td width="70"
					style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;"><a
					href="#" onClick="if (confirm('[    LOG OFF!   ]\n\n\VocÍ deseja mesmo sair?')){window.location=('sign_up.php');}" onMouseOut="MM_swapImgRestore()"
					onMouseOver="MM_swapImage('fechar', '', 'images/fechar.bmp', 1)"><img
						src="images/fechar.png" name="fechar" width="48" height="48"
						border="0"> </a></td>
				<td width="460"
					style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;">&nbsp;</td>
			</tr>
			<tr>
				<td width="70"
					style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;"><font
					color="#999999" size="2">Inicio </font>
				
				<td width="70"
					style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;"><font
					color="#999999" size="2">Salvar </font>
				
				<td width="70"
					style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;"><font
					color="#999999" size="2">Pesquisar</font>
				
				<td width="70"
					style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;"><font
					color="#999999" size="2">Editar </font>
				
				<td width="70"
					style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;"><font
					color="#999999" size="2">Excluir </font>
				
				<td width="70"
					style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;"><font
					color="#999999" size="2">Limpar </font>
				
				<td width="70"
					style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;"><font
					color="#999999" size="2">Enviar Di&aacute;ria</font>
				
				<td width="70"
					style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;"><font
					color="#999999" size="2">Sair</font>
			
			</tr>


		</tbody>
	</table>
	<a href="#" onMouseOut="MM_swapImgRestore()"
		onMouseOver="MM_swapImage('Image4', '', 'images/7.bmp', 1)"> </a>
	<div id="wb_Form1"
		style="position: absolute; left: 80px; top: 81px; width: 990px; height: 1318px; z-index: 0;">
		<form action="grava_diaria.php" method="post" name="diaria"
			enctype="multipart/form-data">

			<table
				style="position: absolute; left: 32px; top: 10px; width: 946px; height: 62px; z-index: 0;"
				cellpadding="0" cellspacing="0" id="tabelaLabel">
				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; width: 180px; height: 58px;">&nbsp;
						</td>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: top; width: 428px; height: 58px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">
									AV. C&Acirc;NDIDO DE ABREU, N&ordm; 776, 23&ordm; ANDAR</span>
							</div>
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">CEP.:
									80.530-000 CURITIBA/PR</span>
							</div>
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">FONE/FAX:
									(41) 3075-9000</span>
							</div>
						</td>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: top; height: 58px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 19px;">
									Acompanhamento Di&aacute;rio da Usina</span>
							</div>
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 19px;">de
									Asfalto de <?php echo "$endereco"; ?> </span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<div id="wb_Image1"
				style="position: absolute; left: 31px; top: 12px; width: 181px; height: 59px; z-index: 1; padding: 0;">
				<img src="images/LOGO%20E-MAIL.png" alt="" width="116" height="34"
					border="0" id="Image1" style="width: 181px; height: 59px;">
			</div>
			<table
				style="position: absolute; left: 30px; top: 72px; width: 184px; height: 128px; z-index: 2;"
				cellpadding="0" cellspacing="0" id="tabelaLabel">
				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: right; vertical-align: top; height: 19px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">
									Obra/Contrato:</span>
							</div>
						</td>
					</tr>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: right; vertical-align: top; height: 19px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">
									Rodovia/Trecho</span>
							</div>
						</td>
					</tr>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: right; vertical-align: top; height: 19px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">
									Local</span>
							</div>
						</td>
					</tr>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: right; vertical-align: top; height: 19px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">
									Eng. Respons&aacute;vel</span>
							</div>
						</td>
					</tr>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: right; vertical-align: top; height: 19px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">
									Eng. Opera&ccedil;&atilde;o</span>
							</div>
						</td>
					</tr>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: right; vertical-align: top; height: 19px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">
									Encarregado</span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<table cellpadding="0" cellspacing="0" id="tabelaLabel"
				style="position: absolute; left: 30px; top: 198px; width: 613px; height: 22px; z-index: 3;"
				name="tabelaLabel">
				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: top; height: 18px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">
									INFORMA&Ccedil;&Otilde;ES SOBRE O FUNCIONAMENTO DA USINA DE
									ASFALTO</span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<div id="wb_Image2"
				style="position: absolute; left: 642px; top: 148px; width: 334px; height: 157px; z-index: 4; padding: 0;">
				<img src="images/u3.jpg" alt="" width="3993" height="2110"
					border="0" id="Image2" style="width: 334px; height: 157px;">
			</div>
			<table
				style="position: absolute; left: 30px; top: 240px; width: 76px; height: 68px; z-index: 5;"
				cellpadding="0" cellspacing="0" id="tabelaLabel">
				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 20px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">
									In&Iacute;cio</span>
							</div>
						</td>
					</tr>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 20px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">
									Fim</span>
							</div>
						</td>
					</tr>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 20px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">
									Total</span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<table
				style="position: absolute; left: 30px; top: 310px; width: 614px; height: 22px; z-index: 6;"
				cellpadding="0" cellspacing="0" id="tabelaLabel">
				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: top; height: 18px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;"> </span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<table
				style="position: absolute; left: 30px; top: 219px; width: 152px; height: 22px; z-index: 7;"
				cellpadding="0" cellspacing="0" id="tabelaLabel">
				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 18px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">
									Hor&aacute;rio de Opera&ccedil;&atilde;o</span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<input name="edInicioOpUsina" type="text" id="edNormal"
				style="position: absolute; left: 107px; top: 241px; width: 73px; height: 18px; line-height: 18px; z-index: 8;"
				onChange="calcHoraOpUsina();" tabindex="1"> <input
				name="edFimOpUsina" type="text" id="edNormal"
				style="position: absolute; left: 107px; top: 262px; width: 73px; height: 18px; line-height: 18px; z-index: 9;"
				onChange="calcHoraOpUsina();" tabindex="2"> <input
				name="edTotalOpUsina" type="text" id="edReadOnly"
				style="position: absolute; left: 106px; top: 285px; width: 73px; height: 18px; line-height: 18px; z-index: 10;"
				value="0" readonly="true">
			<table
				style="position: absolute; left: 491px; top: 219px; width: 151px; height: 22px; z-index: 11;"
				cellpadding="0" cellspacing="0" id="tabelaLabel">
				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 18px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">
									Produ&ccedil;&atilde;o di&aacute;ria</span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<input name="edProdDiaria" type="text" id="edReadOnly"
				style="position: absolute; left: 491px; top: 240px; width: 148px; height: 18px; line-height: 18px; z-index: 12;"
				value="0" readonly="true"> <input name="edMmPulv" type="text"
				id="edNormal"
				style="position: absolute; left: 490px; top: 284px; width: 150px; height: 18px; line-height: 18px; z-index: 13;"
				value="0" tabindex="5">
			<table
				style="position: absolute; left: 184px; top: 240px; width: 76px; height: 68px; z-index: 14;"
				cellpadding="0" cellspacing="0" id="Table9">
				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 20px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">
									Inicial</span>
							</div>
						</td>
					</tr>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 20px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">
									Final</span>
							</div>
						</td>
					</tr>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 20px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">
									Total</span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<table
				style="position: absolute; left: 184px; top: 219px; width: 152px; height: 22px; z-index: 15;"
				cellpadding="0" cellspacing="0" id="tabelaLabel">
				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 18px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">
									Hor&iacute;metro da Usina</span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<input name="edHorIniUsina" type="text" id="edReadOnly"
				style="position: absolute; left: 261px; top: 241px; width: 73px; height: 18px; line-height: 18px; z-index: 16;"
				readonly="true" value=<?php echo "$horimetro_inicial"; ?>> <input
				name="edHorFimUsina" type="text" id="edNormal"
				style="position: absolute; left: 261px; top: 262px; width: 73px; height: 18px; line-height: 18px; z-index: 17;"
				onChange="calcHorimUsina();" tabindex="3"> <input
				name="edTotalHorUsina" type="text" id="edReadOnly"
				style="position: absolute; left: 261px; top: 285px; width: 73px; height: 18px; line-height: 18px; z-index: 18;"
				value="0" readonly="true">
			<table
				style="position: absolute; left: 338px; top: 239px; width: 76px; height: 68px; z-index: 19;"
				cellpadding="0" cellspacing="0" id="tabelaLabel">
				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 20px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">Inicial
								</span>
							</div>
						</td>
					</tr>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 20px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">
									Final</span>
							</div>
						</td>
					</tr>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 20px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">
									Total</span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<table
				style="position: absolute; left: 338px; top: 219px; width: 152px; height: 22px; z-index: 20;"
				cellpadding="0" cellspacing="0" id="tabelaLabel">
				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 18px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">
									Hor&iacute;metro do Gerador</span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<input name="edHorIniGerador" type="text" id="edReadOnly"
				style="position: absolute; left: 415px; top: 241px; width: 73px; height: 18px; line-height: 18px; z-index: 21;"
				readonly="true" value=<?php echo "$horim_ini_ger"; ?>> <input
				name="edHorFimGerador" type="text" id="edNormal"
				style="position: absolute; left: 415px; top: 262px; width: 73px; height: 18px; line-height: 18px; z-index: 22;"
				onChange="calcHorimetroGerador();
        ConsumoHoraDG();"
				tabindex="4"> <input name="edTotalGerador" type="text"
				id="edReadOnly"
				style="position: absolute; left: 415px; top: 284px; width: 73px; height: 18px; line-height: 18px; z-index: 23;"
				value="0" readonly="true">
			<table
				style="position: absolute; left: 491px; top: 262px; width: 150px; height: 22px; z-index: 24;"
				cellpadding="0" cellspacing="0" id="tabelaLabel">
				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 18px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">Clima/Tempo</span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<div id="wb_Image3"
				style="position: absolute; left: 772px; top: 84px; width: 202px; height: 51px; z-index: 25; padding: 0;">
				<img src="images/wwb_img2.jpg" alt="" width="202" height="51"
					border="0" id="Image3" style="width: 202px; height: 51px;">
			</div>
			<table
				style="position: absolute; left: 30px; top: 335px; width: 76px; height: 46px; z-index: 26;"
				cellpadding="0" cellspacing="0" id="Table13">
				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 20px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">Pedra
									3/4:</span>
							</div>
						</td>
					</tr>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 20px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">Pedra
									3/8</span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>

			<input type="text" id="edNormal"
				style="position: absolute; left: 107px; top: 335px; width: 73px; height: 18px; line-height: 18px; z-index: 27;"
				name="edUmid34" value="0" tabindex="6"> <input type="text"
				id="edNormal"
				style="position: absolute; left: 107px; top: 355px; width: 73px; height: 18px; line-height: 18px; z-index: 28;"
				name="edUmid38" value="0" tabindex="7">
			<table
				style="position: absolute; left: 186px; top: 335px; width: 76px; height: 46px; z-index: 29;"
				cellpadding="0" cellspacing="0" id="tabelaLabel">
				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 20px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">Pedra
									5/16</span>
							</div>
						</td>
					</tr>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 20px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">Pedra
									3/16</span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>


			<input type="text" id="edNormal"
				style="position: absolute; left: 263px; top: 335px; width: 73px; height: 18px; line-height: 18px; z-index: 30;"
				name="edUmid516" value="0" tabindex="8"> <input type="text"
				id="edNormal"
				style="position: absolute; left: 263px; top: 356px; width: 73px; height: 18px; line-height: 18px; z-index: 31;"
				name="edUmid316" value="0" tabindex="9">
			<table
				style="position: absolute; left: 342px; top: 335px; width: 140px; height: 46px; z-index: 32;"
				cellpadding="0" cellspacing="0" id="tabelaLabel">
				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 20px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">Areia:</span>
							</div>
						</td>
					</tr>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 20px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">Umidade
									ponderada:</span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>

			<input type="text" id="edNormal"
				style="position: absolute; left: 485px; top: 335px; width: 73px; height: 18px; line-height: 18px; z-index: 33;"
				name="edUmidAreia" value="0" tabindex="9"> <input type="text"
				id="edNormal"
				style="position: absolute; left: 485px; top: 356px; width: 73px; height: 18px; line-height: 18px; z-index: 34;"
				name="edUmidP" value="0" tabindex="10">
			<table
				style="position: absolute; left: 647px; top: 310px; width: 330px; height: 22px; z-index: 35;"
				cellpadding="0" cellspacing="0" id="tabelaLabel">
				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 18px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">Observa&ccedil;&otilde;es</span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<textarea name="TaObsUmid" id="TextArea3"
				style="position: absolute; left: 647px; top: 334px; width: 328px; height: 44px; z-index: 36;"
				rows="1" cols="49"></textarea>
			<table
				style="position: absolute; left: 30px; top: 383px; width: 946px; height: 22px; z-index: 37;"
				cellpadding="0" cellspacing="0" id="tabelaLabel">
				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 18px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">Registro
									de Paradas</span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<table
				style="position: absolute; left: 30px; top: 406px; width: 248px; height: 22px; z-index: 38;"
				cellpadding="0" cellspacing="0" id="Table18">
				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; width: 120px; height: 18px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">Hor&aacute;rio
									inicial</span>
							</div>
						</td>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 18px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">Final</span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<table
				style="position: absolute; left: 277px; top: 406px; width: 699px; height: 22px; z-index: 39;"
				cellpadding="0" cellspacing="0" id="tabelaLabel">
				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 18px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">Descri&ccedil;&atilde;o
									da Parada</span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>

			<input type="text" id="edNormal"
				style="position: absolute; left: 30px; top: 428px; width: 119px; height: 18px; line-height: 18px; z-index: 40;"
				name="edHIniP[]" value="" tabindex="11"> <input type="text"
				id="edNormal"
				style="position: absolute; left: 151px; top: 428px; width: 123px; height: 18px; line-height: 18px; z-index: 41;"
				name="edHFP[]" value="" tabindex="12"> <input type="text"
				id="edNormal"
				style="position: absolute; left: 276px; top: 428px; width: 698px; height: 18px; line-height: 18px; z-index: 42;"
				name="edObsP[]" value="" tabindex="13"> <input type="text"
				id="edNormal"
				style="position: absolute; left: 30px; top: 450px; width: 119px; height: 18px; line-height: 18px; z-index: 43;"
				name="edHIniP[]" value="" tabindex="14"> <input type="text"
				id="edNormal"
				style="position: absolute; left: 151px; top: 450px; width: 123px; height: 18px; line-height: 18px; z-index: 44;"
				name="edHFP[]" value="" tabindex="15"> <input type="text"
				id="edNormal"
				style="position: absolute; left: 276px; top: 450px; width: 698px; height: 18px; line-height: 18px; z-index: 45;"
				name="edObsP[]" value="" tabindex="16"> <input type="text"
				id="edNormal"
				style="position: absolute; left: 30px; top: 472px; width: 119px; height: 18px; line-height: 18px; z-index: 46;"
				name="edHIniP[]" value="" tabindex="17"> <input type="text"
				id="edNormal"
				style="position: absolute; left: 151px; top: 472px; width: 123px; height: 18px; line-height: 18px; z-index: 47;"
				name="edHFP[]" value="" tabindex="18"> <input type="text"
				id="edNormal"
				style="position: absolute; left: 276px; top: 472px; width: 698px; height: 18px; line-height: 18px; z-index: 48;"
				name="edObsP[]" value="" tabindex="19"> <input type="text"
				id="edNormal"
				style="position: absolute; left: 30px; top: 494px; width: 119px; height: 18px; line-height: 18px; z-index: 49;"
				name="edHIniP[]" value="" tabindex="20"> <input type="text"
				id="edNormal"
				style="position: absolute; left: 151px; top: 494px; width: 123px; height: 18px; line-height: 18px; z-index: 50;"
				name="edHFP[]" value="" tabindex="21"> <input type="text"
				id="edNormal"
				style="position: absolute; left: 276px; top: 494px; width: 698px; height: 18px; line-height: 18px; z-index: 51;"
				name="edObsP[]" value="" tabindex="22">
			<table
				style="position: absolute; left: 30px; top: 518px; width: 946px; height: 22px; z-index: 52;"
				cellpadding="0" cellspacing="0" id="tabelaLabel">
				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: top; height: 18px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">Informa&ccedil;&otilde;es
									sobre a caldeira da usina de asfalto</span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<table
				style="position: absolute; left: 31px; top: 561px; width: 76px; height: 68px; z-index: 53;"
				cellpadding="0" cellspacing="0" id="Table21">
				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 20px;"><span
							style="font-family: Arial; font-size: 13px; color: #000000;">In&iacute;cio:</span>
							<div></div>
						</td>
					</tr>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 20px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">
									Fim</span>
							</div>
						</td>
					</tr>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 20px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">
									Total</span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<table
				style="position: absolute; left: 31px; top: 541px; width: 152px; height: 22px; z-index: 54;"
				cellpadding="0" cellspacing="0" id="tabelaLabel">
				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 18px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">
									Hor&aacute;rio de Opera&ccedil;&atilde;o</span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<input name="edHIniOpC" type="text" id="edNormal"
				style="position: absolute; left: 108px; top: 563px; width: 73px; height: 18px; line-height: 18px; z-index: 55;"
				onChange="calcHoraOpCaldeira();" tabindex="23"> <input
				name="edHFimOpC" type="text" id="edNormal"
				style="position: absolute; left: 108px; top: 584px; width: 73px; height: 18px; line-height: 18px; z-index: 56;"
				onChange="calcHoraOpCaldeira();" tabindex="24"> <input name="edTOpC"
				type="text" id="edReadOnly"
				style="position: absolute; left: 108px; top: 605px; width: 73px; height: 18px; line-height: 18px; z-index: 57;"
				value="0" readonly="true" tabindex="0">
			<table
				style="position: absolute; left: 185px; top: 562px; width: 76px; height: 68px; z-index: 58;"
				cellpadding="0" cellspacing="0" id="Table23">

				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 20px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">
									Inicial</span>
							</div>
						</td>
					</tr>
					<tr>

						<td height="26"
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 20px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">
									Final</span>
							</div>
						</td>
					</tr>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 20px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">
									Total</span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<table
				style="position: absolute; left: 185px; top: 541px; width: 152px; height: 22px; z-index: 59;"
				cellpadding="0" cellspacing="0" id="tabelaLabel">

				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 18px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">
									Hor&iacute;metro da caldeira</span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<input name="edHmIniC" type="text" id="edReadOnly"
				style="position: absolute; left: 262px; top: 563px; width: 73px; height: 18px; line-height: 18px; z-index: 60;"
				value="<?php echo"$horim_ini_cald"; ?>" readonly="true"> <input
				name="edHmFimC" type="text" id="edHmFimC"
				style="position: absolute; left: 262px; top: 584px; width: 73px; height: 18px; line-height: 18px; z-index: 61;"
				onChange="calcHorimetroCaldeira();
        ConsumoHoraDC();"
				tabindex="25"> <input name="edTHmC" type="text" id="edReadOnly"
				style="position: absolute; left: 262px; top: 605px; width: 73px; height: 18px; line-height: 18px; z-index: 62;"
				value="0" readonly="true">
			
    <table
				style="position: absolute; left: 339px; top: 561px; width: 76px; height: 46px; z-index: 63;"
				cellpadding="0" cellspacing="0" id="tabelaLabel">
      
				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 20px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">Inicial
								</span>
							</div>
						</td>
					</tr>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 20px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">
									Final</span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			
    <table
				style="position: absolute; left: 339px; top: 541px; width: 152px; height: 22px; z-index: 64;"
				cellpadding="0" cellspacing="0" id="tabelaLabel">
      
				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 18px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">Temperatura
									do CAP</span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			
    <input type="text" id="edNormal" onBlur="calcDelta();"
				style="position: absolute; left: 416px; top: 563px; width: 73px; height: 18px; line-height: 18px; z-index: 65;"
				name="edTIniCAP" tabindex="26">
     <input type="text"
				id="edNormal" onBlur="calcDelta();"
				style="position: absolute; left: 416px; top: 584px; width: 73px; height: 18px; line-height: 18px; z-index: 66;"
				name="edTFimCAP" value="" tabindex="27">
			
    <table
				style="position: absolute; left: 493px; top: 561px; width: 76px; height: 46px; z-index: 67;"
				cellpadding="0" cellspacing="0" id="Table27">
      
				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 20px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">Quantidade</span>
							</div>
						</td>
					</tr>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 20px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">Delta</span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			
    <table
				style="position: absolute; left: 493px; top: 542px; width: 152px; height: 22px; z-index: 68;"
				cellpadding="0" cellspacing="0" id="Table28">
      
				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 18px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">Ton.
									de CAP aquecido</span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			
    <input name="edQtCAPAq" type="text" id="edReadOnly"
				style="position: absolute; left: 571px; top: 564px; width: 73px; height: 18px; line-height: 18px; z-index: 69;" value="<?php echo"$EstoqueFinal"; ?>"
				readonly="true">
     <input name="edDelta" type="text" id="edReadOnly"
				style="position: absolute; left: 571px; top: 584px; width: 73px; height: 18px; line-height: 18px; z-index: 70;"
				readonly="true">
			<table
				style="position: absolute; left: 648px; top: 541px; width: 328px; height: 22px; z-index: 71;"
				cellpadding="0" cellspacing="0" id="Table29">
				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 18px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">Observa&ccedil;&otilde;es
									gerais </span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<textarea name="taObsC" id="TextArea2"
				style="position: absolute; left: 648px; top: 563px; width: 326px; height: 44px; z-index: 72;"
				rows="1" cols="49" tabindex="28"></textarea>
			<table
				style="position: absolute; left: 30px; top: 631px; width: 946px; height: 22px; z-index: 73;"
				cellpadding="0" cellspacing="0" id="Table30">
				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: top; height: 18px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">Condi&ccedil;&otilde;es
									do estoque dos materiais</span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<table
				style="position: absolute; left: 30px; top: 655px; width: 75px; height: 38px; z-index: 74;"
				cellpadding="0" cellspacing="0" id="tabelaLabel">
				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 34px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">Material</span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>

			<table
				style="position: absolute; left: 104px; top: 655px; width: 76px; height: 38px; z-index: 76;"
				cellpadding="0" cellspacing="0" id="tabelaLabel">
				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 34px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">Capacidade</span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<table
				style="position: absolute; left: 179px; top: 655px; width: 76px; height: 38px; z-index: 77;"
				cellpadding="0" cellspacing="0" id="tabelaLabel">
				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: top; height: 34px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">Estoque
								</span>
							</div>
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">Anterior</span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<table
				style="position: absolute; left: 254px; top: 655px; width: 86px; height: 38px; z-index: 78;"
				cellpadding="0" cellspacing="0" id="tabelaLabel">

				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: top; height: 34px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">Recebimento</span>
							</div>
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">de
									material</span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<table
				style="position: absolute; left: 339px; top: 655px; width: 72px; height: 38px; z-index: 79;"
				cellpadding="0" cellspacing="0" id="tabelaLabel">
				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: top; height: 34px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">N&ordm;
									Nota</span>
							</div>
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">Fiscal</span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<table
				style="position: absolute; left: 410px; top: 655px; width: 310px; height: 38px; z-index: 80;"
				cellpadding="0" cellspacing="0" id="tabelaLabel">

				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: top; height: 34px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">Fornecedor</span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<table
				style="position: absolute; left: 719px; top: 655px; width: 72px; height: 38px; z-index: 81;"
				cellpadding="0" cellspacing="0" id="tabelaLabel">

				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: top; height: 34px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">Medida
								</span>
							</div>
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">Vazio</span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<table
				style="position: absolute; left: 790px; top: 655px; width: 94px; height: 38px; z-index: 82;"
				cellpadding="0" cellspacing="0" id="tabelaLabel">
				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: top; height: 34px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">Consumo</span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<table
				style="position: absolute; left: 882px; top: 656px; width: 94px; height: 38px; z-index: 83;"
				cellpadding="0" cellspacing="0" id="tabelaLabel">

				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: top; height: 34px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">Estoque
									final</span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<table
				style="position: absolute; left: 30px; top: 692px; width: 76px; height: 22px; z-index: 84;"
				cellpadding="0" cellspacing="0" id="Table40">

				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">CAP</span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<input name="edKgCap" type="text" id="edReadOnly"
				style="position: absolute; left: 106px; top: 693px; width: 71px; height: 18px; line-height: 18px; z-index: 85;"
				value="<?php echo"$cap_cap"; ?>" readonly="true"> <input
				name="edRcbCap" type="text" id="edNormal"
				style="position: absolute; left: 255px; top: 693px; width: 82px; height: 18px; line-height: 18px; z-index: 86;"
				onBlur="calcConsumoCap();" value="0"> <input name="edEstqAntCap"
				type="text" id="edReadOnly"
				style="position: absolute; left: 179px; top: 693px; width: 74px; height: 18px; line-height: 18px; z-index: 87;"
				value="<?php echo"$EstoqueFinal"; ?>" readonly="true"> <input
				type="text" id="edNormal"
				style="position: absolute; left: 339px; top: 693px; width: 70px; height: 18px; line-height: 18px; z-index: 88;"
				name="edNFCap" value="" onChange="calcConsumoCap();"> <select				id="edNormal"
				style="position: absolute; left: 410px; top: 693px; width: 308px; height: 18px; line-height: 18px; z-index: 89;"
				name="edFornCap">
				<option></option>
				<?php
				include 'conecta.php';
				$cnsFornCap = mysql_query("select * from empresas where categoria = 3") or die(mysql_error());
				while ($valor = mysql_fetch_array($cnsFornCap)) {
					echo "<option value=$valor[0]>$valor[1]</option>";
				}
				?>
			</select> <input name="edCmCap" type="text" id="edNormal"
				style="position: absolute; left: 719px; top: 693px; width: 70px; height: 18px; line-height: 18px; z-index: 90;"
				onBlur="buscMedCap();
        calcConsumoCap();"> <input name="edCnsCap" type="text"
				id="edReadOnly"
				style="position: absolute; left: 790px; top: 693px; width: 92px; height: 18px; line-height: 18px; z-index: 91;"
				value="0" readonly="true" align="center"> <input name="edEstqFCap"
				type="text" id="edReadOnly"
				style="position: absolute; left: 882px; top: 693px; width: 92px; height: 18px; line-height: 18px; z-index: 92;"
				value="<?php echo"$EstoqueFinal"; ?>" readonly="true">
			<table
				style="position: absolute; left: 30px; top: 713px; width: 76px; height: 22px; z-index: 93;"
				cellpadding="0" cellspacing="0" id="tabelaLabel">

				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">XISTO</span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<input name="edKgX" type="text" id="edReadOnly"
				style="position: absolute; left: 106px; top: 714px; width: 71px; height: 18px; line-height: 18px; z-index: 94;"
				value="<?php echo"$cap_xisto"; ?>" readonly="true"> <input
				name="edRcbX" type="text" id="edNormal"
				style="position: absolute; left: 255px; top: 714px; width: 82px; height: 18px; line-height: 18px; z-index: 95;"
				onChange="calcConsumoXisto();" value="0"> <input name="edEstqAntX"
				type="text" id="edReadOnly"
				style="position: absolute; left: 179px; top: 714px; width: 74px; height: 18px; line-height: 18px; z-index: 96;"
				readonly="true" value=<?php echo"$estqFinalX"; ?>> <input
				type="text" id="edNormal"
				style="position: absolute; left: 339px; top: 714px; width: 70px; height: 18px; line-height: 18px; z-index: 97;"
				name="edNFX" value=""> <select id="edNormal"
				style="position: absolute; left: 410px; top: 714px; width: 308px; height: 18px; line-height: 18px; z-index: 98;"
				name="edFornX">
				<option></option>
				<?php
				include 'conecta.php';
				$cnsFornCap = mysql_query("select * from empresas where categoria = 3") or die(mysql_error());
				while ($valor = mysql_fetch_array($cnsFornCap)) {
					echo "<option value=$valor[0]>$valor[1]</option>";
				}
				?>
			</select> <input name="edCmX" type="text" id="edNormal"
				style="position: absolute; left: 719px; top: 714px; width: 70px; height: 18px; line-height: 18px; z-index: 99;"
				onChange="buscMedXisto();
        calcConsumoXisto();"> <input name="edCnsX" type="text"
				id="edReadOnly"
				style="position: absolute; left: 790px; top: 714px; width: 92px; height: 18px; line-height: 18px; z-index: 100;"
				value="0" readonly="true"> <input name="edEstqFX" type="text"
				id="edReadOnly"
				style="position: absolute; left: 882px; top: 714px; width: 92px; height: 18px; line-height: 18px; z-index: 101;"
				value="<?php echo"$estqFinalX"; ?>" readonly="true">
			<table
				style="position: absolute; left: 30px; top: 734px; width: 76px; height: 22px; z-index: 102;"
				cellpadding="0" cellspacing="0" id="tabelaLabel">

				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">DIESEL
									C</span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<input name="edKgDC" type="text" id="edReadOnly"
				style="position: absolute; left: 106px; top: 735px; width: 71px; height: 18px; line-height: 18px; z-index: 103;"
				value="<?php echo"$cap_die_cald"; ?>" readonly="true"> <input
				name="edRcbDC" type="text" id="edNormal"
				style="position: absolute; left: 255px; top: 735px; width: 82px; height: 18px; line-height: 18px; z-index: 104;"
				onBlur="if (this.value == '') {
            this.value = 0;
        }"
				onChange="calcConsumoDieC();
        calcCnsD();
        ConsumoHoraDC();
                       "
				value="0"> <input name="edEstqAntDC" type="text" id="edReadOnly"
				style="position: absolute; left: 179px; top: 735px; width: 74px; height: 18px; line-height: 18px; z-index: 105;"
				readonly="true" value=<?php echo"$estqFinalDieCald"; ?>> <input
				type="text" id="edNaoEditavel"
				style="position: absolute; left: 339px; top: 735px; width: 70px; height: 18px; line-height: 18px; z-index: 106;"
				name="Editbox7" value=""> <input type="text" id="edNaoEditavel"
				style="position: absolute; left: 410px; top: 735px; width: 308px; height: 18px; line-height: 18px; z-index: 107;"
				name="edFornDC" value=""> <input name="edCmDC" type="text"
				id="edNormal"
				style="position: absolute; left: 719px; top: 735px; width: 70px; height: 18px; line-height: 18px; z-index: 108;"
				onChange="buscMedDieC();
        calcConsumoDieC();
        calcCnsD();
        ConsumoHoraDC();
                       "> <input name="edCnsDC" type="text"
				id="edReadOnly"
				style="position: absolute; left: 790px; top: 735px; width: 92px; height: 18px; line-height: 18px; z-index: 109;"
				value="0" readonly="true"> <input name="edEstqFDC" type="text"
				id="edReadOnly"
				style="position: absolute; left: 882px; top: 735px; width: 92px; height: 18px; line-height: 18px; z-index: 110;"
				value="<?php echo"$estqFinalDieCald"; ?>" readonly="true">
			<table
				style="position: absolute; left: 30px; top: 755px; width: 76px; height: 22px; z-index: 111;"
				cellpadding="0" cellspacing="0" id="tabelaLabel">

				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">GERADOR</span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<input name="edKgG" type="text" id="edReadOnly"
				style="position: absolute; left: 106px; top: 756px; width: 71px; height: 18px; line-height: 18px; z-index: 112;"
				value="<?php echo"$cap_ger"; ?>" readonly="true"> <input
				name="edRcbDG" type="text" id="edNormal"
				style="position: absolute; left: 255px; top: 756px; width: 82px; height: 18px; line-height: 18px; z-index: 113;"
				onBlur="if (this.value == '') {
            this.value = 0;
        }"
				onChange="calcConsumoDieG();
        calcCnsD();
        ConsumoHoraDG();"
				value="0"> <input name="edEstqAntDG" type="text" id="edReadOnly"
				style="position: absolute; left: 179px; top: 756px; width: 74px; height: 18px; line-height: 18px; z-index: 114;"
				value="<?php echo"$estqFinalDieGer"; ?>" readonly="true"> <input
				type="text" id="edNaoEditavel"
				style="position: absolute; left: 339px; top: 756px; width: 70px; height: 18px; line-height: 18px; z-index: 115;"
				name="Editbox7" value=""> <input type="text" id="edNaoEditavel"
				style="position: absolute; left: 410px; top: 756px; width: 308px; height: 18px; line-height: 18px; z-index: 116;"
				name="edFornDG" value=""> <input name="text" type="text"
				id="edReadOnly"
				style="position: absolute; left: 719px; top: 756px; width: 70px; height: 18px; line-height: 18px; z-index: 117;"
				onChange="calcCnsD();" readonly="true"> <input name="edCnsDG"
				type="text" id="edReadOnly"
				style="position: absolute; left: 790px; top: 756px; width: 92px; height: 18px; line-height: 18px; z-index: 118;"
				value="0" readonly="true"> <input name="edEstqFDG" type="text"
				id="edNormal"
				style="position: absolute; left: 882px; top: 756px; width: 92px; height: 22px; line-height: 18px; z-index: 119;"
				onChange="calcConsumoDieG();
        calcCnsD();
        ConsumoHoraDG();"
				value="<?php echo"$estqFinalDieGer"; ?>">
			<table
				style="position: absolute; left: 30px; top: 775px; width: 76px; height: 22px; z-index: 120;"
				cellpadding="0" cellspacing="0" id="tabelaLabel">
				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">CAL</span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<input name="edKgCal" type="text" id="edNaoEditavel"
				style="position: absolute; left: 106px; top: 777px; width: 71px; height: 18px; line-height: 18px; z-index: 121;"
				readonly="true"> <input name="edRcbCal" type="text" id="edNormal"
				style="position: absolute; left: 255px; top: 777px; width: 82px; height: 18px; line-height: 18px; z-index: 122;"
				onBlur="if (this.value == '') {
            this.value = 0;
        }"
				onChange="calcEstoqueFinalCAL();
        teorCAL();" value="0"> <input name="edEstqAntCal" type="text"
				id="edReadOnly"
				style="position: absolute; left: 179px; top: 777px; width: 74px; height: 18px; line-height: 18px; z-index: 123;"
				value="<?php echo"$estqFinalCal"; ?>" readonly="true"> <input
				type="text" id="edNormal"
				style="position: absolute; left: 339px; top: 777px; width: 70px; height: 18px; line-height: 18px; z-index: 124;"
				name="edNFCal" value=""> <select id="edNormal"
				style="position: absolute; left: 410px; top: 777px; width: 308px; height: 18px; line-height: 18px; z-index: 125;"
				name="edFornCal">
				<option></option>
				<?php
				include 'conecta.php';
				$cnsFornCap = mysql_query("select * from empresas where categoria = 3") or die(mysql_error());
				while ($valor = mysql_fetch_array($cnsFornCap)) {
					echo "<option value=$valor[0]>$valor[1]</option>";
				}
				?>
			</select> <input type="text" id="edNaoEditavel"
				style="position: absolute; left: 719px; top: 777px; width: 70px; height: 18px; line-height: 18px; z-index: 126;"
				name="Edit" value=""> <input name="edCnsCAL" type="text"
				id="edNormal"
				style="position: absolute; left: 790px; top: 777px; width: 92px; height: 18px; line-height: 18px; z-index: 127;"
				onChange="calcEstoqueFinalCAL();
        teorCAL();" value="0"> <input name="edEstqFCal" type="text"
				id="edReadOnly"
				style="position: absolute; left: 882px; top: 777px; width: 92px; height: 18px; line-height: 18px; z-index: 128;"
				value="<?php echo"$estqFinalCal"; ?>">
			<table
				style="position: absolute; left: 30px; top: 796px; width: 76px; height: 22px; z-index: 129;"
				cellpadding="0" cellspacing="0" id="tabelaLabel">

				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">RES.
									DIES</span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<input name="edKgResDie" type="text" id="edReadOnly"
				style="position: absolute; left: 106px; top: 798px; width: 71px; height: 18px; line-height: 18px; z-index: 130;"
				value="<?php echo"$cap_res_die"; ?>" readonly="true"> <input
				name="edRcbD" type="text" id="edNormal"
				style="position: absolute; left: 255px; top: 798px; width: 82px; height: 18px; line-height: 18px; z-index: 131;"
				onBlur="if (this.value == '') {
            this.value = 0;
        }"
				onChange="calcCnsD();
                       " value="0"> <input type="text" id="edReadOnly"
				style="position: absolute; left: 179px; top: 798px; width: 74px; height: 18px; line-height: 18px; z-index: 132;"
				name="edEstqAntD" value=<?php echo"$estqFinalD"; ?>> <input
				type="text" id="edNormal"
				style="position: absolute; left: 339px; top: 798px; width: 70px; height: 18px; line-height: 18px; z-index: 133;"
				name="edNFD" value=""> <select id="edNormal"
				style="position: absolute; left: 410px; top: 798px; width: 308px; height: 18px; line-height: 18px; z-index: 134;"
				name="edFornD">
				<option></option>
				<?php
				include 'conecta.php';
				$cnsFornCap = mysql_query("select * from empresas where categoria = 3") or die(mysql_error());
				while ($valor = mysql_fetch_array($cnsFornCap)) {
					echo "<option value=$valor[0]>$valor[1]</option>";
				}
				?>
			</select> <input type="text" id="edNaoEditavel"
				style="position: absolute; left: 719px; top: 798px; width: 70px; height: 18px; line-height: 18px; z-index: 135;"
				name="Editbox7" value=""> <input name="edCnsD" type="text"
				id="edReadOnly"
				style="position: absolute; left: 790px; top: 798px; width: 92px; height: 18px; line-height: 18px; z-index: 136;"
				value="0" readonly="true"> <input name="edEstqFD" type="text"
				id="edReadOnly"
				style="position: absolute; left: 882px; top: 798px; width: 92px; height: 18px; line-height: 18px; z-index: 137;"
				value="<?php echo"$estqFinalD"; ?>" readonly="true">
			<table
				style="position: absolute; left: 30px; top: 822px; width: 946px; height: 22px; z-index: 138;"
				cellpadding="0" cellspacing="0" id="tabelaLabel">
				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: top; height: 18px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">Controle
									de Teor e M&eacute;dia de Consumo dos materiais</span>
							</div></td>
					</tr>
				</tbody>
			</table>
			<table
				style="position: absolute; left: 30px; top: 872px; width: 246px; height: 22px; z-index: 139;"
				cellpadding="0" cellspacing="0" id="tabelaLabel">
				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">Consumo
									de Xisto por tonelada</span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<input name="edTeorX" type="text" id="edReadOnly"
				style="position: absolute; left: 278px; top: 872px; width: 218px; height: 19px; line-height: 19px; z-index: 140;"
				value="0" readonly="true">
			<table
				style="position: absolute; left: 500px; top: 872px; width: 476px; height: 1px; z-index: 141;"
				cellpadding="0" cellspacing="0" id="tabelaLabel">
				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;">
							Kg de Xisto a cada 1000 kg de agregado
							<div></div>
						</td>
					</tr>
				</tbody>
			</table>
			<table
				style="position: absolute; left: 30px; top: 897px; width: 246px; height: 22px; z-index: 142;"
				cellpadding="0" cellspacing="0" id="tabelaLabel">
				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">M&eacute;dia
									de Consumo da CALDEIRA</span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<input name="edTeorDC" type="text" id="edReadOnly"
				style="position: absolute; left: 278px; top: 897px; width: 218px; height: 19px; line-height: 19px; z-index: 143;"
				value="0" readonly="true">
			<table
				style="position: absolute; left: 500px; top: 897px; width: 476px; height: 22px; z-index: 144;"
				cellpadding="0" cellspacing="0" id="tabelaLabel">
				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;">
							litro de diesel a a cada hora
							<div></div>
						</td>
					</tr>
				</tbody>
			</table>
			<table
				style="position: absolute; left: 30px; top: 922px; width: 246px; height: 22px; z-index: 145;"
				cellpadding="0" cellspacing="0" id="tabelaLabel">
				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">M&eacute;dia
									de Consumo do GERADOR</span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<input name="edTeorDG" type="text" id="edReadOnly"
				style="position: absolute; left: 278px; top: 922px; width: 218px; height: 19px; line-height: 19px; z-index: 146;"
				value="0" readonly="true">
			<table
				style="position: absolute; left: 500px; top: 922px; width: 476px; height: 22px; z-index: 147;"
				cellpadding="0" cellspacing="0" id="tabelaLabel">
				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;">
							litro de diesel a cada hora
							<div></div>
						</td>
					</tr>
				</tbody>
			</table>
			<table
				style="position: absolute; left: 30px; top: 847px; width: 246px; height: 22px; z-index: 148;"
				cellpadding="0" cellspacing="0" id="tabelaLabel">
				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;">
							teor betuminoso de CAP
							<div></div>
						</td>
					</tr>
				</tbody>
			</table>
			<input name="edTeorCap" type="text" id="edReadOnly"
				style="position: absolute; left: 278px; top: 847px; width: 218px; height: 19px; line-height: 19px; z-index: 149;"
				value="0" readonly="true">
			<table
				style="position: absolute; left: 500px; top: 847px; width: 476px; height: 22px; z-index: 150;"
				cellpadding="0" cellspacing="0" id="tabelaLabel">
				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;">
							Kg de Cap a cada 100 kg de massa
							<div></div>
						</td>
					</tr>
				</tbody>
			</table>
			<table
				style="position: absolute; left: 30px; top: 947px; width: 246px; height: 22px; z-index: 151;"
				cellpadding="0" cellspacing="0" id="tabelaLabel">
				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;">
							<div>
								<span
									style="font-family: Arial; font-size: 13px; color: #000000;">Teor
									de CAL(CH1)</span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<input name="edTeorCal" type="text" id="edReadOnly"
				style="position: absolute; left: 278px; top: 947px; width: 218px; height: 19px; line-height: 19px; z-index: 152;"
				value="0" readonly="true">
			<table
				style="position: absolute; left: 500px; top: 947px; width: 476px; height: 22px; z-index: 153;"
				cellpadding="0" cellspacing="0" id="tabelaLabel">
				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;">
							kg de CAL a cada 100kg
							<div></div>
						</td>
					</tr>
				</tbody>
			</table>
			<table
				style="position: absolute; left: 30px; top: 972px; width: 946px; height: 22px; z-index: 154;"
				cellpadding="0" cellspacing="0" id="tabelaLabel">
				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: top; height: 18px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">Observa&ccedil;&otilde;es
									gerais</span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<textarea name="taObs" id="TextArea3"
				style="position: absolute; left: 30px; top: 996px; width: 944px; height: 71px; z-index: 155;"
				rows="3" cols="152"></textarea>
			<table
				style="position: absolute; left: 30px; top: 1072px; width: 946px; height: 22px; z-index: 156;"
				cellpadding="0" cellspacing="0" id="tabelaLabel">
				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: top; height: 18px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">Sa&iacute;da
									de Material betuminosa ( Massa de asfalto)</span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<table
				style="position: absolute; left: 30px; top: 1096px; width: 151px; height: 22px; z-index: 157;"
				cellpadding="0" cellspacing="0" id="tabelaLabel">
				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">Material</span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<table
				style="position: absolute; left: 181px; top: 1096px; width: 90px; height: 22px; z-index: 158;"
				cellpadding="0" cellspacing="0" id="tabelaLabel">
				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">Quantidade</span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<table
				style="position: absolute; left: 271px; top: 1096px; width: 66px; height: 22px; z-index: 159;"
				cellpadding="0" cellspacing="0" id="tabelaLabel">
				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">Cargas</span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<table
				style="position: absolute; left: 336px; top: 1096px; width: 190px; height: 22px; z-index: 160;"
				cellpadding="0" cellspacing="0" id="tabelaLabel">
				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">Obra</span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<table
				style="position: absolute; left: 524px; top: 1096px; width: 452px; height: 22px; z-index: 161;"
				cellpadding="0" cellspacing="0" id="tabelaLabel">
				<tbody>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">Transportadora</span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<select id="edNormal"
				style="position: absolute; left: 30px; top: 1121px; width: 149px; height: 18px; line-height: 18px; z-index: 162;"
				name="edMat1">
				<option></option>
				<?php
				include 'conecta.php';
				$cnsBetume = mysql_query("select * from betumes");
				while ($valor = mysql_fetch_array($cnsBetume)) {
					echo "<option value=$valor[0]>$valor[1]</option>";
				}
				?>
			</select> <input name="edQtdMat1" type="text" id="edNormal"
				style="position: absolute; left: 181px; top: 1121px; width: 88px; height: 18px; line-height: 18px; z-index: 163;"
				onChange="calcMassa();
        teorCAL();"> <input name="edCargas1" type="text" id="edNormal"
				style="position: absolute; left: 271px; top: 1121px; width: 63px; height: 18px; line-height: 18px; z-index: 164;"
				onChange="calcCargas();"> <select id="edNormal"
				style="position: absolute; left: 336px; top: 1121px; width: 187px; height: 18px; line-height: 18px; z-index: 165;"
				name="edObra1">
				<option></option>
				<?php
				include 'conecta.php';
				$cnsObra = mysql_query("select * from obras");
				while ($valor = mysql_fetch_array($cnsObra)) {
					echo "<option value=$valor[0]>$valor[1]</option>";
				}
				?>

			</select> <select id="edNormal"
				style="position: absolute; left: 525px; top: 1121px; width: 449px; height: 18px; line-height: 18px; z-index: 166;"
				name="edTransportadora1">
				<option></option>
				<?php
				include 'conecta.php';
				$cnsTransp = mysql_query("select * from transportadora");
				while ($valor = mysql_fetch_array($cnsTransp)) {
					echo "<option value=$valor[0]>$valor[1]</option>";
				}
				?>

			</select> <select id="edNormal"
				style="position: absolute; left: 30px; top: 1142px; width: 149px; height: 18px; line-height: 18px; z-index: 167;"
				name="edMat2">
				<option></option>
				<?php
				include 'conecta.php';
				$cnsBetume = mysql_query("select * from betumes");
				while ($valor = mysql_fetch_array($cnsBetume)) {
					echo "<option value=$valor[0]>$valor[1]</option>";
				}
				?>
			</select> <input name="edQtdMat2" type="text" id="edNormal"
				style="position: absolute; left: 181px; top: 1142px; width: 88px; height: 18px; line-height: 18px; z-index: 168;"
				onChange="calcMassa();
        teorCAL();"> <input name="edCargas2" type="text" id="edNormal"
				style="position: absolute; left: 271px; top: 1142px; width: 63px; height: 18px; line-height: 18px; z-index: 169;"
				onChange="calcCargas();"> <select id="select4"
				style="position: absolute; left: 336px; top: 1142px; width: 187px; height: 18px; line-height: 18px; z-index: 170;"
				name="edObra2">
				<option></option>
				<?php
				include 'conecta.php';
				$cnsObra = mysql_query("select * from obras");
				while ($valor = mysql_fetch_array($cnsObra)) {
					echo "<option value=$valor[0]>$valor[1]</option>";
				}
				?>
			</select> <select id="edNormal"
				style="position: absolute; left: 525px; top: 1142px; width: 449px; height: 18px; line-height: 18px; z-index: 171;"
				name="edTransportadora2">
				<option></option>
				<?php
				include 'conecta.php';
				$cnsTransp = mysql_query("select * from transportadora");
				while ($valor = mysql_fetch_array($cnsTransp)) {
					echo "<option value=$valor[0]>$valor[1]</option>";
				}
				?>
			</select> <select id="edNormal"
				style="position: absolute; left: 30px; top: 1163px; width: 149px; height: 18px; line-height: 18px; z-index: 172;"
				name="edMat3">
				<option></option>
				<?php
				include 'conecta.php';
				$cnsBetume = mysql_query("select * from betumes");
				while ($valor = mysql_fetch_array($cnsBetume)) {
					echo "<option value=$valor[0]>$valor[1]</option>";
				}
				?>
			</select> <input name="edQtdMat3" type="text" id="edNormal"
				style="position: absolute; left: 181px; top: 1163px; width: 88px; height: 18px; line-height: 18px; z-index: 173;"
				onChange="calcMassa();
        teorCAL();"> <input name="edCargas3" type="text" id="edNormal"
				style="position: absolute; left: 271px; top: 1163px; width: 63px; height: 18px; line-height: 18px; z-index: 174;"
				onChange="calcCargas();"> <select id="edNormal"
				style="position: absolute; left: 336px; top: 1163px; width: 187px; height: 18px; line-height: 18px; z-index: 175;"
				name="edObra3">
				<option></option>
				<?php
				include 'conecta.php';
				$cnsObra = mysql_query("select * from obras");
				while ($valor = mysql_fetch_array($cnsObra)) {
					echo "<option value=$valor[0]>$valor[1]</option>";
				}
				?>
			</select> <select id="edNormal"
				style="position: absolute; left: 525px; top: 1163px; width: 449px; height: 18px; line-height: 18px; z-index: 176;"
				name="edTransportadora3">
				<option></option>
				<?php
				include 'conecta.php';
				$cnsTransp = mysql_query("select * from transportadora");
				while ($valor = mysql_fetch_array($cnsTransp)) {
					echo "<option value=$valor[0]>$valor[1]</option>";
				}
				?>
			</select> <select id="edNormal"
				style="position: absolute; left: 30px; top: 1184px; width: 149px; height: 18px; line-height: 18px; z-index: 177;"
				name="edMat4">
				<option></option>
				<?php
				include 'conecta.php';
				$cnsBetume = mysql_query("select * from betumes");
				while ($valor = mysql_fetch_array($cnsBetume)) {
					echo "<option value=$valor[0]>$valor[1]</option>";
				}
				?>
			</select> <input name="edQtdMat4" type="text" id="edNormal"
				style="position: absolute; left: 181px; top: 1184px; width: 88px; height: 18px; line-height: 18px; z-index: 178;"
				onChange="calcMassa();
        teorCAL();"> <input name="edCargas4" type="text" id="edNormal"
				style="position: absolute; left: 271px; top: 1184px; width: 63px; height: 18px; line-height: 18px; z-index: 179;"
				onChange="calcCargas();"> <select id="edNormal"
				style="position: absolute; left: 336px; top: 1184px; width: 187px; height: 18px; line-height: 18px; z-index: 180;"
				name="edObra4">
				<option></option>
				<?php
				include 'conecta.php';
				$cnsObra = mysql_query("select * from obras");
				while ($valor = mysql_fetch_array($cnsObra)) {
					echo "<option value=$valor[0]>$valor[1]</option>";
				}
				?>
			</select> <select id="edNormal"
				style="position: absolute; left: 525px; top: 1184px; width: 449px; height: 18px; line-height: 18px; z-index: 181;"
				name="edTransportadora4">
				<option></option>
				<?php
				include 'conecta.php';
				$cnsTransp = mysql_query("select * from transportadora");
				while ($valor = mysql_fetch_array($cnsTransp)) {
					echo "<option value=$valor[0]>$valor[1]</option>";
				}
				?>
			</select> <select id="edNormal"
				style="position: absolute; left: 525px; top: 1184px; width: 449px; height: 18px; line-height: 18px; z-index: 181;"
				name="select">
				<option></option>
				<?php
				include 'conecta.php';
				$cnsTransp = mysql_query("select * from transportadora");
				while ($valor = mysql_fetch_array($cnsTransp)) {
					echo "<option value=$valor[0]>$valor[1]</option>";
				}
				?>
			</select> <select id="edNormal"
				style="position: absolute; left: 30px; top: 1205px; width: 149px; height: 18px; line-height: 18px; z-index: 182;"
				name="edMat5">
				<option></option>
				<?php
				include 'conecta.php';
				$cnsBetume = mysql_query("select * from betumes");
				while ($valor = mysql_fetch_array($cnsBetume)) {
					echo "<option value=$valor[0]>$valor[1]</option>";
				}
				?>
			</select> <input name="edQtdMat5" type="text" id="edNormal"
				style="position: absolute; left: 181px; top: 1205px; width: 88px; height: 18px; line-height: 18px; z-index: 183;"
				onChange="calcMassa();
        teorCAL();"> <input type="text" id="edNormal"
				style="position: absolute; left: 271px; top: 1205px; width: 63px; height: 18px; line-height: 18px; z-index: 184;"
				name="edCargas5" value=""> <select id="select3"
				style="position: absolute; left: 337px; top: 1205px; width: 187px; height: 18px; line-height: 18px; z-index: 185;"
				name="edObra5">
				<option></option>
				<?php
				include 'conecta.php';
				$cnsObra = mysql_query("select * from obras");
				while ($valor = mysql_fetch_array($cnsObra)) {
					echo "<option value=$valor[0]>$valor[1]</option>";
				}
				?>
			</select> <select id="edNormal"
				style="position: absolute; left: 525px; top: 1205px; width: 449px; height: 18px; line-height: 18px; z-index: 186;"
				name="edTransportadora5">
				<option></option>
				<?php
				include 'conecta.php';
				$cnsTransp = mysql_query("select * from transportadora");
				while ($valor = mysql_fetch_array($cnsTransp)) {
					echo "<option value=$valor[0]>$valor[1]</option>";
				}
				?>
			</select> <select id="edNormal"
				style="position: absolute; left: 30px; top: 1226px; width: 149px; height: 18px; line-height: 18px; z-index: 187;"
				name="edMat6">
				<option></option>
				<?php
				include 'conecta.php';
				$cnsBetume = mysql_query("select * from betumes");
				while ($valor = mysql_fetch_array($cnsBetume)) {
					echo "<option value=$valor[0]>$valor[1]</option>";
				}
				?>
			</select> <input name="edQtdMat6" type="text" id="edNormal"
				style="position: absolute; left: 181px; top: 1226px; width: 88px; height: 18px; line-height: 18px; z-index: 188;"
				onChange="calcMassa();
        teorCAL();"> <input name="edCargas6" type="text" id="edNormal"
				style="position: absolute; left: 271px; top: 1226px; width: 63px; height: 18px; line-height: 18px; z-index: 189;"
				onChange="calcCargas();"> <select id="edNormal"
				style="position: absolute; left: 336px; top: 1226px; width: 187px; height: 18px; line-height: 18px; z-index: 190;"
				name="edObra6">
				<option></option>
				<?php
				include 'conecta.php';
				$cnsObra = mysql_query("select * from obras");
				while ($valor = mysql_fetch_array($cnsObra)) {
					echo "<option value=$valor[0]>$valor[1]</option>";
				}
				?>
			</select> <select id="edNormal"
				style="position: absolute; left: 525px; top: 1226px; width: 449px; height: 18px; line-height: 18px; z-index: 191;"
				name="edTransportadora6">
				<option></option>
				<?php
				include 'conecta.php';
				$cnsTransp = mysql_query("select * from transportadora");
				while ($valor = mysql_fetch_array($cnsTransp)) {
					echo "<option value=$valor[0]>$valor[1]</option>";
				}
				?>
			</select> <select id="edNormal"
				style="position: absolute; left: 30px; top: 1247px; width: 149px; height: 18px; line-height: 18px; z-index: 192;"
				name="edMat7">
				<option></option>
				<?php
				include 'conecta.php';
				$cnsBetume = mysql_query("select * from betumes");
				while ($valor = mysql_fetch_array($cnsBetume)) {
					echo "<option value=$valor[0]>$valor[1]</option>";
				}
				?>
			</select> <input name="edQtdMat7" type="text" id="edNormal"
				style="position: absolute; left: 181px; top: 1247px; width: 88px; height: 18px; line-height: 18px; z-index: 193;"
				onChange="calcMassa();
        teorCAL();"> <input name="edCargas7" type="text" id="edNormal"
				style="position: absolute; left: 271px; top: 1247px; width: 63px; height: 18px; line-height: 18px; z-index: 194;"
				onChange="calcCargas();"> <select id="edNormal"
				style="position: absolute; left: 336px; top: 1247px; width: 187px; height: 18px; line-height: 18px; z-index: 195;"
				name="edObra7">
				<option></option>
				<?php
				include 'conecta.php';
				$cnsObra = mysql_query("select * from obras");
				while ($valor = mysql_fetch_array($cnsObra)) {
					echo "<option value=$valor[0]>$valor[1]</option>";
				}
				?>
			</select> <select id="edNormal"
				style="position: absolute; left: 525px; top: 1247px; width: 449px; height: 18px; line-height: 18px; z-index: 196;"
				name="edTransportadora7">
				<option></option>
				<?php
				include 'conecta.php';
				$cnsTransp = mysql_query("select * from transportadora");
				while ($valor = mysql_fetch_array($cnsTransp)) {
					echo "<option value=$valor[0]>$valor[1]</option>";
				}
				?>
			</select> <select id="edNormal"
				style="position: absolute; left: 30px; top: 1268px; width: 149px; height: 18px; line-height: 18px; z-index: 197;"
				name="edMat8">
				<option></option>
				<?php
				include 'conecta.php';
				$cnsBetume = mysql_query("select * from betumes");
				while ($valor = mysql_fetch_array($cnsBetume)) {
					echo "<option value=$valor[0]>$valor[1]</option>";
				}
				?>
			</select> <input name="edQtdMat8" type="text" id="edNormal"
				style="position: absolute; left: 181px; top: 1268px; width: 88px; height: 18px; line-height: 18px; z-index: 198;"
				onChange="calcMassa();
        teorCAL();"> <input name="edCargas8" type="text" id="edNormal"
				style="position: absolute; left: 271px; top: 1268px; width: 63px; height: 18px; line-height: 18px; z-index: 199;"
				onChange="calcCargas();"> <select id="edNormal"
				style="position: absolute; left: 336px; top: 1268px; width: 187px; height: 18px; line-height: 18px; z-index: 200;"
				name="edObra8">
				<option></option>
				<?php
				include 'conecta.php';
				$cnsObra = mysql_query("select * from obras");
				while ($valor = mysql_fetch_array($cnsObra)) {
					echo "<option value=$valor[0]>$valor[1]</option>";
				}
				?>
			</select> <select id="edNormal"
				style="position: absolute; left: 525px; top: 1268px; width: 449px; height: 18px; line-height: 18px; z-index: 201;"
				name="edTransportadora8">
				<option></option>
				<?php
				include 'conecta.php';
				$cnsTransp = mysql_query("select * from transportadora");
				while ($valor = mysql_fetch_array($cnsTransp)) {
					echo "<option value=$valor[0]>$valor[1]</option>";
				}
				?>
			</select> <input type="text" id="edNormal"
				style="position: absolute; left: 181px; top: 1292px; width: 88px; height: 18px; line-height: 18px; z-index: 202;"
				name="Editbox7" value=""> <input name="edTotalCargas" type="text"
				id="edReadOnly"
				style="position: absolute; left: 271px; top: 1292px; width: 63px; height: 18px; line-height: 18px; z-index: 203;"
				readonly="true"> <input name="edTotalMassa" type="text"
				id="edReadOnly"
				style="position: absolute; left: 181px; top: 1292px; width: 88px; height: 18px; line-height: 18px; z-index: 204;"
				readonly="true">
			<table
				style="position: absolute; left: 212px; top: 74px; width: 428px; height: 122px; z-index: 206;"
				cellpadding="0" cellspacing="0" id="Table64">
				<tbody>
					<tr>
						<td colspan="3"
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 18px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;"><?php echo"$endereco"; ?>
								</span>
							</div></td>
					</tr>
					<tr>
						<td height="25"
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 18px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;"><?php echo"$rodovia_trecho"; ?>
								</span>
							</div></td>
						<td
							style="background-color: #CCCCFF; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; width: 89px; height: 18px;">
							<span
							style="font-family: Arial; font-size: 13px; color: #000000;">Data:</span>
							<div></div></td>
						<td style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 18px;">
							<input name="edData" type="hidden"
							id="edData" value=<?php echo"$data" ?>> 
							<input name="edHiddenUsina" type="hidden" id="edHiddenUsina" value=<?php echo"$unidadeusina"; ?>>
            				<input name="edData" type="text" id="campoData" value="<?php echo$data; ?>" style="position: absolute; left: 325px; top: 18px; width: 100px; height: 25px; line-height: 18px; z-index: 69;">
							</td>
					</tr>
					<tr>
						<td colspan="3"
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 18px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;"><?php echo"$endereco"; ?>
								</span>
							</div></td>
					</tr>
					<tr>
						<td colspan="3"
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 18px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;"><?php echo "$eng_responsavel2"; ?>
								</span>
							</div></td>
					</tr>
					<tr>
						
          <td height="24" colspan="3"
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 18px;"> 
            <div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;"><?php echo "$eng_operacao2"; ?>
								</span>
							</div></td>
					</tr>
					<tr>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; width: 155px; height: 18px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;"><?php echo "$encarregado2"; ?>
								</span>
							</div></td>
						<td
							style="background-color: #CCCCFF; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; width: 89px; height: 18px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;">Operador:</span>
							</div></td>
						<td
							style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 18px;">
							<div>
								<span
									style="color: #000000; font-family: Arial; font-size: 13px;"><?php echo "$operador2"; ?>
								</span>
							</div></td>
					</tr>
				</tbody>
			</table>
			<table align="center">
				<input type="hidden" name="vcal" value="0">
				<input type="hidden" name="cadP" value="0">
				</form>

				</div>

</body>

  	
<script>
		jQuery(function($){
		       $("#campoData").mask("99/99/9999");
		       $("#campoTelefone").mask("(99) 999-9999");
		       $("#campoSenha").mask("***-****");
		});
	</script>
</html>
