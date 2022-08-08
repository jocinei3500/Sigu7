<?php
include 'logado.php';
$dataAtual='2013/03/31';
include 'conecta.php';
$con=  mysql_query("select max(cod_usina) as cod_usina from usinas");
$val= mysql_fetch_array($con);
$cod_usina=$val['cod_usina']+1;

?>


<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='en'>
    <meta http-equiv='content-type' content='text/html';charset:'utf-8'>
    <title> Cadastro de usinas</title> 
    
<script language="JavaScript" type="text/JavaScript">
<!--
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
<head>
        
        <style type='text/css'>
            #edCodUsina{
             background-color: #cccccc;   
            }
			
	#BtCadastrar
{
   color: #9999CC;
   bgColor:#9999CC;
   font-family: Arial;
   font-size: 13px;
}

             
        </style>
             
    </head>
    
<body onLoad="MM_preloadImages('images/home.bmp','images/7_.bmp')">
<form action='insere_usina.php' method='post' name='cad_usinas' id='cad_usinas'>
	
  <table
		style="position: absolute; left: 160px; top: 15px; width: 810px; height: 67px; z-index: 10;"
		cellpadding="0" cellspacing="0" id="tabelaLabel">
    <tr>
		
      <td width="70"><div align="center"><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('home','','images/home.bmp',1)"><img src="images/home.png" name="home" width="48" height="48" border="0"></a> 
        </div></td>
			
      <td width="70"><div align="center"><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('cadastrar','','images/7_.bmp',1)" onClick="document.cad_usinas.submit();"><img src="images/7.png" name="cadastrar" width="48" height="48" border="0"></a> 
        </div></td>
			
      <td width="70">&nbsp; </td>
			
      <td width="588">&nbsp; </td>
		
		</tr>
		</table>
		
		
            
  <fieldset style="position:absolute; top:18px; left:160px; width: 810px; height: 690px;">
  <table width="702" align="center" style="position:absolute; top:77px; left:14px;">
    <tr bgcolor="#333333"> 
      <td height="57" colspan="2"> <div align="center"><font size="6" color='#FFFFFF'><em><strong>Cadastro 
          de Usinas - T&eacute;cnica Vi&aacute;ria Constru&ccedil;&otilde;es Ltda 
          </strong></em></font></div></td>
    </tr>
    <tr> 
      <td width="302" height="24"> <div align="right"><font size="4">C&oacute;digo 
          da Usina:</font></div></td>
      <td width="896"><input name="edCodUsina" type="text"  border='1' id='edCodUsina2' readonly="true" 
                        value="<?php echo$cod_usina; ?>">
        <input type='hidden' name='edDataCadastro' value='<?php echo "$dataAtual"; ?>'></td>
    </tr>
    <tr> 
      <td height="23" colspan='2'>&nbsp;</td>
    </tr>
    <tr> 
      <td><div align="right"><font size="4">Endere&ccedil;o:</font></div></td>
      <td><input type="text" name="edEndereco" size="50"></td>
    </tr>
    <tr> 
      <td height="28"> <div align="right"><font size="4">Cidade:</font></div></td>
      <td><input type="text" name="edCidade" size='50'></td>
    </tr>
    <tr> 
      <td height="24"> <div align="right"><font size="4">Obra/Contrato:</font></div></td>
      <td><input type="text" name="edObraContrato" size='50'></td>
    </tr>
    <tr> 
      <td height="26"> <div align="right"><font size="4">Rodovia/Trecho:</font></div></td>
      <td><input type="text" name="edRodoviaTrecho" size="50">
      </td>
    </tr>
    <tr> 
      <td><div align="right"><font size="4">Engenheiro Respons&aacute;vel:</font></div></td>
      <td><select name="edEngResp" id="select" style="width:370;" >
          <option></option>
          <?php
              include 'conecta.php';
              $con= mysql_query("select * from colaborador");
              while ($val=  mysql_fetch_array($con)){
              $cod_colaborador=$val['cod_colaborador'];
              $colaborador=$val['nome'].' '.$val['sobrenome'];
              echo"<option value=$cod_colaborador>$colaborador</option>";
              }
              ?>
        </select></td>
    </tr>
    <tr> 
      <td height="28"> <div align="right"><font size="4">Engenheiro de Opera&ccedil;&atilde;o:</font></div></td>
      <td><select name="edEngOp" id="select2" style="width:370;" >
          <option></option>
          <?php
              include 'conecta.php';
              $con= mysql_query("select * from colaborador");
              while ($val=  mysql_fetch_array($con)){
              $cod_colaborador=$val['cod_colaborador'];
              $colaborador=$val['nome'].' '.$val['sobrenome'];
              echo"<option value=$cod_colaborador>$colaborador</option>";
              }
              ?>
        </select> </td>
    </tr>
    <tr> 
      <td height="29"><div align="right"><font size="4">Encarregado:</font></div></td>
      <td><select name="edEncarregado" id="select3" style="width:370;">"
          <option></option>
          <?php
              include 'conecta.php';
              $con= mysql_query("select * from colaborador");
              while ($val=  mysql_fetch_array($con)){
              $cod_colaborador=$val['cod_colaborador'];
              $colaborador=$val['nome'].' '.$val['sobrenome'];
              echo"<option value=$cod_colaborador>$colaborador</option>";
              }
              ?>
        </select></td>
    </tr>
    <tr> 
      <td height="30"> <div align="right"><font size="4">Operador da Usina:</font></div></td>
      <td><select name="edOp" id="select4" style="width:370;" >
          <option></option>
          <?php
              include 'conecta.php';
              $con= mysql_query("select * from colaborador");
              while ($val=  mysql_fetch_array($con)){
              $cod_colaborador=$val['cod_colaborador'];
              $colaborador=$val['nome'].' '.$val['sobrenome'];
              echo"<option value=$cod_colaborador>$colaborador</option>";
              }
              ?>
        </select></td>
    </tr>
    <tr valign="middle" bgcolor="#666666"> 
      <td height="41" colspan="2"> <div align="center"><font color="#FFFFFF" size="3"><strong>CAPACIDADE 
          DOS TANQUES DE MATERIAIS</strong></font></div></td>
    </tr>
    <tr> 
      <td height="26"> <div align="right"><font size="4">CAP:</font></div></td>
      <td><input name="edCPCAP" type="text" id="edCPCAP2" size="50"></td>
    </tr>
    <tr> 
      <td height="24"> <div align="right"><font size="4">XISTO:</font></div></td>
      <td><input name="edCPXisto" type="text" id="edCPXisto2" size="50"></td>
    </tr>
    <tr> 
      <td height="24"> <div align="right"><font size="4">CALDEIRA (D):</font></div></td>
      <td> 
        <input name="edCPCald" type="text" id="edCPCald2" size="50"></td>
    </tr>
    <tr> 
      <td height="24"> <div align="right"><font size="4">GERADOR(D):</font></div></td>
      <td><input name="edCPGerador" type="text" id="edCPGerador2" size="50"> </td>
    </tr>
    <tr> 
      <td height="21"><div align="right"><font size="4">RESERVAT&Oacute;RIO(D):</font></div></td>
      <td><input name="edCPRes" type="text" id="edCPRes2" size="50"> </td>
    </tr>
    <tr> 
      <td height="44"></td>
      <td>&nbsp; </td>
    </tr>
  </table>
  </fieldset>
            
            
        </form>
    
        
    </body>

</html>
