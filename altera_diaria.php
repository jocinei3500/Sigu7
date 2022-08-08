<?php
include 'logado.php';
include 'conecta.php';

$dataAtual = $_POST['edData'];
$erro = 0;

$unidade_usina = $_POST['edHiddenUsina']; //código da unidade da usina
$InicioOpUsina = $_POST['edInicioOpUsina']; //hora inicial de operação da usina
$FimOpUsina = $_POST['edFimOpUsina']; //horario final de operação da usina
$TotalOpUsina = $_POST['edTotalOpUsina']; //total de horas de operação da usina
$HorFimUsina = $_POST['edHorFimUsina']; //horímetro final da usina
$TotalHorUsina = $_POST['edTotalHorUsina']; //total do horímetro da usina
$Obs = $_POST['taObs']; //observações gerais da usina.
$HorFimGerador = $_POST['edHorFimGerador']; //horímetro final do gerador
$TotalGerador = $_POST['edTotalGerador']; //total do horímetro do gerador
$ProdDiaria = $_POST['edProdDiaria']; //produção diária
$MmPulv = $_POST['edMmPulv']; //mm de chuva
$HIniOpC = $_POST['edHIniOpC']; //hora inicial de operação da caldiera
$HFimOpC = $_POST['edHFimOpC']; //hora final de operação da caldeira
$TOpC = $_POST['edTOpC']; //total de horas de operaçõa da caldeira
$HmFimC = $_POST['edHmFimC']; //horímetro final da caldeira
$THmC = $_POST['edTHmC']; //total do horimetro diário da caldeira
$TIniCAP = $_POST['edTIniCAP']; //temperatura inicial de cap
$TFimCAP = $_POST['edTFimCAP']; //temperatura final de cap
$QtCAPAq = $_POST['edQtCAPAq']; //quantidade de cap aquecido
$Delta = $_POST['edDelta']; //delta
$ObsC = $_POST['taObsC']; //obesrvaçõaes sobre a caldeitra
if ($ObsC == '') {
    $ObsC = null;
}

//*******************CADASTRO DE CONSUMO DE MATERIAIS***************************************************
$RcbCap = $_POST['edRcbCap']; //qiantidade de cap recebido
$NFCap = $_POST['edNFCap']; //nota Fiscal de Cap
$FornCap = $_POST['edFornCap']; //código do fornecedor de cap
$CnsCap = $_POST['edCnsCap'];  //Consumo de Cap
$RcbX = $_POST['edRcbX']; //quantidade de Xisto recebido
$NFX = $_POST['edNFX']; //Nota fiscal e Xisto
$FornX = $_POST['edFornX']; //código do fornecedor de Xisto
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
$cm_cap = $_POST['edCmCap'];
$cm_x = $_POST['edCmX'];
$cm_dc = $_POST['edCmDC'];


//===================================================~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//cadstra operaÃ§Ã£o da usina

