<?php
include 'logado.php';
include 'conecta.php';
$dataAtual =$_POST['edData'];
$dataAtual=  explode('/',$dataAtual);
$dataAtual=$dataAtual[2].'-'.$dataAtual[1].'-'.$dataAtual[0];
$erro = 0;

$unidade_usina = $_POST['edHiddenUsina']; //cÛdigo da unidade da usina
$InicioOpUsina = $_POST['edInicioOpUsina']; //hora inicial de operaÁ„o da usina
$FimOpUsina = $_POST['edFimOpUsina']; //horario final de operaÁ„o da usina
$TotalOpUsina = $_POST['edTotalOpUsina']; //total de horas de operaÁ„o da usina
$HorFimUsina = $_POST['edHorFimUsina']; //horÌmetro final da usina
$TotalHorUsina = $_POST['edTotalHorUsina']; //total do horÌmetro da usina
$Obs = $_POST['taObs']; //observaÁıes gerais da usina.
$HorFimGerador = $_POST['edHorFimGerador']; //horÌmetro final do gerador
$TotalGerador = $_POST['edTotalGerador']; //total do horÌmetro do gerador
$ProdDiaria = $_POST['edProdDiaria']; //produÁ„o di·ria
$MmPulv = $_POST['edMmPulv']; //mm de chuva
$HIniOpC = $_POST['edHIniOpC']; //hora inicial de operaÁ„o da caldiera
$HFimOpC = $_POST['edHFimOpC']; //hora final de operaÁ„o da caldeira
$TOpC = $_POST['edTOpC']; //total de horas de operaÁıa da caldeira
$HmFimC = $_POST['edHmFimC']; //horÌmetro final da caldeira
$THmC = $_POST['edTHmC']; //total do horimetro di·rio da caldeira
$TIniCAP = $_POST['edTIniCAP']; //temperatura inicial de cap
$TFimCAP = $_POST['edTFimCAP']; //temperatura final de cap
$QtCAPAq = $_POST['edQtCAPAq']; //quantidade de cap aquecido
$Delta = $_POST['edDelta']; //delta
$ObsC = $_POST['taObsC']; //obesrvaÁıaes sobre a caldeitra
if ($ObsC == '') {
    $ObsC = null;
}

//*******************CADASTRO DE CONSUMO DE MATERIAIS***************************************************
$RcbCap = $_POST['edRcbCap']; //qiantidade de cap recebido
$NFCap = $_POST['edNFCap']; //nota Fiscal de Cap
$FornCap = $_POST['edFornCap']; //cÛdigo do fornecedor de cap
$CnsCap = $_POST['edCnsCap'];  //Consumo de Cap
$RcbX = $_POST['edRcbX']; //quantidade de Xisto recebido
$NFX = $_POST['edNFX']; //Nota fiscal e Xisto
$FornX = $_POST['edFornX']; //cÛdigo do fornecedor de Xisto
$CnsX = $_POST['edCnsX']; //Consumo de Xisto
$RcbDC = $_POST['edRcbDC'];
$CnsDC = $_POST['edCnsDC'];

$RcbDG = $_POST['edRcbDG'];
$CnsDG = $_POST['edCnsDG'];
$EstqFDG = $_POST['edEstqFDG'];

$RcbCal = $_POST['edRcbCal'];
$FornCal = $_POST['edFornCal'];
$NFCal = $_POST['edNFCal'];
$CnsCal = $_POST['edCnsCAL'];
$EstqFCal = $_POST['edEstqFCal'];

$RcbD = $_POST['edRcbD'];
$NFD = $_POST['edNFD'];
$FornD = $_POST['edFornD'];
$CnsD = $_POST['edCnsD'];
$EstqFD = $_POST['edEstqFD'];
$cm_cap=$_POST['edCmCap'];
$cm_x=$_POST['edCmX'];
$cm_dc=$_POST['edCmDC'];


//===================================================~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//cadstra opera√ß√£o da usina
$cadOpUsina=  mysql_query("select * from op_usina where data='$dataAtual'");
if(mysql_num_rows($cadOpUsina)>0){
    echo'
    <form name="frmGravado" action="diaria_usina.php" method="post">
<div id="Layer1" style="position:absolute; left:130px; top:40px; width:590px; height:372px; z-index:1; background-color: #DDDDFF; layer-background-color: #DDDDFF; border: 1px none #000000;"></div>
<div id="Layer2" style="position:absolute; left:140px; top:50px; width:570px; height:30px; z-index:2"> Existe uma diaria j· cadastrada com essa data!</div>
<div id="Layer2" style="position:absolute; left:140px; top:90px; width:570px; height:310px; z-index:2"> 
</div>
<div id="Layer2" style="position:absolute; left:160px; top:100px; width:30px; height:18px; z-index:2"> 
  <input type="submit" name="Submit" value="          OK          ">
</div>
<input type="hidden" name="unidade_usina" value="'.$unidade_usina.'">
</form>
';
exit();
}else{
if (($HorFimUsina != '') && ($InicioOpUsina != '') && ($FimOpUsina != '') && ($TotalOpUsina != '')) {
    $cadOpUsina = mysql_query("insert into op_usina values(null,'$dataAtual',
    '$HorFimUsina','$Obs',$unidade_usina,'$InicioOpUsina','$FimOpUsina','$TotalOpUsina')");
}
}
//-----------------------------------------------------------------------------------------------------------------
//CADASTRA OPERA«√O DO GERADOR

