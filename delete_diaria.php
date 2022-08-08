<?php
include 'logado.php';
include 'conecta.php';

$dataAtual =$_GET['data'];
$unidade_usina=$_GET['usina'];
//cadstra operaÃ§Ã£o da usina
    $cadOpUsina = mysql_query("delete from op_usina where data='$dataAtual' and usina=$unidade_usina");
//CADASTRA OPERAÇÃO DO GERADOR

    $cadOpGer = mysql_query("delete from op_gerador where data='$dataAtual' and usina=$unidade_usina");
//CADASTRA CONTROLE PULVIOMÉTRICO
    $cadMPulv = mysql_query("delete from controle_pulviometrico where data='$dataAtual' and usina=$unidade_usina");

//umidades
    $cadUmidades = mysql_query("delete from umidades where data='$dataAtual' and usina=$unidade_usina");
//PARADAS USINA
   $cadParada = mysql_query("delete from paradas_usina where data='$dataAtual' and usina=$unidade_usina");
        
//OPERAÇÃO DA CALDEIRA.
    $adOpCalde = mysql_query("delete from op_caldeira where data='$dataAtual' and usina=$unidade_usina");
//----------------------------------------------------------------------------------------------------------

    $cadConsumoCAL = mysql_query("delete from consumo_material where data='$dataAtual' and
        ( equipamento=1 or equipamento=2 or equipamento=3 or equipamento=5 or equipamento=9 ) ");

//===============================================
        $cadSdMat = mysql_query("delete from saida_material_diario where data='$dataAtual' and usina=$unidade_usina");

//--------------------------------------------------------------------------------
    $cadEntMat = mysql_query("delete from entrada_material where data='$dataAtual' and usina=$unidade_usina");

    $cadAbstDC = mysql_query("delete from abastecimentos where data='$dataAtual' and (equipamento=1 or equipamento=3)");

echo'
    
    <form name="frmGravado" action="diaria_usina.php" method="post">
<div id="Layer1" style="position:absolute; left:130px; top:40px; width:590px; height:372px; z-index:1; background-color: #DDDDFF; layer-background-color: #DDDDFF; border: 1px none #000000;"></div>
<div id="Layer2" style="position:absolute; left:140px; top:50px; width:570px; height:30px; z-index:2">Exclusão feita com sucesso!</div>
<div id="Layer2" style="position:absolute; left:140px; top:90px; width:570px; height:310px; z-index:2"> 
</div>
<div id="Layer2" style="position:absolute; left:160px; top:100px; width:30px; height:18px; z-index:2"> 
  <input type="submit" name="Submit" value="          OK          ">
</div>
<input type="hidden" name="unidade_usina" value="'.$unidade_usina.'">
</form>
';

?>
