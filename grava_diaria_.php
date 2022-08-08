<?php

include 'conecta.php';

$dataAtual = date("Y/m/d"); //data atual
$erro = 0;
$valid = array();
$valid2 = array();

$unidade_usina = $_POST['edHiddenUsina'];
$InicioOpUsina = $_POST['edInicioOpUsina'];
if ($InicioOpUsina == '') {
    $erro = 1;
    $valid[0] = "Horário inicial de operação da usina";
} else {
    $valid[0] = '';
}
$FimOpUsina = $_POST['edFimOpUsina'];
if ($FimOpUsina == '') {
    $erro = 1;
    $valid[1] = "Horário final de operação da usina";
} else {
    $valid[1] = '';
}
$TotalOpUsina = $_POST['edFimOpUsina'];
$HorFimUsina = $_POST['edHorFimUsina'];
if ($HorFimUsina == '') {
    $erro = 1;
    $valid[2] = "Horímetro final da usina";
} else {
    $valid[2] = '';
}

$TotalHorUsina = $_POST['edTotalHorUsina'];
$Obs = $_POST['taObs']; //observação geral da usina.
if ($Obs == '') {
    $erro = 1;
    $valid[3] = "Observações gerais";
} else {
    $valid[3] = '';
}
$HorFimGerador = $_POST['edHorFimGerador'];
if ($HorFimGerador == '') {
    $erro = 1;
    $valid[4] = "Horímetro final do gerador";
} else {
    $valid[4] = '';
}
$TotalGerador = $_POST['edTotalGerador'];

$ProdDiaria = $_POST['edProdDiaria'];
if ($ProdDiaria == '0') {
    $erro = 1;
    $valid[5] = "Informe a quantidade de massa produzida em Saída de material betuminoso";
} else {
    $valid[5] = '';
}
$MmPulv = $_POST['edMmPulv'];

//operação da caldeira;
$HIniOpC = $_POST['edHIniOpC'];
if ($HIniOpC == '') {
    $erro = 1;
    $valid[6] = "Horário inicial de operação da caldeira";
} else {
    $valid[6] = '';
}
$HFimOpC = $_POST['edHFimOpC'];
if ($HIniOpC == '') {
    $erro = 1;
    $valid[7] = "Horário final de operação da caldeira";
} else {
    $valid[7] = '';
}
$TOpC = $_POST['edTOpC'];
$HmFimC = $_POST['edHmFimC'];
if ($HmFimC == '') {
    $erro = 1;
    $valid[8] = "Horímetro final da CALDEIRA";
} else {
    $valid[8] = '';
}
$THmC = $_POST['edTHmC'];
$TIniCAP = $_POST['edTIniCAP'];
if ($HmFimC == '') {
    $erro = 1;
    $valid[9] = "temperatura inicial de Cap aquecido";
} else {
    $valid[9] = '';
}
$TFimCAP = $_POST['edTFimCAP'];
if ($HmFimC == '') {
    $erro = 1;
    $valid[10] = "temperatura final de Cap aquecido";
} else {
    $valid[10] = '';
}
$QtCAPAq = $_POST['edQtCAPAq'];
$Delta = $_POST['edDelta'];
$ObsC = $_POST['taObsC'];
if ($ObsC == '') {
    $ObsC = null;
}


//*******************CADASTRO DE CONSUMO DE MATERIAIS***************************************************
$RcbCap = $_POST['edRcbCap'];
$NFCap = $_POST['edNFCap'];
$FornCap = $_POST['edFornCap'];
$CnsCap = $_POST['edCnsCap'];
if (($RcbCap != '0') or ($NFCap != '') or ($FornCap != '')) {
    if ($RcbCap == '0') {
        $erro = 1;
        $valid2[0] = "Você deve informar a Quantidade de Cap recebido";
    }
    if ($NFCap == '') {
        $erro = 1;
        $valid2[1] = "Você deve informar o número da nota fiscal de CAP";
    }
    if($FornCap==''){
        $erro = 1;
        $valid2[2] = "Você deve informar o fornecedor de CAP";
    }
}else if (($RcbCap != '0') and ($NFCap != '') and ($FornCap != '')){
    $cadEntMat = mysql_query("insert into entrada_material values(null,1,
    $RcbCap,$NFCap,$FornCap,'$dataAtual',null,null,$unidade_usina)");   
}
if($CnsCap=='0'){
    $erro=1;
    $valid[11]="O consumo de Cap está em branco: você deve informar a medida de 
        vazio do tanque de CAP(cm)que o sistema calculará automaticamente o estoque final e o consumo";
}  else {
    $valid[11]="";
}
    