if ($TotalGerador != '0') {
    $cadOpGer = mysql_query("insert into op_gerador values(null,'$dataAtual',
    $HorFimGerador,null,null,$unidade_usina,$TotalGerador)");
}
//------------------------------------------------------------------------------------------------------------------
//CADASTRA CONTROLE PULVIOM…TRICO
if ($MmPulv!='0') {
    $cadMPulv = mysql_query("insert into controle_pulviometrico values(null,'$MmPulv','$dataAtual',$unidade_usina)");
}
//------------------------------------------------------------------------------------------------------------------
//cadastra umidades

   $Umid34=$_POST['edUmid34'];
    if($Umid34==''){
        $Umid34=null;
    }
    $Umid38=$_POST['edUmid38'];
    if($Umid38==''){
        $Umid38=null;
    }
    $Umid316=$_POST['edUmid316'];
    if($Umid316==''){
        $Umid316=null;
    }
    $UmidAreia=$_POST['edUmidAreia'];
    if($UmidAreia==''){
        $UmidAreia=null;
    }
    $UmidP=$_POST['edUmidP'];
    if($UmidP==''){
        $UmidP=null;
    }
    $Umid516=$_POST['edUmid516'];
    if($Umid516==''){
        $Umid516=null;
    }
    $ObsUmid=$_POST['TaObsUmid'];
    if($ObsUmid==''){
        $ObsUmid=null;
    }
    if(($Umid34!='0')or($Umid38!='0')or($Umid316!='0')or($UmidAreia!='0')or($UmidP!='0')or($Umid516!='0')or($ObsUmid!='0')){
    $cadUmidades = mysql_query("insert into umidades values(null,'$Umid34','$Umid38','$Umid316',
        '$UmidAreia','$UmidP','$dataAtual',$Umid516,'$ObsUmid', $unidade_usina)");
    }
//------------------------------------------------------------------------------------------------
// pega ,os valores e cadastra PARADAS
$h1parada=$_POST['edHIniP'];
$h2parada=$_POST['edHFP'];
$descParada=$_POST['edObsP'];
for ($i = 0; $i <4; $i++) {
if($h1parada[$i]!=''){
        $cadParada = mysql_query("insert into paradas_usina values(null,'$dataAtual','$h1parada[$i]','$h2parada[$i]','$descParada[$i]', $unidade_usina)");
    }
}

//---------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------
//CADASTRA OPERA«√O DA CALDEIRA.
if ($THmC != '') {
    $adOpCalde = mysql_query(" insert into op_caldeira values(null,'$dataAtual',$HmFimC,
        '$HIniOpC','$HFimOpC','$TOpC',$TIniCAP,$TFimCAP,$QtCAPAq,$Delta,$unidade_usina,'$ObsC')");
} else {
    $alertopC = 'N√£o houve opera√ß√£o da caldeira<br/>';
}
//-----------------------------------------------------------------------------------------------------------



if ($CnsCap != '') {
    $cadConsumoCap = mysql_query("insert into consumo_material values(null,'$dataAtual',$CnsCap,2,1,$cm_cap)");
} else {
    echo "nao pode ser cadastrado opera√ß√£o da usina";
}
if ($CnsX != '') {
    $cadConsumoX = mysql_query("insert into consumo_material values(null,'$dataAtual',$CnsX,5,3,$cm_x)");
}
if ($CnsDC != '') {
    $cadConsumoDC = mysql_query("insert into consumo_material values(null,'$dataAtual',$CnsDC,1,4,$cm_dc)");
}

if ($CnsDG != '') {
    $cadConsumoDG = mysql_query("insert into consumo_material values(null,'$dataAtual',$CnsDG,3,4,null)");
}

if ($CnsCal != '') {
    $cadConsumoCAL = mysql_query("insert into consumo_material values(null,'$dataAtual',$CnsCal,9,8,null)");
}
//=============================================================================================