if (($HorFimUsina != '') && ($InicioOpUsina != '') && ($FimOpUsina != '') && ($TotalOpUsina != '')) {
    $cadOpUsina = mysql_query("update op_usina set 
        horimetro_final='$HorFimUsina', obs='$Obs',hora_inicial= '$InicioOpUsina',hora_final='$FimOpUsina', t_op_bruto='$TotalOpUsina' where data='$dataAtual' and usina=$unidade_usina");

    //   $cadOpUsina = mysql_query("(null,'$dataAtual',
    // '$HorFimUsina','$Obs',$unidade_usina,'$InicioOpUsina','$FimOpUsina','$TotalOpUsina')");
}
//-----------------------------------------------------------------------------------------------------------------
//CADASTRA OPERAÇÃO DO GERADOR
if ($TotalGerador != '0') {
    $cadOpGer = mysql_query(" update op_gerador set horimetro_final= $HorFimGerador where data='$dataAtual' and usina=$unidade_usina");
}
//------------------------------------------------------------------------------------------------------------------
//CADASTRA CONTROLE PULVIOMÉTRICO
if ($MmPulv != '0') {
    $cadMPulv = mysql_query("update controle_pulviometrico set mm_chuva= '$MmPulv' where usina=$unidade_usina and data='$dataAtual'");
}
//------------------------------------------------------------------------------------------------------------------
//cadastra umidades

$Umid34 = $_POST['edUmid34'];
if ($Umid34 == '') {
    $Umid34 = null;
}
$Umid38 = $_POST['edUmid38'];
if ($Umid38 == '') {
    $Umid38 = null;
}
$Umid316 = $_POST['edUmid316'];
if ($Umid316 == '') {
    $Umid316 = null;
}
$UmidAreia = $_POST['edUmidAreia'];
if ($UmidAreia == '') {
    $UmidAreia = null;
}
$UmidP = $_POST['edUmidP'];
if ($UmidP == '') {
    $UmidP = null;
}
$Umid516 = $_POST['edUmid516'];
if ($Umid516 == '') {
    $Umid516 = null;
}
$ObsUmid = $_POST['TaObsUmid'];
if ($ObsUmid == '') {
    $ObsUmid = null;
}
if (($Umid34 != '0') or ($Umid38 != '0') or ($Umid316 != '0') or ($UmidAreia != '0') or ($UmidP != '0') or ($Umid516 != '0') or ($ObsUmid != '0')) {
    $cadUmidades = mysql_query("update umidades set 3_4='$Umid34',3_8='$Umid38',3_16='$Umid316',
        areia='$UmidAreia',umid_ponderada='$UmidP',5_16=$Umid516,obs='$ObsUmid' where data='$dataAtual' and usina=$unidade_usina");
}
//------------------------------------------------------------------------------------------------
// pega ,os valores e cadastra PARADAS
$cod_p = $_POST['p'];
$h1parada = $_POST['edHIniP'];
$h2parada = $_POST['edHFP'];
$descParada = $_POST['edObsP'];
for ($i = 0; $i < 4; $i++) {
    if ($h1parada[$i] != '') {
        if ($cod_p[$i] != '') {
            $cadParada = mysql_query("update paradas_usina set h_inicial='$h1parada[$i]',h_final='$h2parada[$i]',descricao='$descParada[$i]' where cod_parada_usina= $cod_p[$i]");
        } else {
            $cadParada = mysql_query("insert into paradas_usina values(null,'$dataAtual','$h1parada[$i]','$h2parada[$i]','$descParada[$i]',$unidade_usina)");
            //se não existe cadastro de paradas o sistema cadastra a parada.
        }
    } elseif ($cod_p[$i] != '') {
        $cadParada = mysql_query("delete from paradas_usina where cod_parada_usina=$cod_p[$i]");
    }
}

//---------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------
//CADASTRA OPERAÇÃO DA CALDEIRA.
if ($THmC != '') {
    $adOpCalde = mysql_query("update op_caldeira set horimetro_final=$HmFimC,
       hora_ini='$HIniOpC', hora_fim='$HFimOpC', total_hora='$TOpC', temp_ini_cap=$TIniCAP, 
           temp_fim_cap=$TFimCAP, qtd_cap_aquecido=$QtCAPAq,delta=$Delta,obs='$ObsC' where data='$dataAtual' and usina=$unidade_usina");
}
//-----------------------------------------------------------------------------------------------------------

if ($CnsCap != '') {
    $cadConsumoCap = mysql_query("update consumo_material set quant=$CnsCap,cm=$cm_cap where equipamento=2 and material=1 and data='$dataAtual'");
}
if ($CnsX != '') {
    $cadConsumoX = mysql_query("update consumo_material set quant=$CnsX, cm=$cm_x where equipamento=5 and material=3 and data='$dataAtual'");
}
if ($CnsDC != '') {
    $cadConsumoDC = mysql_query("update consumo_material set quant=$CnsDC, cm=$cm_dc where equipamento=1 and material=4 and data='$dataAtual'");
}

if ($CnsDG != '') {
    $cadConsumoDG = mysql_query("update consumo_material set quant=$CnsDG where equipamento=3 and material=4 and data='$dataAtual'");
}

if ($CnsCal != '') {
    $cadConsumoCAL = mysql_query("update consumo_material set quant=$CnsCal where equipamento=9 and material=8 and data='$dataAtual'");
}
//CADASTRA ENTRADA DE MATERIAL;
//*************************-------------**********************************************************

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



$sm=$_POST['sm'];
$ssm=array();
$ssm[1]=$sm[0];
$ssm[2]=$sm[1];
$ssm[3]=$sm[2];
$ssm[4]=$sm[3];
$ssm[5]=$sm[4];
$ssm[6]=$sm[5];
$ssm[7]=$sm[6];
$ssm[8]=$sm[7];

for ($i = 1; $i < 9; $i++) {
    if (($Mat[$i] != '') and ($QtdMat[$i] != '') and ($Cargas[$i] != '') and ($Obra[$i] != '') and ($Transportadora[$i] != '')) {
        if ($ssm[$i] != '') {
            $cadSdMat = mysql_query("update saida_material_diario set material=$Mat[$i],quant=$QtdMat[$i],
            qtd_cargas=$Cargas[$i],transportadora=$Transportadora[$i], obra=$Obra[$i] where cod_saida=$ssm[$i]");
        } else{
            $cadSdMat = mysql_query("insert into saida_material_diario values(null,$Mat[$i],$QtdMat[$i],$Cargas[$i],'$dataAtual',
                $Transportadora[$i],$Obra[$i], $unidade_usina)");
        }
    } elseif ($ssm[$i] != '') {
        $cadSdMat = mysql_query("delete from saida_material_diario where cod_saida=$ssm[$i]");
    }
}
//-----------------------------------------------------------------------------------------------------------
//************************************************
//CADASTRO DE entrada de materiais produtos...
$cod_entrada_cap = $_POST['cod_entrada_cap'];
if ($RcbCap != '0') {
    if ($cod_entrada_cap != '0') {
        $cadEntMat = mysql_query("update entrada_material set quant=$RcbCap, nota_fiscal=$NFCap, 
        fornecedor=$FornCap where cod_entrada=$cod_entrada_cap");
    } else {
        $cadEntMat = mysql_query("insert into entrada_material values(null,1,
        $RcbCap,$NFCap,$FornCap,'$dataAtual',null,null,$unidade_usina)");
    }
} elseif ($cod_entrada_cap != '0') {
    $cadEntMat = mysql_query("delete from entrada_material where cod_entrada=$cod_entrada_cap ");
}
//..............................................................................
$cod_entrada_x = $_POST['cod_entrada_x'];
if ($RcbX != '0') {
    if ($cod_entrada_x != '0') {
        $cadEntMat = mysql_query("update entrada_material set quant=$RcbX, nota_fiscal=$NFX,
            fornecedor=$FornX where cod_entrada=$cod_entrada_x");
    } else {
        $cadEntMat = mysql_query("insert into entrada_material values(null,3,
        $RcbX,$NFX,$FornX,'$dataAtual',null,null,$unidade_usina)");
    }
} elseif ($cod_entrada_x != '0') {
    $cadEntMat = mysql_query("delete from entrada_material where cod_entrada=$cod_entrada_x ");
}
//.............................................................................
$cod_entrada_cal = $_POST['cod_entrada_cal'];
if ($RcbCal != '0') {
    if ($cod_entrada_cal != '0') {
        $cadEntMat = mysql_query("update entrada_material set quant=$RcbCal, nota_fiscal=$NFCal,
            fornecedor=$FornCal where cod_entrada=$cod_entrada_cal");
    } else {
        $cadEntMat = mysql_query("insert into entrada_material values(null,8,
        $RcbCal,$NFCal,$FornCal,'$dataAtual',null,null,$unidade_usina)");
    }
} elseif ($cod_entrada_cal != '0') {
    $cadEntMat = mysql_query("delete from entrada_material where cod_entrada=$cod_entrada_cal ");
}

//..............................................................................
$cod_entrada_d = $_POST['cod_entrada_d'];
if ($RcbD != '0') {
    if ($cod_entrada_d != '0') {
        $cadEntMat = mysql_query("update entrada_material set quant=$RcbD, nota_fiscal=$NFD,
            fornecedor=$FornD where cod_entrada=$cod_entrada_d");
    } else {
        $cadEntMat = mysql_query("insert into entrada_material values(null,4,
    $RcbD,$NFD,$FornD,'$dataAtual',null,null,$unidade_usina)");
    }
} elseif ($cod_entrada_d != '0') {
    $cadEntMat = mysql_query("delete from entrada_material where cod_entrada=$cod_entrada_d ");
}
//CADASTRO DE ABASTECIMENTOS NA CALDEIRA
if ($RcbDC != '0') {
    $cadAbstDC = mysql_query("select * from abastecimentos where equipamento=1 and data='$dataAtual'");
    if (mysql_num_rows($cadAbstDC) > 0) {
        $cadAbstDC = mysql_query("update abastecimentos set quant=$RcbDC where data='$dataAtual' and equipamento=1");
    } else {
        $cadAbstDC = mysql_query("insert into abastecimentos values(null,1,$RcbDC,'$dataAtual')");
    }
} else {
    $cadAbstDC = mysql_query("select * from abastecimentos where equipamento=1 and data='$dataAtual'");
    if (mysql_num_rows($cadAbstDC) > 0) {
        $cadAbstDC = mysql_query("delete from abastecimentos where equipamento=1 and data='$dataAtual' ");
    }
}
//CADASTRO DE ABASTECIMENTOS NO GERADOR
if ($RcbDG != '0') {
    $cadAbstDG = mysql_query("select * from abastecimentos where equipamento=3 and data='$dataAtual'");
    if (mysql_num_rows($cadAbstDG) > 0) {
        $cadAbstDG = mysql_query("update abastecimentos set quant=$RcbDG where data='$dataAtual' and equipamento=3");
    } else {
        $cadAbstDG = mysql_query("insert into abastecimentos values(null,3,$RcbDG,'$dataAtual')");
    }
} else {
    $cadAbstDG = mysql_query("select * from abastecimentos where equipamento=3 and data='$dataAtual'");
    if (mysql_num_rows($cadAbstDG) > 0) {
        $cadAbstDG = mysql_query("delete from abastecimentos where equipamento=3 and data='$dataAtual' ");
    }
}

echo'
    <form    name="frmGravado" action="filter_diaria.php" method="post">
<div id="Layer1" style="position:absolute; left:130px; top:40px; width:590px; height:372px; z-index:1; background-color: #DDDDFF; layer-background-color: #DDDDFF; border: 1px none #000000;"></div>
<div id="Layer2" style="position:absolute; left:140px; top:50px; width:570px; height:30px; z-index:2">Alteração realizada com sucesso!</div>
<div id="Layer2" style="position:absolute; left:140px; top:90px; width:570px; height:310px; z-index:2"> 
</div>
<div id="Layer2" style="position:absolute; left:160px; top:100px; width:30px; height:18px; z-index:2"> 
  <input type="submit" name="Submit" value="          OK          ">
</div>
<input type="hidden" name="unidade_usina" value="' . $unidade_usina . '">
</form>
';
?>