$RcbX = $_POST['edRcbX'];
$NFX = $_POST['edNFX'];
$FornX = $_POST['edFornX'];
$CnsX = $_POST['edCnsX'];
if (($RcbX != '0') or ($NFX != '') or ($FornX != '')) {
    if ($RcbX == '0') {
        $erro = 1;
        $valid2[0] = "Você deve informar a Quantidade de Cap recebido";
    }
    if ($NFX == '') {
        $erro = 1;
        $valid2[1] = "Você deve informar o número da nota fiscal de CAP";
    }
    if($FornX==''){
        $erro = 1;
        $valid2[2] = "Você deve informar o fornecedor de CAP";
    }
}else if (($RcbX != '0') and ($NFX != '') and ($FornX != '')){
    $cadEntMat = mysql_query("insert into entrada_material values(null,3,
        $RcbX,$NFCap,$FornX,'$dataAtual',null,null,$unidade_usina)"); 
}
if($CnsX=='0'){
    $erro=1;
    $valid[12]="O consumo de Cap está em branco: você deve informar a medida de 
        vazio do tanque de CAP(cm)que o sistema calculará automaticamente o estoque final e o consumo";
}  else {
    $valid[12]="";
}

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


//===================================================~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if (($HorFimUsina != '') && ($InicioOpUsina != '') && ($FimOpUsina != '') && ($TotalOpUsina != '')) {
    $cadOpUsina = mysql_query("insert into op_usina values(null,'$dataAtual',
    '$HorFimUsina','$Obs',$unidade_usina,'$InicioOpUsina','$FimOpUsina','$TotalOpUsina')");
}

//-----------------------------------------------------------------------------------------------------------------
//CADASTRA OPERAÇÃO DO GERADOR

if ($TotalGerador != '0') {
    $cadOpGer = mysql_query("insert into op_gerador values(null,'$dataAtual',
    $HorFimGerador,null,null,$unidade_usina,$TotalGerador)");
}
//------------------------------------------------------------------------------------------------------------------
//CADASTRA CONTROLE PULVIOMÉTRICO
$cadMPulv = mysql_query("insert into controle_pulviometrico values(null,'$MmPulv','$dataAtual')");
//------------------------------------------------------------------------------------------------------------------
//cadastra umidades   

if ($ProdDiaria != '0') {
    $cadUmidades = mysql_query("insert into umidades values(null,'$Umid34','$Umid38','$Umid316',
        '$UmidAreia','$UmidP','$dataAtual',$Umid58,'$ObsUmid')");
}
//------------------------------------------------------------------------------------------------
// pega ,os valores e cadastra PARADAS
$hiniP = array();
$hiniP[1] = $_POST['edHIniP1'];
$hiniP[2] = $_POST['edHIniP2'];
$hiniP[3] = $_POST['edHIniP3'];
$hiniP[4] = $_POST['edHIniP4'];
$HFP = array();
$HFP[1] = $_POST['edHFP1'];
$HFP[2] = $_POST['edHFP2'];
$HFP[3] = $_POST['edHFP3'];
$HFP[4] = $_POST['edHFP4'];
$ObsP = array();
$ObsP[1] = $_POST['edObsP1'];
$ObsP[2] = $_POST['edObsP2'];
$ObsP[3] = $_POST['edObsP3'];
$ObsP[4] = $_POST['edObsP4'];
for ($i = 1; $i < 5; $i++) {
    if (($hiniP[$i] != '') && ($HFP[$i] != '') && ($ObsP[$i] != '')) {
        $cadParada = mysql_query("insert into paradas_usina values(null,'$dataAtual','$hiniP[$i]','$HFP[$i]','$ObsP[$i]')");
    }
}

//---------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------
//CADASTRA OPERAÇÃO DA CALDEIRA.
if ($THmC != '') {
    $adOpCalde = mysql_query(" insert into op_caldeira values(null,'$dataAtual',$HmFimC,
        '$HIniOpC','$HFimOpC',$TIniCAP,$TFimCAP,$unidade_usina,$THmC,'$ObsC')");
} else {
    $alertopC = 'Não houve operação da caldeira<br/>';
}
//-----------------------------------------------------------------------------------------------------------



if ($CnsCap != '') {
    $cadConsumoCap = mysql_query("insert into consumo_material values(null,'$dataAtual',$CnsCap,2,1)");
} else {
    echo "nao pode ser cadastrado operação da usina";
}
if ($CnsX != '') {
    $cadConsumoX = mysql_query("insert into consumo_material values(null,'$dataAtual',$CnsX,5,3)");
}
if ($CnsDC != '') {
    $cadConsumoDC = mysql_query("insert into consumo_material values(null,'$dataAtual',$CnsDC,1,4)");
}

if ($CnsDG != '') {
    $cadConsumoDG = mysql_query("insert into consumo_material values(null,'$dataAtual',$CnsDG,3,4)");
}

if ($CnsCal != '') {
    $cadConsumoCAL = mysql_query("insert into consumo_material values(null,'$dataAtual',$CnsCal,9,8)");
}
//CADASTRA ENTRADA DE MATERIAL;
//*************************-------------**********************************************************
//CADASTRO DE TEORES DE MATERIAIS!!!!!!!!!!!!!!!!!!!!!!!!!!1111111
$Teor = array(array());