$Mat = array();
$Mat[1] = $_POST['edMat1'];
$Mat[2] = $_POST['edMat2'];
$Mat[3] = $_POST['edMat3'];
$Mat[4] = $_POST['edMat4'];
$Mat[5] = $_POST['edMat5'];
$Mat[6] = $_POST['edMat6'];
$Mat[7] = $_POST['edMat7'];
$Mat[8] = $_POST['edMat8'];
$QtdMat = array();
$QtdMat[1] = $_POST['edQtdMat1'];
$QtdMat[2] = $_POST['edQtdMat2'];
$QtdMat[3] = $_POST['edQtdMat3'];
$QtdMat[4] = $_POST['edQtdMat4'];
$QtdMat[5] = $_POST['edQtdMat5'];
$QtdMat[6] = $_POST['edQtdMat6'];
$QtdMat[7] = $_POST['edQtdMat7'];
$QtdMat[8] = $_POST['edQtdMat8'];

$Cargas = array();

$Cargas[1] = $_POST['edCargas1'];
$Cargas[2] = $_POST['edCargas2'];
$Cargas[3] = $_POST['edCargas3'];
$Cargas[4] = $_POST['edCargas4'];
$Cargas[5] = $_POST['edCargas5'];
$Cargas[6] = $_POST['edCargas6'];
$Cargas[7] = $_POST['edCargas7'];
$Cargas[8] = $_POST['edCargas8'];

$Obra = array();
$Obra[1] = $_POST['edObra1'];
$Obra[2] = $_POST['edObra2'];
$Obra[3] = $_POST['edObra3'];
$Obra[4] = $_POST['edObra4'];
$Obra[5] = $_POST['edObra5'];
$Obra[6] = $_POST['edObra6'];
$Obra[7] = $_POST['edObra7'];
$Obra[8] = $_POST['edObra8'];
$Transportadora = array();
$Transportadora[1] = $_POST['edTransportadora1'];
$Transportadora[2] = $_POST['edTransportadora2'];
$Transportadora[3] = $_POST['edTransportadora3'];
$Transportadora[4] = $_POST['edTransportadora4'];
$Transportadora[5] = $_POST['edTransportadora5'];
$Transportadora[6] = $_POST['edTransportadora6'];
$Transportadora[7] = $_POST['edTransportadora7'];
$Transportadora[8] = $_POST['edTransportadora8'];
for ($i = 1; $i < 9; $i++) {
    if (($Mat[$i] != '') and ($QtdMat[$i] != '') and ($Cargas[$i] != '') and ($Obra[$i] != '') and ($Transportadora[$i] != '')) {
        $cadSdMat = mysql_query("insert into saida_material_diario values(null,$Mat[$i],$QtdMat[$i],$Cargas[$i],'$dataAtual',
                $Transportadora[$i],$Obra[$i], $unidade_usina)");
    }
}

//-----------------------------------------------------------------------------------------------------------
//************************************************
//CADASTRO DE entrada de materiais produtos...
if ($RcbCap != '0') {
    $cadEntMat = mysql_query("insert into entrada_material values(null,1,
        $RcbCap,$NFCap,$FornCap,'$dataAtual',null,null,$unidade_usina)");
}

if ($RcbX != '0') {
    $cadEntMat = mysql_query("insert into entrada_material values(null,3,
        $RcbX,$NFX,$FornX,'$dataAtual',null,null,$unidade_usina)");
}

if ($RcbCal != '0') {
    $cadEntMat = mysql_query("insert into entrada_material values(null,8,
        $RcbCal,$NFCal,$FornCal,'$dataAtual',null,null,$unidade_usina)");
}

if ($RcbD != '0') {
    $cadEntMat = mysql_query("insert into entrada_material values(null,4,
    $RcbD,$NFD,$FornD,'$dataAtual',null,null,$unidade_usina)");
}
//CADASTRO DE ABASTECIMENTOS NA CALDEIRA
if ($RcbDC != '0') {
    $cadAbstDC = mysql_query("insert into abastecimentos values(null,1,$RcbDC,'$dataAtual')");
}
//CADASTRO DE ABASTECIMENTOS NO GERADOR
if ($RcbDG != '0') {
    $cadAbstDC = mysql_query("insert into abastecimentos values(null,3,$RcbDG,'$dataAtual')");
}

echo'
    <form name="frmGravado" action="diaria_usina.php" method="post">
<div id="Layer1" style="position:absolute; left:130px; top:40px; width:590px; height:372px; z-index:1; background-color: #DDDDFF; layer-background-color: #DDDDFF; border: 1px none #000000;"></div>
<div id="Layer2" style="position:absolute; left:140px; top:50px; width:570px; height:30px; z-index:2">Cadastro 
  Realizado com sucesso!</div>
<div id="Layer2" style="position:absolute; left:140px; top:90px; width:570px; height:310px; z-index:2"> 
</div>
<div id="Layer2" style="position:absolute; left:160px; top:100px; width:30px; height:18px; z-index:2"> 
  <input type="submit" name="Submit" value="          OK          ">
</div>
<input type="hidden" name="unidade_usina" value="'.$unidade_usina.'">
</form>
';

?>