$Teor[1][1] = $_POST['edTeorCap'];
$Teor[1][2] = '1';
$Teor[1][3] = '2';
$Teor[2][1] = $_POST['edTeorX'];
$Teor[2][2] = '3';
$Teor[2][3] = '5';
$Teor[3][1] = $_POST['edTeorDC'];
$Teor[3][2] = '4';
$Teor[3][3] = '1';
$Teor[4][1] = $_POST['edTeorDG'];
$Teor[4][2] = '4';
$Teor[4][3] = '3';
$Teor[5][1] = $_POST['edTeorCal'];
$Teor[5][2] = '4';
$Teor[5][3] = '3';
for ($i = 1; $i < 6; $i++) {
    if ($Teor[$i][1] != '') {
        $material = $Teor[$i][2];
        $teor = $Teor[$i][1];
        $equipamento = $Teor[$i][3];
        $cadTeor = mysql_query("insert into teor values(null,$material,$teor,'$dataAtual',$equipamento)");
    }
}
//------------------------------------iiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiii

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
        $cadSdMat = mysql_query("insert into saida_material_diario values(null,$Mat[$i],$QtdMat[$i],$Cargas[$i],'$dataAtual',$Obra[$i],$Transportadora[$i])");
    }
}

$TotalMassa = $_POST['edTotalMassa'];
$TotalCargas = $_POST['edTotalCargas'];


//-----------------------------------------------------------------------------------------------------------
//************************************************
//CADASTRO DE entrada de materiais produtos...



if ($RcbCal != '0') {
    $cadEntMat = mysql_query("insert into entrada_material values(null,8,
        $RcbCal,$NFCal,$FornCal,'$dataAtual',null,null,$unidade_usina)");
}

if ($RcbD != '0') {
    $cadEntMat = mysql_query("insert into entrada_material values(null,4,
    $RcbD,$NFD,$FornD,'$dataAtual',null,null,$unidade_usina)");
}
//CADASTRO DE ABASTECIMENTOS NA CALDEIRA
if ($RcbDG != '0') {
    $cadAbstDC = mysql_query("insert into abastecimentos values(null,1,$RcbDC,'$dataAtual')");
}
//CADASTRO DE ABASTECIMENTOS NO GERADOR
if ($RcbDG != '0') {
    $cadAbstDC = mysql_query("insert into abastecimentos values(null,3,$RcbDG,'$dataAtual')");
}

if ($Error == 1) {
    echo '<a href="JavaScript: window.history.back();">Voltar e cadastrar</a>';
    if ($validateOpUsina == 1) {
        echo '<br/>N&atilde;o foi poss&iacute;vel cadastrar faltando dados de opera&ccedil;&atilde;o de usina';
    }
    if ($validateOpG == 1) {
        echo '<br/>N&atilde;o foi poss&iacute;vel cadastrar faltando dados de opera&ccedil;&atilde;o do gerador';
    }
//
}


//---------------------------------------------????????????????????????????????
if ($erro == 1) {
    echo'<table style="position:absolute; left: 59px; top: 20px; width: 831px; height: 449px;" border="1" bordercolor="#003366" >
    <tr>
        <td>&nbsp;</td>
    </tr>

</table>
    <div style="position:absolute; left:75px; top:70px; width:800px; height:391px; z-index:1"> 
    <pre><font color="#FF0000">';
    for ($i = 0; $i < 3; $i++) {
        echo "$valid[$i].</br>";
    }
    echo'</font></pre>
</div>
<div id="Layer2" style="position:absolute; left:75px; top:30px; width:800px; height:30px; z-index:2; background-color: #CCCCCC; layer-background-color: #CCCCCC; border: 1px none #000000;">Existem 
    campos obrigat&oacute;rios em branco abaixo est&atilde;o a lista dos campos 
    que devem ser preenchidos</div>';
}
if ($erro == 1) {
    echo'<table style="position:absolute; left: 59px; top: 20px; width: 831px; height: 449px;" border="1" bordercolor="#003366" >
    <tr>
        <td>&nbsp;</td>
    </tr>

</table>
    <div style="position:absolute; left:75px; top:70px; width:800px; height:391px; z-index:1"> 
    <pre><font color="#FF0000">';
    for ($i = 0; $i < 10; $i++) {
        if ($valid[$i] != '') {
            echo "$valid[$i].</br>";
        }
    }
    echo'</font></pre>
</div>
<div id="Layer2" style="position:absolute; left:75px; top:30px; width:800px; height:30px; z-index:2; background-color: #CCCCCC; layer-background-color: #CCCCCC; border: 1px none #000000;">Existem 
    campos obrigat&oacute;rios em branco abaixo est&atilde;o a lista dos campos 
    que devem ser preenchidos</div>';
}
exit();
?>
