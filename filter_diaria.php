
<?php

function calcHora($hora_inicial, $hora_final) {
    $h1 = explode(':', $hora_inicial);
    $h1 = ($h1[0] * 60) + $h1[1];
    $h2 = explode(':', $hora_final);
    $h2 = ($h2[0] * 60) + $h2[1];
    $total_horim_mm = $h2 - $h1;
    $total_horim = explode('.', ($total_horim_mm / 60));
    $h1 = $total_horim[0];
    $h1 = sprintf('%02s', $h1);
    $h2 = $total_horim_mm - ($h1 * 60);
    sprintf('%02s', $h2);
    $total_horim = $h1 . ':' . $h2 . ':00';
    return $total_horim;
}
include 'logado.php';
$data = $_SESSION['dt_pesq_D'];
$data = explode('/', $data);
$data = $data[2] . '/' . $data[1] . '/' . $data[0];
include 'conecta.php';

$unidadeusina = $_SESSION['cod_usina'];
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

//engenheiro responsável----------------------------

$eng_responsavel = $valor['eng_responsavel'];
if ($eng_responsavel == null) {
    $eng_responsavel2 = '<font><strong><a href="cadastro_usinas.php">cadastre o engenheiro respons&aacute;vel</a> </strong></font>  ';
} else {

    $consulta2 = mysql_query("select nome,sobrenome from colaborador where cod_colaborador= $eng_responsavel");
    $valor2 = mysql_fetch_array($consulta2);
    $eng_responsavel2 = $valor2['nome'] . " " . $valor2['sobrenome'];
}

//engenheiro de operaável------------------------------

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
//busca dados de operação da usina
$consUsina = mysql_query("select * from op_usina where data='$data' and usina=$unidadeusina");
$val_op_usina = mysql_fetch_array($consUsina);
$h_i_op_Usina = $val_op_usina['hora_inicial'];
$h_f_op_Usina = $val_op_usina['hora_final'];
$tot_h_op_usina = $val_op_usina['t_op_bruto'];
$horimetro_final = $val_op_usina['horimetro_final'];
$obs_usina = $val_op_usina['obs'];
$consUsina = mysql_query("select * from op_usina where data=(select max(data)as data_ant from op_usina where data<'$data'and usina=$unidadeusina)and usina=$unidadeusina");
$val_op_usina = mysql_fetch_array($consUsina);
$horimetro_inicial = $val_op_usina['horimetro_final'];
$total_horim = calcHora($horimetro_inicial, $horimetro_final);

//_____________________________________________________________________________
//busca dados da operação do gerador]
$consHorimGerador = mysql_query("select * from op_gerador where data=
    (select max(data) from op_gerador where data<'$data' and usina=$unidadeusina)and usina=$unidadeusina");
$val_horim_ger = mysql_fetch_array($consHorimGerador);
$horim_ini_ger = $val_horim_ger['horimetro_final'];
$consHorimGerador = mysql_query("select * from op_gerador where data='$data' and usina=$unidadeusina");
$val_horim_ger = mysql_fetch_array($consHorimGerador);
$horim_f_ger = $val_horim_ger['horimetro_final'];
$total_horim_ger = $horim_f_ger - $horim_ini_ger;
$total_horim_ger = number_format($total_horim_ger, 1, '.', '');
//------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------
//Busca horÃ­metro final da caldeira
$consHorimCaldeira = mysql_query("select * from op_caldeira where data=(select max(data) from op_caldeira where data<'$data' and usina=$unidadeusina) and usina=$unidadeusina ");
$val_horim_cald = mysql_fetch_array($consHorimCaldeira);
$horim_ini_cald = $val_horim_cald['horimetro_final'];

$consHorimCaldeira = mysql_query("select* from op_caldeira where data='$data' and usina=$unidadeusina");
$val_horim_cald = mysql_fetch_array($consHorimCaldeira);
$horim_f_cald = $val_horim_cald['horimetro_final'];
$horim_total_c = $horim_f_cald - $horim_ini_cald;
$horim_total_c = number_format($horim_total_c, 2, '.', '');
$h_ini_c = $val_horim_cald['hora_ini'];
$h_f_c = $val_horim_cald['hora_fim'];
$h_t_c = $val_horim_cald['total_hora'];
$temp_ini_cap = $val_horim_cald['temp_ini_cap'];
$temp_fim_cap = $val_horim_cald['temp_fim_cap'];
$qtd_cap_aquecido = $val_horim_cald['qtd_cap_aquecido'];
$delta = $val_horim_cald['delta'];
$obs_cald = $val_horim_cald['obs'];
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//-----------------------------------------------------------------------------------------------
//DEFINE CONTROLE DE CONSUMO DE CAP
//estoque anterior
$cons_estq_cap = mysql_query("select sum(quant) as t_ent_cap from entrada_material where usina=$unidadeusina and material=1 and data<'$data'");
$val_ent_cap = mysql_fetch_array($cons_estq_cap);
$total_ent_cap = $val_ent_cap['t_ent_cap'];
$cons_estq_cap = mysql_query("select sum(quant) as t_c_cap from consumo_material where equipamento=2 and data<'$data'");
$val_estq_cap = mysql_fetch_array($cons_estq_cap);
$total_consumo_cap = $val_estq_cap['t_c_cap'];
$estq_ant_cap = $total_ent_cap - $total_consumo_cap;
//estoque_final
//...........................................................................................
$cons_estq_cap = mysql_query("select sum(quant) as t_ent_cap from entrada_material where usina=$unidadeusina and material=1 and data<='$data'");
$val_ent_cap = mysql_fetch_array($cons_estq_cap);
$total_ent_cap = $val_ent_cap['t_ent_cap'];
$cons_estq_cap = mysql_query("select sum(quant) as t_c_cap from consumo_material where equipamento=2 and data <='$data'");
$val_estq_cap = mysql_fetch_array($cons_estq_cap);
$total_consumo_cap = $val_estq_cap['t_c_cap'];
$estq_final_cap = $total_ent_cap - $total_consumo_cap;
//...........................................................................................

$cons_cm_cap = mysql_query("select * from consumo_material where data='$data' and material = 1 and equipamento=2");
$val = mysql_fetch_array($cons_cm_cap);
$consumo_cap = $val['quant'];
$cm_cap = $val['cm'];

$cons_rcb_cap = mysql_query("select em.cod_entrada, em.quant, em.nota_fiscal, em.fornecedor, e.nome from entrada_material em
    inner join empresas e on em.fornecedor=e.cod_fornecedor where em.data='$data' and em.material=1 and em.usina=$unidadeusina");
if ($cons_rcb_cap) {
    if ($val = mysql_fetch_array($cons_rcb_cap)) {
        $cod_entrada_cap = $val['cod_entrada'];
        $qtd_mat_rcb_cap = $val['quant'];
        $nf_cap = $val['nota_fiscal'];
        $forn_cap = $val['nome'];
        $cod_forn_cap = $val['fornecedor'];
    } else {
        $cod_entrada_cap = '0';
        $qtd_mat_rcb_cap = '0';
        $nf_cap = '';
        $forn_cap = '';
        $cod_forn_cap = 0;
    }
}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//------------------------------------------------------------------------------------------
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//-----------------------------------------------------------------------------------------------
//DEFINE CONTROLE DE CONSUMO DE xisto
//estoque anterior
$cons_estq_x = mysql_query("select sum(quant) as t_ent_x from entrada_material where usina=$unidadeusina and material=3 and data<'$data'");
$val_ent_x = mysql_fetch_array($cons_estq_x);
$total_ent_x = $val_ent_x['t_ent_x'];
$cons_estq_x = mysql_query("select sum(quant) as t_c_x from consumo_material where equipamento=5 and data<'$data'");
$val_estq_x = mysql_fetch_array($cons_estq_x);
$total_consumo_x = $val_estq_x['t_c_x'];
$estq_ant_x = $total_ent_x - $total_consumo_x;

//estoque_final
//...........................................................................................
$cons_estq_x = mysql_query("select sum(quant) as t_ent_x from entrada_material where usina=$unidadeusina and material=3 and data<='$data'");
$val_ent_x = mysql_fetch_array($cons_estq_x);
$total_ent_x = $val_ent_x['t_ent_x'];
$cons_estq_x = mysql_query("select sum(quant) as t_c_x from consumo_material where equipamento=5 and data <='$data'");
$val_estq_x = mysql_fetch_array($cons_estq_x);
$total_consumo_x = $val_estq_x['t_c_x'];
$estq_final_x = $total_ent_x - $total_consumo_x;
//...........................................................................................

$cons_cm_x = mysql_query("select * from consumo_material where data='$data' and material = 3 and equipamento=5"); //{quando há o código do  equipamento
$val = mysql_fetch_array($cons_cm_x);                                                                              //{Não é necessário o código da usina
$consumo_x = $val['quant'];
$cm_x = $val['cm'];

$cons_rcb_x = mysql_query("select em.cod_entrada, em.quant, em.nota_fiscal, em.fornecedor, e.nome from entrada_material em
    inner join empresas e on em.fornecedor=e.cod_fornecedor where em.data='$data' and em.material=3 and em.usina=$unidadeusina");
if ($cons_rcb_x) {
    if ($val = mysql_fetch_array($cons_rcb_x)) {
        $cod_entrada_x = $val['cod_entrada'];
        $qtd_mat_rcb_x = $val['quant'];
        $nf_x = $val['nota_fiscal'];
        $forn_x = $val['nome'];
        $cod_forn_x = $val['fornecedor'];
    } else {
        $cod_entrada_x = '0';
        $qtd_mat_rcb_x = '0';
        $nf_x = '';
        $forn_x = '';
        $cod_forn_x = 0;
    }
}

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//----------------------------------------------
//DEFINE ESTOQUE DE DIESEL DA CALDEIRA
//estoque anterior
$consEstqDieCald = mysql_query("select sum(quant) as t_ent_die_cald from abastecimentos where equipamento=1 and data<'$data'"); //não precisa código da usina
$val_ent_die_cald = mysql_fetch_array($consEstqDieCald);
$total_ent_die_cald = $val_ent_die_cald['t_ent_die_cald'];
$consEstqDieCald = mysql_query("select sum(quant) as t_c_d_c from consumo_material where equipamento=1 and data<'$data'");
$val_cons_die_cald = mysql_fetch_array($consEstqDieCald);
$total_cons_die_cald = $val_cons_die_cald['t_c_d_c'];
$estq_ant_d_c = $total_ent_die_cald - $total_cons_die_cald;

//estoque final
$consEstqDieCald = mysql_query("select sum(quant) as t_ent_die_cald from abastecimentos where equipamento=1 and data<='$data'"); //não precisa código da usina
$val_ent_die_cald = mysql_fetch_array($consEstqDieCald);
$total_ent_die_cald = $val_ent_die_cald['t_ent_die_cald'];
$consEstqDieCald = mysql_query("select sum(quant) as t_c_d_c from consumo_material where equipamento=1 and data<='$data'");
$val_cons_die_cald = mysql_fetch_array($consEstqDieCald);
$total_cons_die_cald = $val_cons_die_cald['t_c_d_c'];
$estq_f_d_c = $total_ent_die_cald - $total_cons_die_cald;

$cons_cm_dc = mysql_query("select * from consumo_material where data='$data' and material = 4 and equipamento=1"); //{quando há o código do  equipamento
$val = mysql_fetch_array($cons_cm_dc);                                                                              //{Não é necessário o código da usina
$consumo_dc = $val['quant'];
$cm_dc = $val['cm'];


$cons_rcb_dc = mysql_query("select quant from abastecimentos where equipamento=1 and data='$data'");
if (mysql_num_rows($cons_rcb_dc) > 0) {
    $val = mysql_fetch_array($cons_rcb_dc);
    $qtd_mat_rcb_dc = $val['quant'];
} else {
    $qtd_mat_rcb_dc = '0';
}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//----------------------------------------------
//DEFINE ESTOQUE DE DIESEL DO GERADOR
//estoque anterior
$consEstqDieGer = mysql_query("select sum(quant) as t_ent_die_ger from abastecimentos where equipamento=3 and data<'$data'"); //não precisa código da usina
$val_ent_die_ger = mysql_fetch_array($consEstqDieGer);
$total_ent_die_ger = $val_ent_die_ger['t_ent_die_ger'];
$consEstqDieGer = mysql_query("select sum(quant) as t_c_d_ger from consumo_material where equipamento=3 and data<'$data'");
$val_cons_die_ger = mysql_fetch_array($consEstqDieGer);
$total_cons_die_ger = $val_cons_die_ger['t_c_d_ger'];
$estq_ant_d_g = $total_ent_die_ger - $total_cons_die_ger;

//estoque final
$consEstqDieGer = mysql_query("select sum(quant) as t_ent_die_ger from abastecimentos where equipamento=3 and data<='$data'"); //não precisa código da usina
$val_ent_die_ger = mysql_fetch_array($consEstqDieGer);
$total_ent_die_ger = $val_ent_die_ger['t_ent_die_ger'];
$consEstqDieGer = mysql_query("select sum(quant) as t_c_d_ger from consumo_material where equipamento=3 and data<='$data'");
$val_cons_die_ger = mysql_fetch_array($consEstqDieGer);
$total_cons_die_ger = $val_cons_die_ger['t_c_d_ger'];
$estq_f_d_g = $total_ent_die_ger - $total_cons_die_ger;


$cons_cm_ger = mysql_query("select * from consumo_material where data='$data' and material = 4 and equipamento=3"); //{quando há o código do  equipamento
$val = mysql_fetch_array($cons_cm_ger);                                                                              //{Não é necessário o código da usina
$consumo_ger = $val['quant'];

$cons_rcb_ger = mysql_query("select quant from abastecimentos where equipamento=3 and data='$data'");
if (mysql_num_rows($cons_rcb_ger) > 0) {
    $val = mysql_fetch_array($cons_rcb_ger);
    $qtd_mat_rcb_ger = $val['quant'];
} else {
    $qtd_mat_rcb_ger = '0';
}

//     CONTROLE DE DIESEL DA CARREGADEIRA
$queryCPC=  mysql_query("select sum(quant) from abastecimentos where equipamento=10 and data<'$data' ");
$val=  mysql_fetch_array($queryCPC);
$t_estq_CPC=$val[0];
$queryCPC=  mysql_query("select sum(quant) from consumo_material where equipamento=10 and data<'$data'");
$val=  mysql_fetch_array($queryCPC);
$consumo=$val[0];
$estoqueFinal_CPC=$t_estq_CPC-$consumo;
//______________________________________________

//DEFINE CONTROLE DE CONSUMO DE CAL
//estoque anterior
$cons_estq_cal = mysql_query("select sum(quant) as t_ent_cal from entrada_material where usina=$unidadeusina and material=8 and data<'$data'");
$val_ent_cal = mysql_fetch_array($cons_estq_cal);
$total_ent_cal = $val_ent_cal['t_ent_cal'];
$cons_estq_cal = mysql_query("select sum(quant) as t_c_cal from consumo_material where equipamento=9 and data<'$data'");
$val_estq_cal = mysql_fetch_array($cons_estq_cal);
$total_consumo_cal = $val_estq_cal['t_c_cal'];
$estq_ant_cal = $total_ent_cal - $total_consumo_cal;

//estoque_final
//...........................................................................................
$cons_estq_cal = mysql_query("select sum(quant) as t_ent_cal from entrada_material where usina=$unidadeusina and material=8 and data<='$data'");
$val_ent_cal = mysql_fetch_array($cons_estq_cal);
$total_ent_cal = $val_ent_cal['t_ent_cal'];
$cons_estq_cal = mysql_query("select sum(quant) as t_c_cal from consumo_material where equipamento=9 and data<='$data'");
$val_estq_cal = mysql_fetch_array($cons_estq_cal);
$total_consumo_cal = $val_estq_cal['t_c_cal'];
$estq_f_cal = $total_ent_cal - $total_consumo_cal;
//...........................................................................................

$cons_cm_cal = mysql_query("select * from consumo_material where data='$data' and material = 8 and equipamento=9"); //{quando há o código do  equipamento
$val = mysql_fetch_array($cons_cm_cal);                                                                              //{Não é necessário o código da usina
$consumo_cal = $val['quant'];

$cons_rcb_cal = mysql_query("select em.cod_entrada, em.quant, em.nota_fiscal, em.fornecedor, e.nome from entrada_material em
    inner join empresas e on em.fornecedor=e.cod_fornecedor where em.data='$data' and em.material=8 and em.usina=$unidadeusina");
if ($cons_rcb_cal) {
    if ($val = mysql_fetch_array($cons_rcb_cal)) {
        $cod_entrada_cal = $val['cod_entrada'];
        $qtd_mat_rcb_cal = $val['quant'];
        $nf_cal = $val['nota_fiscal'];
        $forn_cal = $val['nome'];
        $cod_forn_cal = $val['fornecedor'];
    } else {
        $cod_entrada_cal = '0';
        $qtd_mat_rcb_cal = '0';
        $nf_cal = '';
        $forn_cal = '';
        $cod_forn_cal = 0;
    }
}

//----------------------------------------------------------------------------------------
//DEFINE ESTOQUE FINAL DE DIESEL
//estoque anterior
$consEstqD = mysql_query("select sum(quant) as t_ent_d from entrada_material where usina=$unidadeusina and material=4 and data<'$data'");
$val_ent_d = mysql_fetch_array($consEstqD);
$total_ent_d = $val_ent_d['t_ent_d'];
$consEstqD = mysql_query("select sum(quant) as t_c_d from consumo_material where material=4 and data<'$data'and 
    (equipamento=1 or equipamento=3 or equipamento=10) ");
$val_cons_d = mysql_fetch_array($consEstqD);
$total_cons_d = $val_cons_d['t_c_d'];
$estq_ant_diesel = $total_ent_d - $total_cons_d;


//estoque final
$consEstqD = mysql_query("select sum(quant) as t_ent_d from entrada_material where usina=$unidadeusina and material=4 and data<='$data'");
$val_ent_d = mysql_fetch_array($consEstqD);
$total_ent_d = $val_ent_d['t_ent_d'];
$consEstqD = mysql_query("select sum(quant) as t_c_d from consumo_material where material=4 and data<='$data'");
$val_cons_d = mysql_fetch_array($consEstqD);
$total_cons_d = $val_cons_d['t_c_d'];
$estq_f_diesel = $total_ent_d - $total_cons_d;



$cons_cm_d = mysql_query("select sum(quant)as quant from consumo_material where data='$data' and (equipamento=1 or equipamento=3)"); //{quando há o código do  equipamento
$val = mysql_fetch_array($cons_cm_d);                                                                              //{Não é necessário o código da usina
$consumo_d = $val['quant'];

$cons_rcb_d = mysql_query("select em.cod_entrada, em.quant, em.nota_fiscal, em.fornecedor, e.nome from entrada_material em
    inner join empresas e on em.fornecedor=e.cod_fornecedor where em.data='$data' and em.material=4 and em.usina=$unidadeusina");
if ($cons_rcb_d) {
    if ($val = mysql_fetch_array($cons_rcb_d)) {
        $cod_entrada_d = $val['cod_entrada'];
        $qtd_mat_rcb_d = $val['quant'];
        $nf_d = $val['nota_fiscal'];
        $forn_d = $val['nome'];
        $cod_forn_d = $val['fornecedor'];
    } else {
        $cod_entrada_d = '0';
        $qtd_mat_rcb_d = '0';
        $nf_d = '';
        $forn_d = '';
        $cod_forn_d = 0;
    }
}
//----------------------------------------------------------------
//CHUVA

$Sql = mysql_query("select * from controle_pulviometrico where data='$data'");
$valores = mysql_fetch_array($Sql);
$chuva = $valores['mm_chuva'];
//------------------------------------------------------------
//               UMIDADES
$Sql = mysql_query("select * from umidades where data='$data'");
$valores = mysql_fetch_array($Sql);
$umid_3_4 = $valores['3_4'];
$umid_3_8 = $valores['3_8'];
$umid_5_16 = $valores['5_16'];
$umid_3_16 = $valores['3_16'];
$umid_areia = $valores['areia'];
$umid_p = $valores['umid_ponderada'];
$obs_umd = $valores['obs'];


//-----------------------------------------------------------
//PARADAS
$Sql = mysql_query("select * from paradas_usina where data='$data'");
if ($Sql) {
    $val_paradas = array(array());
    $i = 1;
    while ($valores = mysql_fetch_array($Sql)) {
        $val_paradas[$i][0] = $valores['h_inicial'];
        $val_paradas[$i][1] = $valores['h_final'];
        $val_paradas[$i][2] = $valores['descricao'];
        $val_paradas[$i][3] = $valores['cod_parada_usina'];
        $i++;
    }if ($i < 4) {
        for ($i = $i; $i <= 4; $i++) {
            $val_paradas[$i][0] = '';
            $val_paradas[$i][1] = '';
            $val_paradas[$i][2] = '';
            $val_paradas[$i][3] = '';
        }
    }
} else {
    for ($i = 1; $i <= 4; $i++) {
        $val_paradas[$i][0] = '';
        $val_paradas[$i][1] = '';
        $val_paradas[$i][2] = '';
        $val_paradas[$i][3] = '';
    }
}


//-----------------------------------------------------------
// busca saida de material betuminoso
$Sql = mysql_query("select b.nome as material,s.cod_saida, s.quant, s.qtd_cargas as cargas, o.nome as obra, 
    t.nome as transportadora,s.material as cod_material, s.obra as cod_obra,s.transportadora as cod_transp from betumes b 
    inner join saida_material_diario s on b.cod_betume=s.material 
    inner join obras o on o.cod_obra=s.obra 
    inner join transportadora t on t.cod_transp=s.transportadora 
    where s.data='$data' and s.usina=$unidadeusina");

if ($Sql) {
    $val_betumes = array(array());
    $i = 1;
    while ($valores = mysql_fetch_array($Sql)) {
        $val_betumes[$i][0] = $valores['material'];
        $val_betumes[$i][1] = $valores['quant'];
        $val_betumes[$i][2] = $valores['cargas'];
        $val_betumes[$i][3] = $valores['obra'];
        $val_betumes[$i][4] = $valores['transportadora'];
        $val_betumes[$i][5] = $valores['cod_material'];
        $val_betumes[$i][6] = $valores['cod_obra'];
        $val_betumes[$i][7] = $valores['cod_transp'];
        $val_betumes[$i][8] = $valores['cod_saida'];
        $i++;
    }if ($i < 8) {
        for ($i = $i; $i <= 8; $i++) {
            $val_betumes[$i][0] = '';
            $val_betumes[$i][1] = '';
            $val_betumes[$i][2] = '';
            $val_betumes[$i][3] = '';
            $val_betumes[$i][4] = '';
            $val_betumes[$i][5] = '0';
            $val_betumes[$i][6] = '0';
            $val_betumes[$i][7] = '0';
            $val_betumes[$i][8] = '';
        }
    }
} else {
    for ($i = 1; $i <= 8; $i++) {
        $val_betumes[$i][0] = '';
        $val_betumes[$i][1] = '';
        $val_betumes[$i][2] = '';
        $val_betumes[$i][3] = '';
        $val_betumes[$i][4] = '';
        $val_betumes[$i][5] = '0';
        $val_betumes[$i][6] = '0';
        $val_betumes[$i][7] = '0';
        $val_betumes[$i][8] = '';
    }
}

//-------------------------------------------------------------------------------------
//SELECIONA TOTAIS DE MASSA

$Sql = mysql_query("select sum(quant) from saida_material_diario  where data='$data'and usina=$unidadeusina");
$total_massa = mysql_fetch_array($Sql);
$total_massa = $total_massa[0];
$Sql = mysql_query("select sum(qtd_cargas) from saida_material_diario  where data='$data'and usina=$unidadeusina");
$total_cargas = mysql_fetch_array($Sql);
$total_cargas = $total_cargas[0];

//calculo de teores

if ($total_massa != '') {
    $teor_cap = $consumo_cap / $total_massa * 100;
    $teor_cap = number_format($teor_cap, 2, ',', '');
    $teor_x = $consumo_x / $total_massa * 1000;
    $teor_x = number_format($teor_x, 2, ',', '');
    $teor_cal = $consumo_cal / $total_massa * 100;
    $teor_cal = number_format($teor_cal, 2, ',', '');
} else {
    $teor_cap = '0,00';
    $teor_x = '0,00';
    $teor_cal = '0,00';
}
if ($consumo_dc != '') {
    $teor_dc = $consumo_dc / $horim_total_c;
    $teor_dc = number_format($teor_dc, 2, ',', '');
} else {
    $teor_dc = '0,00';
}
if ($consumo_ger != '') {
    $teor_ger = $consumo_ger / $total_horim_ger;
    $teor_ger = number_format($teor_ger, 2, ',', '');
} else {
    $teor_ger = '0,00';
}
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <title>Usina de Asfalto de <?php echo "$cidade"; ?></title>

        
<script src="jquery-1.6.4.min.js" ></script>

        
<script src="jquery.maskedinput.min.js"></script>

        
<script src='verifica_erros.js'></script>

        
<script src="diaria_usina.js"></script>

        
<script src="medidas.js"></script>

        
<script src="printElement.min.js"></script>

        <script type="text/javascript">
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

            function MM_preloadImages() { //v3.0
            var d = document;
            if (d.images) {
            if (!d.MM_p)
            d.MM_p = new Array();
            var i, j = d.MM_p.length, a = MM_preloadImages.arguments;
            for (i = 0; i < a.length; i++)
            if (a[i].indexOf("#") != 0) {
            d.MM_p[j] = new Image;
            d.MM_p[j++].src = a[i];
            }
            }
            }

            function MM_swapImgRestore() { //v3.0
            var i, x, a = document.MM_sr;
            for (i = 0; a && i < a.length && (x = a[i]) && x.oSrc; i++)
            x.src = x.oSrc;
            }

            function MM_findObj(n, d) { //v4.01
            var p, i, x;
            if (!d)
            d = document;
            if ((p = n.indexOf("?")) > 0 && parent.frames.length) {
            d = parent.frames[n.substring(p + 1)].document;
            n = n.substring(0, p);
            }
            if (!(x = d[n]) && d.all)
            x = d.all[n];
            for (i = 0; !x && i < d.forms.length; i++)
            x = d.forms[i][n];
            for (i = 0; !x && d.layers && i < d.layers.length; i++)
            x = MM_findObj(n, d.layers[i].document);
            if (!x && d.getElementById)
            x = d.getElementById(n);
            return x;
            }

            function MM_swapImage() { //v3.0
            var i, j = 0, x, a = MM_swapImage.arguments;
            document.MM_sr = new Array;
            for (i = 0; i < (a.length - 2); i += 3)
            if ((x = MM_findObj(a[i])) != null) {
            document.MM_sr[j++] = x;
            if (!x.oSrc)
            x.oSrc = x.src;
            x.src = a[i + 2];
            }
            }


            function edit()
            {
            document.diaria.editar.value = '1';
            document.getElementById('edro').readOnly = false;//fiz isso porque não dava certo não sei porque.
            for (i = 1; i < 150; i++) {
            document.getElementById('edro').id = 'edNormal';
            document.getElementById('edro').readOnly = false;
            }
            document.getElementById('edro_').id = 'edNormal';
            }

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

        <script type="text/javascript">
            $(document).ready(function() {
            $('.imprimir').click(function() {
            $('.camada_para_impressao').printElement();
            });
            });
        </script>

        <link rel="stylesheet" href="diaria_usina.css">

    </head>





    <body onkeydown="cancelBack();" onLoad="MM_preloadImages('images/13.bmp', 'images/9_.bmp', 'images/home.bmp', 'images/limpar.bmp', 'images/fechar.bmp', 'images/diaria.bmp', 'images/print.bmp')">
        <table style="position: absolute; left: 110px; top: 0px; width: 950px; height: 67px; z-index: 10;"
               cellpadding="0" cellspacing="0" id="tabelaLabel">
            <tbody>
                <tr>
                    <td width="67" height="51"
                        style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;">
                        <a href="#" onMouseOut="MM_swapImgRestore()"
                           onMouseOver="MM_swapImage('home', '', 'images/home.bmp', 1)"
                           onClick="
            if (confirm('Voltar ao início?')) {
                location.href=('index.php');
            }

                           "

                           > <img
                                src="images/home.png" name="home" width="48" height="48"
                                border="0"> </a></td>

                    <td width="65"
                        style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;">
                        <a href="#" onMouseOut="MM_swapImgRestore()"
                           onMouseOver="MM_swapImage('salvar', '', 'images/7.bmp', 1)"
                           onClick="
                           <?php
                           if ($_SESSION['user_nivel'] > 2) {
                               echo"
                                if (document.diaria.editar.value == '1') {
                                    if (confirm('Você tem certeza que deseja alterar os dados?')) {
                                        verificaErros();
                                    }
                                } else {
                                    alert('Não há o que salvar edite o documento depois salve!');
                                }";
                           } else {
                               echo"
                                   alert('Usuário sem permissão para esta função\\n\Se necessário peça permissão para o supervisor\\n\Ou entre em contato pelo e-mail: jocinei300@gmail.com!\\n\Jocinei(c)2013');";
                           }
                           ?>
                           "> <img src="images/7_.png" name="salvar"
                                width="48" height="48" border="0"> </a></td>

                    <td width="66"
                        style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;">
                        <form action="diaria_usina.php" method="post" name="frmDiaria">
                            <a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image12', '', 'images/diaria.bmp', 1)" 
                               onClick="
            if (confirm('Ir para novo?')) {

                document.frmDiaria.submit();
            }">
                                <input type="hidden" name="unidade_usina" value="<?php echo$unidadeusina; ?>">
                                <img src="images/diaria.png" name="Image12" width="48" height="48" border="0"></a> 
                        </form>
                    </td>

                    <td width="68"
                        style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;">
                        <a href="#" onMouseOut="MM_swapImgRestore()"
                           onMouseOver="MM_swapImage('pesquisar', '', 'images/pesquisar.bmp', 0)"
                           onClick="
                           if(confirm('Persquisar diária?')){
                               location.href=('pesquisa_diaria.php');
                           }
                           "
                           >
                            <img src="images/pesquisar.png" name="pesquisar" width="48"
                                 height="48" border="0"> </a>
                    </td>
                    <td width="66"
                        style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;"><a
                            href="#" onMouseOut="MM_swapImgRestore()"
                            onMouseOver="MM_swapImage('editar', '', 'images/13.bmp', 1)" onClick="
            if (confirm('Você deseja liberar os campos para edição?')) {
                edit()
            }
            ;">
                            <img src="images/13_.png" name="editar" width="48" height="48"
                                 border="0"> </a></td>
                    <td width="64"
                        style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;">
                        <a href="#" onMouseOut="MM_swapImgRestore()" onClick="
                        <?php
                        if ($_SESSION['user_nivel'] > 2) {
                            echo"
                                   if(confirm('[EXCLUSÃO DEFINITIVA!]\\n\___________________________________\\n\Tem certeza que deseja excluir a diária?\\n\
                                   \\n\[aviso!__]Se clicar em ok a diária será excluída \\n\PERMANENTEMENTE')){
                                   window.location=('delete_diaria.php?data=$data&usina=$unidadeusina');
 
                                  }
                                   
                                   
                            ";
                        } else {
                            echo"alert('Usuário sem permissão para esta função\\n\Se necessário peça permissão para o supervisor\\n\Ou entre em contato pelo e-mail: jocinei300@gmail.com!\\n\Jocinei(c)2013');";
                        }
                        ?>
                           "
                           onMouseOver="MM_swapImage('excluir', '', 'images/9_.bmp', 1)">
                            <img src="images/9.png" name="excluir" width="48" height="48"
                                 border="0"> </a></td>
                  
                    <!-- botão imprimir -->
                    <td width="66" 
                        style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;"> 
                        <a href="#" class="imprimir" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('print', '', 'images/print.bmp', 1)">
                            <img src="images/print.png" name="print" width="48" height="48" border="0"></a></td>

                    <td width="66" style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;"><a
                            href="#" onClick="if (confirm('[    LOG OFF!   ]\n\n\Você deseja mesmo sair?')) {
                window.location = ('sign_up.php');
            }" onMouseOut="MM_swapImgRestore()"
                            onMouseOver="MM_swapImage('fechar', '', 'images/fechar.bmp', 1)"><img
                                src="images/fechar.png" name="fechar" width="48" height="48"
                                border="0"> </a> </td>

                    <td width="347" style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;">&nbsp; 
                    </td>
                </tr>
                <!-- ------------------------------------------------------------------------------------------------- -->

                <tr>
                    <td width="67"
                        style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;"><font
                            color="#999999" size="2">Inicio </font></td>

                    <td width="65"
                        style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;"><font
                            color="#999999" size="2">Salvar </font></td>
                    <td width="66"
                        style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;"><font
                            color="#999999" size="2">Novo</font></td>

                    <td width="68"
                        style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;"><font
                            color="#999999" size="2">Pesquisar</font></td>

                    <td width="66"
                        style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;"><font
                            color="#999999" size="2">Editar </font></td>

                    <td width="64"
                        style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;"><font
                            color="#999999" size="2">Excluir </font></td>

                    <td width="66"
                        style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;"><font
                            color="#999999" size="2">Imprimir</font>

                    <td width="66"
                        style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;"><font
                            color="#999999" size="2">Sair</font>



                </tr>


            </tbody>
        </table>


        <a href="#" onMouseOut="MM_swapImgRestore()"
           onMouseOver="MM_swapImage('Image4', '', 'images/7.bmp', 1)"> </a> 
        <div id="wb_Form1" class="camada_para_impressao" 
             style="position: absolute; left: 80px; top: 61px; width: 990px; height: 1329px; z-index: 0;"> 
            <form action="altera_diaria.php" method="post" name="diaria" enctype="multipart/form-data">
                <table style="position: absolute; left: 213px; top: 10px; width: 767px; height: 62px; z-index: 0;"
                       cellpadding="0" cellspacing="0" id="tabelaLabel">
                    <tr> 
                        <td
                            style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: top; width: 428px; height: 58px;"> 
                            <div> <span
                                    style="color: #000000; font-family: Arial; font-size: 13px;"> 
                                    AV. C&Acirc;NDIDO DE ABREU, N&ordm; 776, 23&ordm; ANDAR</span> </div>

                            <div> <span
                                    style="color: #000000; font-family: Arial; font-size: 13px;">CEP.: 
                                    80.530-000 CURITIBA/PR</span> </div>
                            <div> <span
                                    style="color: #000000; font-family: Arial; font-size: 13px;">FONE/FAX: 
                                    (41) 3075-9000</span> </div></td>
                        <td
                            style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: top; height: 58px;"> 
                            <div> <span
                                    style="color: #000000; font-family: Arial; font-size: 19px;"> 
                                    <font size="3">ACOMPANHAMENTO DI&Aacute;RIO DA USINA DE ASFALTO DE
                                    <?php echo "$endereco"; ?></font>  </span> </div>
                        </td>
                    </tr>
                    </tbody>
                </table>


                <table
                    style="position: absolute; left: 30px; top: 71px; width: 184px; height: 128px; z-index: 2;"
                    cellpadding="0" cellspacing="0" id="tabelaLabel">
                    <tbody>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: right; vertical-align: top; height: 19px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;"> 
                                        Obra/Contrato :</span> </div></td>
                        </tr>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: right; vertical-align: top; height: 19px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;"> 
                                        Rodovia/Trecho :</span> </div></td>
                        </tr>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: right; vertical-align: top; height: 19px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;"> 
                                        Local : </span> </div></td>
                        </tr>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: right; vertical-align: top; height: 19px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;"> 
                                        Eng. Respons&aacute;vel :</span> </div></td>
                        </tr>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: right; vertical-align: top; height: 19px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;"> 
                                        Eng. Opera&ccedil;&atilde;o :</span> </div></td>
                        </tr>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: right; vertical-align: top; height: 19px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;"> 
                                        Encarregado :</span> </div></td>
                        </tr>
                </table>
                <table cellpadding="0" cellspacing="0" id="tabelaLabel"
                       style="position: absolute; left: 30px; top: 198px; width: 613px; height: 22px; z-index: 3;"
                       name="tabelaLabel">
                    <tbody>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: top; height: 18px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;"> 
                                        <font size="2">INFORMA&Ccedil;&Otilde;ES SOBRE O FUNCIONAMENTO DA 
                                        USINA DE ASFALTO</font></span> </div></td>
                        </tr>
                    </tbody>
                </table>


                <table
                    style="position: absolute; left: 30px; top: 240px; width: 76px; height: 68px; z-index: 200;"
                    cellpadding="0" cellspacing="0" id="tabelaLabel">
                    <tbody>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 20px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;"> 
                                        In&Iacute;cio</span> </div></td>
                        </tr>
                        <tr> 

                            <td height="26"
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 20px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;"> 
                                        Fim</span> </div></td>
                        </tr>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 20px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;"> 
                                        Total</span> </div></td>
                        </tr>
                    </tbody>
                </table>

                <table
                    style="position: absolute; left: 30px; top: 307px; width: 613; height: 22px; z-index: 202;"
                    cellpadding="0" cellspacing="0" id="tabelaLabel">
                    <tbody>
                        <tr> 

                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: top; height: 18px; font-family: Arial; font-size: 13px;"> 
                                <font size="2">UMIDADE DOS AGREGADOS</font>
                                <div></div></td>
                        </tr>
                    </tbody>
                </table>
                <table
                    style="position: absolute; left: 30px; top: 219px; width: 155; height: 22px; z-index: 7;"
                    cellpadding="0" cellspacing="0" id="tabelaLabel">
                    <tbody>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 18px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;"> 
                                        Hor&aacute;rio de Opera&ccedil;&atilde;o</span> </div></td>
                        </tr>
                    </tbody>
                </table>
                <input name="edInicioOpUsina" type="text" id="edro" readonly="true"
                       style="position: absolute; left: 105px; top: 240px; width: 80; height: 23; line-height: 18px; z-index: 8;" tabindex="1"
                       onChange="calcHoraOpUsina();" value="<?php echo$h_i_op_Usina; ?>">
                <input				name="edFimOpUsina" type="text" id="edro" readonly="true"
                          style="position: absolute; left: 105px; top: 262px; width: 80; height: 22; line-height: 18px; z-index: 9;" tabindex="2"
                          onChange="calcHoraOpUsina();" value="<?php echo$h_f_op_Usina; ?>">
                <input				name="edTotalOpUsina" type="text" id="edReadOnly"
                          style="position: absolute; left: 105px; top: 284; width: 80; height: 23; line-height: 18px; z-index: 10;"
                          value="<?php echo$tot_h_op_usina; ?>" readonly="true">
                <table
                    style="position: absolute; left: 492px; top: 219px; width: 151px; height: 22px; z-index: 11;"
                    cellpadding="0" cellspacing="0" id="tabelaLabel">
                    <tbody>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 18px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;"> 
                                        Produ&ccedil;&atilde;o di&aacute;ria</span> </div></td>
                        </tr>
                    </tbody>
                </table>
                <input name="edProdDiaria" type="text" id="edReadOnly" readonly="true"
                       style="position: absolute; left: 492px; top: 241; width: 151; height: 22; line-height: 18px; z-index: 12;"
                       value="<?php echo$total_massa; ?>" >
                <input name="edMmPulv" type="text"
                       id="edro" readonly="true"
                       style="position: absolute; left: 492px; top: 283px; width: 151; height: 25; line-height: 18px; z-index: 13;"
                       value="<?php echo$chuva; ?>" tabindex="5">
                <table
                    style="position: absolute; left: 184px; top: 240px; width: 76px; height: 68px; z-index: 200;"
                    cellpadding="0" cellspacing="0" id="Table9">
                    <tbody>
                        <tr> 
                            <td height="21"
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 20px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;"> 
                                        Inicial</span> </div></td>
                        </tr>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 20px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;"> 
                                        Final</span> </div></td>
                        </tr>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 20px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;"> 
                                        Total</span> </div></td>
                        </tr>
                    </tbody>
                </table>
                <table
                    style="position: absolute; left: 184px; top: 219px; width: 155; height: 22px; z-index: 15;"
                    cellpadding="0" cellspacing="0" id="tabelaLabel">
                    <tbody>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 18px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;"> 
                                        Hor&iacute;metro da Usina</span> </div></td>
                        </tr>
                    </tbody>
                </table>
                <input name="edHorIniUsina" type="text" id="edReadOnly"
                       style="position: absolute; left: 259px; top: 241px; width: 80; height: 22; line-height: 18px; z-index: 16;"
                       readonly="true" value=<?php echo "$horimetro_inicial"; ?>>
                <input				name="edHorFimUsina" type="text" id="edro" readonly="true"
                          style="position: absolute; left: 259px; top: 262px; width: 80; height: 22; line-height: 18px; z-index: 17;" tabindex="3"
                          onChange="calcHorimUsina();" value="<?php echo$horimetro_final; ?>">
                <input				name="edTotalHorUsina" type="text" id="edReadOnly"
                          style="position: absolute; left: 259px; top: 284; width: 80; height: 23; line-height: 18px; z-index: 18;"
                          value="<?php echo"$total_horim"; ?>" readonly="true">
                <table
                    style="position: absolute; left: 338px; top: 240px; width: 76px; height: 68px; z-index: 200;"
                    cellpadding="0" cellspacing="0" id="tabelaLabel">
                    <tbody>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 20px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;">Inicial 
                                    </span> </div></td>
                        </tr>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 20px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;"> 
                                        Final</span> </div></td>
                        </tr>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 20px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;"> 
                                        Total</span> </div></td>
                        </tr>
                    </tbody>
                </table>

                <table
                    style="position: absolute; left: 338px; top: 219px; width: 155; height: 22px; z-index: 20;"
                    cellpadding="0" cellspacing="0" id="tabelaLabel">

                    <tbody>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 18px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;"> 
                                        Hor&iacute;metro do Gerador</span> </div></td>
                        </tr>
                    </tbody>
                </table>

                <input name="edHorIniGerador" type="text" id="edReadOnly"
                       style="position: absolute; left: 413px; top: 241px; width: 79; height: 22; line-height: 18px; z-index: 21;"
                       readonly="true" value=<?php echo "$horim_ini_ger"; ?>>

                <input				name="edHorFimGerador" type="text" id="edro" readonly="true"
                          style="position: absolute; left: 413px; top: 262px; width: 80; height: 22; line-height: 18px; z-index: 22;"
                          tabindex="4"
                          onChange="calcHorimetroGerador();
            ConsumoHoraDG();" value="<?php echo "$horim_f_ger"; ?>">


                <input				name="edTotalGerador" type="text" id="edReadOnly" readonly="true"
                          style="position: absolute; left: 413px; top: 282px; width: 80; height: 24; line-height: 18px; z-index: 1;"
                          value="<?php echo$total_horim_ger; ?>">
                <table
                    style="position: absolute; left: 492px; top: 262px; width: 151; height: 22px; z-index: 200;"
                    cellpadding="0" cellspacing="0" id="tabelaLabel">
                    <tbody>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 18px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;">Clima/Tempo</span> 
                                </div></td>
                        </tr>
                    </tbody>
                </table>


                <table
                    style="position: absolute; left: 30px; top: 330px; width: 76px; height: 44; z-index: 201;"
                    cellpadding="0" cellspacing="0" id="Table13">
                    <tbody>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 20px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;">Pedra 
                                        3/4:</span> </div></td>
                        </tr>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 20px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;">Pedra 
                                        3/8</span> </div></td>
                        </tr>
                    </tbody>
                </table>

                <input type="text" id="edro" readonly="true"
                       style="position: absolute; left: 105; top: 330px; width: 80; height: 23; line-height: 18px; z-index: 27;"
                       name="edUmid34" value="<?php echo$umid_3_4; ?>" tabindex="6">

                <input type="text"
                       id="edro" readonly="true"
                       style="position: absolute; left: 105; top: 352; width: 80; height: 22; line-height: 18px; z-index: 28;"
                       name="edUmid38" value="<?php echo$umid_3_8; ?>" tabindex="7">

                <table
                    style="position: absolute; left: 184; top: 330; width: 76px; height: 44; z-index: 29;"
                    cellpadding="0" cellspacing="0" id="tabelaLabel">
                    <tbody>
                        <tr> 

                            <td height="21"
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 20px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;">Pedra 
                                        5/16</span> </div></td>
                        </tr>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 20px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;">Pedra 
                                        3/16</span> </div></td>
                        </tr>
                    </tbody>
                </table>

                <input type="text" id="edro" readonly="true"
                       style="position: absolute; left: 259; top: 330; width: 80; height: 23; line-height: 18px; z-index: 30;"
                       name="edUmid516" value="<?php echo$umid_5_16; ?>" tabindex="8">

                <input type="text"
                       id="edro" readonly="true"
                       style="position: absolute; left: 259; top: 352; width: 80; height: 22; line-height: 18px; z-index: 31;"
                       name="edUmid316" value="<?php echo$umid_3_16; ?>" tabindex="9">

                <table
                    style="position: absolute; left: 338; top: 330; width: 153; height: 44; z-index: 203;"
                    cellpadding="0" cellspacing="0" id="tabelaLabel">
                    <tbody>
                        <tr> 

                            <td height="21"
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 20px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;">Areia:</span> 
                                </div></td>
                        </tr>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 20px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;">Umidade 
                                        ponderada:</span> </div></td>
                        </tr>
                    </tbody>
                </table>

                <input type="text" id="edro" readonly="true"
                       style="position: absolute; left: 490px; top: 330px; width: 153; height: 23; line-height: 18px; z-index: 33;"
                       name="edUmidAreia" value="<?php echo$umid_areia; ?>" tabindex="9">

                <input type="text"
                       id="edro" readonly="true"
                       style="position: absolute; left: 490px; top: 352; width: 153px; height: 22px; line-height: 18px; z-index: 34;"
                       name="edUmidP" value="<?php echo$umid_p; ?>" tabindex="10">

                <table
                    style="position: absolute; left: 642px; top: 307; width: 338px; height: 24; z-index: 35;"
                    cellpadding="0" cellspacing="0" id="tabelaLabel">

                    <tbody>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 18px;"> 
                                <div> <span style="font-family: Arial; font-size: 13px; color: #000000;">OBSERVA&Ccedil;&Otilde;ES</span></div></td>
                        </tr>
                    </tbody>
                </table>

                <textarea name="TaObsUmid" id="edro" readonly
                          style="position: absolute; left: 642px; top: 329px; width: 338; height: 46; z-index: 205;"
                          rows="1" cols="49"><?php echo$obs_umd; ?></textarea>

                <table
                    style="position: absolute; left: 30px; top: 373px; width: 950; height: 22px; z-index: 37;"
                    cellpadding="0" cellspacing="0" id="tabelaLabel">

                    <tbody>

                        <tr> 

                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 18px;"> 
                                <div align="left"><font size="2">REGISTRO DE PARADAS</font></div>
                                <div></div></td>
                        </tr>
                    </tbody>
                </table>

                <table
                    style="position: absolute; left: 30px; top: 396; width: 248px; height: 22px; z-index: 200;"
                    cellpadding="0" cellspacing="0" id="Table18">
                    <tbody>
                        <tr> 
                            <td width="128"
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; width: 120px; height: 18px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;">Hor&aacute;rio 
                                        inici al</span> </div></td>
                            <td width="118"
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 18px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;">Final</span> 
                                </div></td>
                        </tr>
                    </tbody>
                </table>


                <table
                    style="position: absolute; left: 277px; top: 396; width: 703; height: 22px; z-index: 200;"
                    cellpadding="0" cellspacing="0" id="tabelaLabel">
                    <tbody>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 18px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;">Descri&ccedil;&atilde;o 
                                        da Parada</span> </div></td>
                        </tr>
                    </tbody>
                </table>


                <input type="text" id="edro" readonly="true"
                       style="position: absolute; left: 30px; top: 417px; width: 123; height: 22; line-height: 18px; z-index: 40;"
                       name="edHIniP[]" value="<?php echo$val_paradas[1][0]; ?>" tabindex="11">


                <input type="text"
                       id="edro" readonly="true"
                       style="position: absolute; left: 152; top: 417px; width: 126; height: 22; line-height: 18px; z-index: 41;"
                       name="edHFP[]" value="<?php echo$val_paradas[1][1]; ?>" tabindex="12">


                <input type="text"
                       id="edro" readonly="true"
                       style="position: absolute; left: 277px; top: 417px; width: 703; height: 22; line-height: 18px; z-index: 42;"
                       name="edObsP[]" value="<?php echo$val_paradas[1][2]; ?>" tabindex="13">


                <input type="text"
                       id="edro" readonly="true"
                       style="position: absolute; left: 30px; top: 438; width: 123; height: 22; line-height: 18px; z-index: 43;"
                       name="edHIniP[]" value="<?php echo$val_paradas[2][0]; ?>" tabindex="14">


                <input type="text"
                       id="edro" readonly="true"
                       style="position: absolute; left: 152; top: 438; width: 126; height: 22; line-height: 18px; z-index: 44;"
                       name="edHFP[]" value="<?php echo$val_paradas[2][1]; ?>" tabindex="15">


                <input type="text"
                       id="edro" readonly="true"
                       style="position: absolute; left: 277; top: 438; width: 703; height: 22; line-height: 18px; z-index: 45;"
                       name="edObsP[]" value="<?php echo$val_paradas[2][2]; ?>" tabindex="16">


                <input type="text"
                       id="edro" readonly="true"
                       style="position: absolute; left: 30px; top: 459; width: 123; height: 22; line-height: 18px; z-index: 46;"
                       name="edHIniP[]" value="<?php echo$val_paradas[3][0]; ?>" tabindex="17">


                <input type="text"
                       id="edro" readonly="true"
                       style="position: absolute; left: 152; top: 459; width: 126; height: 22; line-height: 18px; z-index: 47;"
                       name="edHFP[]" value="<?php echo$val_paradas[3][1]; ?>" tabindex="18">


                <input type="text"
                       id="edro" readonly="true"
                       style="position: absolute; left: 277; top: 459; width: 703; height: 22; line-height: 18px; z-index: 48;"
                       name="edObsP[]" value="<?php echo$val_paradas[3][2]; ?>" tabindex="19">


                <input type="text"
                       id="edro" readonly="true"
                       style="position: absolute; left: 30px; top: 480; width: 123; height: 22; line-height: 18px; z-index: 49;"
                       name="edHIniP[]" value="<?php echo$val_paradas[4][0]; ?>" tabindex="20">


                <input type="text"
                       id="edro" readonly="true"
                       style="position: absolute; left: 152; top: 480; width: 126; height: 22; line-height: 18px; z-index: 50;"
                       name="edHFP[]" value="<?php echo$val_paradas[4][1]; ?>" tabindex="21">


                <input type="text"
                       id="edro" readonly="true"
                       style="position: absolute; left: 277; top: 480; width: 703; height: 22; line-height: 18px; z-index: 51;"
                       name="edObsP[]" value="<?php echo$val_paradas[4][2]; ?>" tabindex="22">

                <table
                    style="position: absolute; left: 30px; top: 500; width: 950; height: 22px; z-index: 52;"
                    cellpadding="0" cellspacing="0" id="tabelaLabel">

                    <tbody>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: top; height: 18px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;">INFORMA&Ccedil;&Otilde;ES 
                                        SOBRE O FUNCIONAMENTO DA CALDEIRA</span></div></td>
                        </tr>
                    </tbody>
                </table>

                <table
                    style="position: absolute; left: 30; top: 542; width: 76px; height: 68px; z-index: 200;"
                    cellpadding="0" cellspacing="0" id="Table21">
                    <tbody>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 20px;"><span
                                    style="font-family: Arial; font-size: 13px; color: #000000;">In&iacute;cio:</span> 
                                <div></div></td>
                        </tr>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 20px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;"> 
                                        Fim</span> </div></td>
                        </tr>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 20px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;"> 
                                        Total</span> </div></td>
                        </tr>
                    </tbody>
                </table>

                <table
                    style="position: absolute; left: 30px; top: 521px; width: 155; height: 22px; z-index: 200;"
                    cellpadding="0" cellspacing="0" id="tabelaLabel">
                    <tbody>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 18px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;"> 
                                        Hor&aacute;rio de Opera&ccedil;&atilde;o</span> </div></td>
                        </tr>
                    </tbody>
                </table>

                <input name="edHIniOpC" type="text" id="edro" readonly="true"
                       style="position: absolute; left: 105px; top: 542px; width: 80; height: 22; line-height: 18px; z-index: 55;" tabindex="23"
                       onChange="calcHoraOpCaldeira();" value="<?php echo$h_ini_c; ?>">

                <input				name="edHFimOpC" type="text" id="edro" readonly="true"
                          style="position: absolute; left: 105px; top: 563px; width: 80; height: 24; line-height: 18px; z-index: 56;" tabindex="24"
                          onChange="calcHoraOpCaldeira();" value="<?php echo$h_f_c; ?>">

                <input name="edTOpC"
                       type="text" id="edReadOnly"
                       style="position: absolute; left: 105px; top: 586; width: 80; height: 23; line-height: 18px; z-index: 57;"
                       value="<?php echo$h_t_c; ?>" readonly="true" tabindex="0">

                <table
                    style="position: absolute; left: 184px; top: 542px; width: 76px; height: 68px; z-index: 200;"
                    cellpadding="0" cellspacing="0" id="Table23">

                    <tbody>
                        <tr> 

                            <td height="26"
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 20px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;"> 
                                        Inicial</span> </div></td>
                        </tr>
                        <tr> 
                            <td height="26"
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 20px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;"> 
                                        Final</span> </div></td>
                        </tr>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 20px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;"> 
                                        Total</span> </div></td>
                        </tr>
                    </tbody>
                </table>

                <input name="edEstqAntDC" type="text" id="edReadOnly"
                       style="position: absolute; left: 179; top: 709px; width: 76; height: 22; line-height: 18px; z-index: 105;"
                       readonly="true" value=<?php echo$estq_ant_d_c; ?>>
                <table
                    style="position: absolute; left: 184px; top: 521px; width: 155; height: 22px; z-index: 200;"
                    cellpadding="0" cellspacing="0" id="tabelaLabel">
                    <tbody>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 18px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;"> 
                                        Hor&iacute;metro da caldeira</span> </div></td>
                        </tr>
                    </tbody>
                </table>
                <input name="edHmIniC" type="text" id="edReadOnly"
                       style="position: absolute; left: 259px; top: 542px; width: 80; height: 22; line-height: 18px; z-index: 60;"
                       value="<?php echo"$horim_ini_cald"; ?>" readonly="true">

                <input				name="edHmFimC" type="text" id="edro" readonly="true"
                          style="position: absolute; left: 259px; top: 563px; width: 80; height: 24; line-height: 18px; z-index: 61;"
                          tabindex="25"
                          onChange="calcHorimetroCaldeira();
            ConsumoHoraDC();" value="<?php echo$horim_f_cald; ?>">

                <input name="edTHmC" type="text" id="edReadOnly"
                       style="position: absolute; left: 259px; top: 586; width: 79; height: 23; line-height: 18px; z-index: 62;"
                       value="<?php echo$horim_total_c; ?>" readonly="true">

                <table
                    style="position: absolute; left: 338px; top: 542px; width: 76px; height: 46px; z-index: 200;"
                    cellpadding="0" cellspacing="0" id="tabelaLabel">
                    <tbody>
                        <tr> 

                            <td height="21"
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 20px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;">Inicial 
                                    </span> </div></td>
                        </tr>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 20px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;"> 
                                        Final</span> </div></td>
                        </tr>
                    </tbody>
                </table>

                <table
                    style="position: absolute; left: 338px; top: 521px; width: 155; height: 22px; z-index: 200;"
                    cellpadding="0" cellspacing="0" id="tabelaLabel">
                    <tbody>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 18px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;">Temperatura 
                                        do CAP</span> </div></td>
                        </tr>
                    </tbody>
                </table>

                <input type="text" id="edro" readonly="true"
                       style="position: absolute; left: 413; top: 542px; width: 80; height: 22; line-height: 18px; z-index: 65;"
                       name="edTIniCAP" value="<?php echo$temp_ini_cap; ?>" tabindex="26">

                <input type="text"
                       id="edro" readonly="true"
                       style="position: absolute; left: 413px; top: 563px; width: 80; height: 24; line-height: 18px; z-index: 66;"
                       name="edTFimCAP" value="<?php echo$temp_fim_cap; ?>" tabindex="27">

                <table
                    style="position: absolute; left: 492px; top: 542px; width: 76px; height: 46px; z-index: 200;"
                    cellpadding="0" cellspacing="0" id="Table27">
                    <tbody>
                        <tr> 

                            <td height="25"
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 20px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;">Quantidade</span> 
                                </div></td>
                        </tr>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 20px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;">Delta</span> 
                                </div></td>
                        </tr>
                    </tbody>
                </table>

                <table
                    style="position: absolute; left: 492px; top: 521px; width: 155; height: 22px; z-index: 200;"
                    cellpadding="0" cellspacing="0" id="Table28">
                    <tbody>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 18px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;">Ton. 
                                        de CAP aquecido</span> </div></td>
                        </tr>
                    </tbody>
                </table>

                <input name="edQtCAPAq" type="text" id="edReadOnly"
                       style="position: absolute; left: 567px; top: 542px; width: 80; height: 22; line-height: 18px; z-index: 83;" value="<?php echo$qtd_cap_aquecido; ?>"
                       readonly="true">

                <input name="edDelta" type="text" id="edReadOnly"
                       style="position: absolute; left: 567; top: 563; width: 80; height: 24; line-height: 18px; z-index: 70;" value="<?php echo$delta; ?>"
                       readonly="true">

                <table
                    style="position: absolute; left: 646px; top: 521px; width: 334; height: 22px; z-index: 200;"
                    cellpadding="0" cellspacing="0" id="Table29">

                    <tbody>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 18px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;">Observa&ccedil;&otilde;es 
                                        gerais </span> </div></td>
                        </tr>
                    </tbody>
                </table>

                <textarea name="taObsC" id="edro" readonly
                          style="position: absolute; left: 646px; top: 542px; width: 334; height: 68px; z-index: 205;"
                          rows="1" cols="49" tabindex="28"><?php echo$obs_cald; ?>
                </textarea>

                <table
                    style="position: absolute; left: 30px; top: 609; width: 950; height: 22px; z-index: 73;"
                    cellpadding="0" cellspacing="0" id="Table30">

                    <tbody>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: top; height: 18px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;">CONDI&Ccedil;&Otilde;ES 
                                        DOS ESTOQUES DE MATERIAIS</span> </div></td>
                        </tr>
                    </tbody>
                </table>

                <table
                    style="position: absolute; left: 30px; top: 630px; width: 75px; height: 38px; z-index: 74;"
                    cellpadding="0" cellspacing="0" id="tabelaLabel">
                    <tbody>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 34px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;">Material</span> 
                                </div></td>
                        </tr>
                    </tbody>
                </table>

                <table
                    style="position: absolute; left: 104; top: 630px; width: 79; height: 38px; z-index: 200;"
                    cellpadding="0" cellspacing="0" id="tabelaLabel">
                    <tbody>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 34px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;">Capacidade</span> 
                                </div></td>
                        </tr>
                    </tbody>
                </table>

                <table
                    style="position: absolute; left: 179px; top: 630px; width: 76px; height: 38px; z-index: 200;"
                    cellpadding="0" cellspacing="0" id="tabelaLabel">
                    <tbody>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: top; height: 34px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;">Estoque 
                                    </span> </div>
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;">Anterior</span> 
                                </div></td>
                        </tr>
                    </tbody>
                </table>

                <table
                    style="position: absolute; left: 254px; top: 630; width: 86px; height: 38px; z-index: 200;"
                    cellpadding="0" cellspacing="0" id="tabelaLabel">
                    <tbody>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: top; height: 34px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;">Recebimento</span> 
                                </div>
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;">de 
                                        material</span> </div></td>
                        </tr>
                    </tbody>
                </table>

                <table
                    style="position: absolute; left: 339px; top: 630; width: 72px; height: 38px; z-index: 200;"
                    cellpadding="0" cellspacing="0" id="tabelaLabel">
                    <tbody>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: top; height: 34px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;">N&ordm; 
                                        Nota</span> </div>
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;">Fiscal</span> 
                                </div></td>
                        </tr>
                    </tbody>
                </table>

                <table
                    style="position: absolute; left: 410px; top: 630; width: 310px; height: 38px; z-index: 200;"
                    cellpadding="0" cellspacing="0" id="tabelaLabel">
                    <tbody>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: top; height: 34px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;">Fornecedor</span> 
                                </div></td>
                        </tr>
                    </tbody>
                </table>

                <table
                    style="position: absolute; left: 719px; top: 630; width: 72px; height: 38px; z-index: 200;"
                    cellpadding="0" cellspacing="0" id="tabelaLabel">
                    <tbody>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: top; height: 34px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;">Medida 
                                    </span> </div>
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;">Vazio</span> 
                                </div></td>
                        </tr>
                    </tbody>
                </table>

                <table
                    style="position: absolute; left: 790px; top: 630; width: 94px; height: 38px; z-index: 200;"
                    cellpadding="0" cellspacing="0" id="tabelaLabel">
                    <tbody>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: top; height: 34px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;">Consumo</span> 
                                </div></td>
                        </tr>
                    </tbody>
                </table>

                <table
                    style="position: absolute; left: 882px; top: 630; width: 98px; height: 38px; z-index: 200;"
                    cellpadding="0" cellspacing="0" id="tabelaLabel">
                    <tbody>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: top; height: 34px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;">Estoque 
                                        final</span> </div></td>
                        </tr>
                    </tbody>
                </table>

                <table
                    style="position: absolute; left: 30px; top: 667; width: 75; height: 22px; z-index: 200;"
                    cellpadding="0" cellspacing="0" id="Table40">
                    <tbody>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;">CAP</span> 
                                </div></td>
                        </tr>
                    </tbody>
                </table>

                <input name="edKgCap" type="text" id="edReadOnly"
                       style="position: absolute; left: 103px; top: 667px; width: 77; height: 22; line-height: 18px; z-index: 85;"
                       value="<?php echo"$cap_cap"; ?>" readonly="true">

                <input				name="edRcbCap" type="text" id="edro" readonly="true"
                          style="position: absolute; left: 254px; top: 667px; width: 86px; height: 22px; line-height: 18px; z-index: 86;"
                          onBlur="calcConsumoCap();" value="<?php echo$qtd_mat_rcb_cap; ?>">

                <input name="edEstqAntCap"
                       type="text" id="edReadOnly"
                       style="position: absolute; left: 179; top: 667px; width: 76; height: 22; line-height: 18px; z-index: 87;" value="<?php echo$estq_ant_cap; ?>" readonly="true">

                <input				name="edNFCap"
                          type="text" id="edro"
                          style="position: absolute; left: 339px; top: 667; width: 72; height: 22; line-height: 18px; z-index: 88;" onChange="calcConsumoCap();" value="<?php echo$nf_cap; ?>">

                <select name="edFornCap"  id="edro" style="position:absolute;left:410px;top:667px;width:309;height:22;line-height:18px;z-index:89;" readonly="true" onchange="if (document.diaria.editar.value == '0') {
                this.options[0].selected = true;
            }">
                            <?php
                            if ($forn_cap != '') {
                                echo"<option value=$cod_forn_cap>" . $forn_cap . "</option>";
                            }
                            ?>
                    <option></option>
                    <?php
                    include 'conecta.php';
                    $cnsFornCap = mysql_query("select * from empresas where categoria = 3 and cod_fornecedor <> $cod_forn_cap  order by nome asc") or die(mysql_error());
                    while ($valor = mysql_fetch_array($cnsFornCap)) {
                        echo "<option value=$valor[0]>$valor[1]</option>";
                    }
                    ?>
                </select>

                <input name="edCmCap" type="text" id="edro" readOnly="true"
                       style="position: absolute; left: 719px; top: 667; width: 72; height: 22; line-height: 18px; z-index: 90;"
                       onChange="buscMedCap();
            calcConsumoCap();" value="<?php echo$cm_cap; ?>">

                <input name="edCnsCap" type="text"
                       id="edReadOnly"
                       style="position: absolute; left: 790px; top: 667; width: 95; height: 22; line-height: 18px; z-index: 91;"
                       value="<?php echo$consumo_cap; ?>" readonly="true" align="center">

                <input name="edEstqFCap"
                       type="text" id="edReadOnly"
                       style="position: absolute; left: 882px; top: 667; width: 98px; height: 22px; line-height: 18px; z-index: 92;"
                       value="<?php echo$estq_final_cap; ?>" readonly="true">

                <table
                    style="position: absolute; left: 30px; top: 688px; width: 75; height: 22px; z-index: 200;"
                    cellpadding="0" cellspacing="0" id="tabelaLabel">
                    <tbody>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;">XISTO</span> 
                                </div></td>
                        </tr>
                    </tbody>
                </table>

                <input name="edKgX" type="text" id="edReadOnly"
                       style="position: absolute; left: 103; top: 688px; width: 77; height: 22; line-height: 18px; z-index: 94;"
                       value="<?php echo"$cap_xisto"; ?>" readonly="true">

                <input				name="edRcbX" type="text" id="edro" readOnly="true"
                          style="position: absolute; left: 254px; top: 688px; width: 86; height: 22; line-height: 18px; z-index: 95;"
                          onChange="calcConsumoXisto();" value="<?php echo$qtd_mat_rcb_x; ?>">

                <input name="edEstqAntX"
                       type="text" id="edReadOnly"
                       style="position: absolute; left: 179; top: 688px; width: 76; height: 22; line-height: 18px; z-index: 96;"
                       readonly="true" value=<?php echo$estq_ant_x; ?>>

                <input				type="text" id="edro" readOnly="true"
                          style="position: absolute; left: 339px; top: 688; width: 72; height: 22; line-height: 18px; z-index: 97;"
                          name="edNFX" value="<?php echo$nf_x; ?>">

                <select id="edro" style="position: absolute; left: 410px; top: 688; width: 309; height: 22; line-height: 18px; z-index: 98;" name="edFornX" onchange="if (document.diaria.editar.value == '0') {
                this.options[0].selected = true;
            }">
                            <?php
                            if ($forn_x != '') {
                                echo"<option value=" . $cod_forn_x . ">" . $forn_x . "</option>";
                            }
                            ?>
                    <option></option>
                    <?php
                    include 'conecta.php';
                    $cnsFornx = mysql_query("select * from empresas where categoria = 3 and cod_fornecedor <> $cod_forn_x  order by nome asc") or die(mysql_error());
                    while ($valor = mysql_fetch_array($cnsFornx)) {
                        echo "<option value=$valor[0]>$valor[1]</option>";
                    }
                    ?>
                </select>

                <input name="edCmX" type="text" id="edro" readOnly="true"
                       style="position: absolute; left: 719px; top: 688; width: 72; height: 22; line-height: 18px; z-index: 99;"
                       onChange="buscMedXisto();
            calcConsumoXisto();" value="<?php echo$cm_x; ?>">

                <input name="edCnsX" type="text"
                       id="edReadOnly"
                       style="position: absolute; left: 790px; top: 688; width: 95; height: 22; line-height: 18px; z-index: 100;"
                       value="<?php echo$consumo_x; ?>" readonly="true">

                <input name="edEstqFX" type="text"
                       id="edReadOnly"
                       style="position: absolute; left: 882px; top: 688; width: 98; height: 22; line-height: 18px; z-index: 101;"
                       value="<?php echo$estq_final_x; ?>" readonly="true">

                <table
                    style="position: absolute; left: 30px; top: 709px; width: 75; height: 22px; z-index: 200;"
                    cellpadding="0" cellspacing="0" id="tabelaLabel">
                    <tbody>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;">DIESEL 
                                        C</span> </div></td>
                        </tr>
                    </tbody>
                </table>

                <input name="edKgDC" type="text" id="edReadOnly"
                       style="position: absolute; left: 103px; top: 709px; width: 77; height: 22; line-height: 18px; z-index: 103;"
                       value="<?php echo"$cap_die_cald"; ?>" readonly="true">

                <input				name="edRcbDC" type="text" id="edro"
                          style="position: absolute; left: 254px; top: 709px; width: 86; height: 22; line-height: 18px; z-index: 104;" readonly="true"
                          onBlur="if (this.value == '') {
                this.value = 0;
            }"
                          onChange="calcConsumoDieC();
            calcCnsD();
            ConsumoHoraDC();"
                          value="<?php echo$qtd_mat_rcb_dc; ?>">

                <input
                    type="text" id="edNaoEditavel"
                    style="position: absolute; left: 339px; top: 709; width: 72; height: 22; line-height: 18px; z-index: 1;"
                    name="Editbox7" readonly="true">

                <input type="text" id="edNaoEditavel" readonly="true"
                       style="position: absolute; left: 410px; top: 709; width: 310; height: 22; line-height: 18px; z-index: 107;"
                       name="edFornDC" value="">

                <input name="edCmDC" type="text"
                       id="edro" readOnly="true"
                       style="position: absolute; left: 719px; top: 709; width: 72; height: 22; line-height: 18px; z-index: 108;"
                       onChange="buscMedDieC();
            calcConsumoDieC();
            calcCnsD();
            ConsumoHoraDC();" value="<?php echo$cm_dc; ?>">

                <input name="edCnsDC" type="text"
                       id="edReadOnly"
                       style="position: absolute; left: 790px; top: 709; width: 95; height: 22; line-height: 18px; z-index: 109;" value="<?php echo$consumo_dc; ?>" readonly="true">

                <input name="edEstqFDC" type="text"
                       id="edReadOnly"
                       style="position: absolute; left: 882px; top: 709; width: 98px; height: 22; line-height: 18px; z-index: 110;"
                       value="<?php echo$estq_f_d_c; ?>" readonly="true">

                <table
                    style="position: absolute; left: 30px; top: 729px; width: 75; height: 22px; z-index: 200;"
                    cellpadding="0" cellspacing="0" id="tabelaLabel">
                    <tbody>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;">GERADOR</span> 
                                </div></td>
                        </tr>
                    </tbody>
                </table>

                <input name="edKgG" type="text" id="edReadOnly"
                       style="position: absolute; left: 103; top: 729; width: 77; height: 22px; line-height: 18px; z-index: 112;"
                       value="<?php echo"$cap_ger"; ?>" readonly="true">

                <input				name="edRcbDG" type="text" id="edro" readOnly="true"
                          style="position: absolute; left: 254px; top: 729px; width: 86; height: 22; line-height: 18px; z-index: 113;"
                          onBlur="if (this.value == '') {
                this.value = 0;
            }"
                          onChange="calcConsumoDieG();
            calcCnsD();
            ConsumoHoraDG();"
                          value="<?php echo$qtd_mat_rcb_ger; ?>">

                <input name="edEstqAntDG" type="text" id="edReadOnly"
                       style="position: absolute; left: 179px; top: 729px; width: 76; height: 22; line-height: 18px; z-index: 114;"
                       value="<?php echo$estq_ant_d_g; ?>" readonly="true">

                <input type="text" id="edNaoEditavel" readonly="true"
                       style="position: absolute; left: 410px; top: 729; width: 310; height: 22; line-height: 18px; z-index: 116;"
                       name="edFornDG" value="">

                <input type="text" id="edNaoEditavel" readonly="true"
                       style="position: absolute; left: 410px; top: 771; width: 310; height: 22; line-height: 18px; z-index: 116;"
                       name="edFornDG" value="">

                <input name="text" type="text"
                       id="edNaoEditavel"
                       style="position: absolute; left: 719px; top: 729; width: 72; height: 22; line-height: 18px; z-index: 117;"
                       onChange="calcCnsD();" readonly="true">

                <input name="edCnsDG"
                       type="text" id="edReadOnly"
                       style="position: absolute; left: 790px; top: 729; width: 95; height: 22; line-height: 18px; z-index: 118;"
                       value="<?php echo$consumo_ger; ?>" readonly="true">

                <input name="edEstqFDG" type="text"
                       id="edro" readOnly="true"
                       style="position: absolute; left: 882px; top: 729; width: 98; height: 22px; line-height: 18px; z-index: 119;"
                       onChange="calcConsumoDieG();
            calcCnsD();
            ConsumoHoraDG();"
                       value="<?php echo$estq_f_d_g; ?>">

                <table
                    style="position: absolute; left: 30px; top: 750; width: 75; height: 22px; z-index: 200;"
                    cellpadding="0" cellspacing="0" id="tabelaLabel">
                    <tbody>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;">CAL</span> 
                                </div></td>
                        </tr>
                    </tbody>
                </table>

                <input name="edKgCal" type="text" id="edNaoEditavel"
                       style="position: absolute; left: 103; top: 750; width: 77; height: 22; line-height: 18px; z-index: 121;"
                       readonly="true">

                <input name="edRcbCal" type="text" id="edro" readOnly="true"
                       style="position: absolute; left: 254; top: 750; width: 86; height: 22; line-height: 18px; z-index: 122;"
                       onBlur="if (this.value == '') {
                this.value = 0;
            }"
                       onChange="calcEstoqueFinalCAL();
            teorCAL();" value="<?php echo$qtd_mat_rcb_cal; ?>">
                <input				name="edNFCal"
                          type="text" id="edro" readOnly="true"
                          style="position: absolute; left: 339px; top: 750; width: 72; height: 22; line-height: 18px; z-index: 124;" value="<?php echo$nf_cal; ?>">

                <select id="edro" onchange="if (document.diaria.editar.value == '0') {
                this.options[0].selected = true;
            }"
                        style="position: absolute; left: 410px; top: 750; width: 309; height: 22; line-height: 18px; z-index: 125;"
                        name="edFornCal">
                            <?php
                            if ($forn_cal != '') {
                                echo"<option value=$cod_forn_cal>" . $forn_cal . "</option>";
                            }
                            ?>
                    <option></option>
                    <?php
                    include 'conecta.php';
                    $cnsForncal = mysql_query("select * from empresas where categoria = 3 and cod_fornecedor <> $cod_forn_cal  order by nome asc") or die(mysql_error());
                    while ($valor = mysql_fetch_array($cnsForncal)) {
                        echo "<option value=$valor[0]>$valor[1]</option>";
                    }
                    ?>
                </select>

                <input type="text" id="edNaoEditavel" readonly="true"
                       style="position: absolute; left: 719px; top: 750; width: 72; height: 22; line-height: 18px; z-index: 126;"
                       name="Edit" value="">

                <input name="edCnsCAL" type="text"
                       id="edro" readOnly="true"
                       style="position: absolute; left: 790px; top: 750; width: 95; height: 22; line-height: 18px; z-index: 127;"
                       onChange="calcEstoqueFinalCAL();
            teorCAL();" value="<?php echo$consumo_cal; ?>">

                <input name="edEstqFCal" type="text"
                       id="edReadOnly" readOnly="true"
                       style="position: absolute; left: 882px; top: 750; width: 98; height: 22; line-height: 18px; z-index: 128;"
                       value="<?php echo$estq_f_cal; ?>">

                <table
                    style="position: absolute; left: 30px; top: 792px; width: 75; height: 22px; z-index: 200;"
                    cellpadding="0" cellspacing="0" id="tabelaLabel">
                    <tbody>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;">RES. 
                                        DIES</span> </div></td>
                        </tr>
                    </tbody>
                </table>


                <table
                    style="position: absolute; left: 30px; top: 771px; width: 75; height: 22px; z-index: 200;"
                    cellpadding="0" cellspacing="0" id="tabelaLabel">
                    <tbody>
                        <tr> 

                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px; font-family: Arial; font-size: 13px;"> 
                                CPC-5010 
                                <div></div></td>
                        </tr>
                    </tbody>
                </table>

                <input name="edKgResDie" type="text" id="edReadOnly"
                       style="position: absolute; left: 103; top: 792; width: 77; height: 22; line-height: 18px; z-index: 130;"
                       value="<?php echo"$cap_res_die"; ?>" readonly="true">

                <input name="edKgResDie" type="text" id="edReadOnly"
                       style="position: absolute; left: 103; top: 771; width: 77; height: 22; line-height: 18px; z-index: 130;" readonly="true">


                <input                       name="edRcbD" type="text" id="edro" readOnly="true"
                                             style="position: absolute; left: 254; top: 771; width: 86; height: 22; line-height: 18px; z-index: 131;"
                                             onBlur="if (this.value == '') {
                this.value = 0;
            }"
                                             onChange="calcCnsD();">
                <input                       name="edRcbD" type="text" id="edro" readOnly="true"
                                             style="position: absolute; left: 254; top: 792; width: 86; height: 22; line-height: 18px; z-index: 131;"
                                             onBlur="if (this.value == '') {
                this.value = 0;
            }"
                                             onChange="calcCnsD();" value="<?php echo$qtd_mat_rcb_d; ?>">
    <input                       name="edEstqAntCPC" type="text" id="edEstqAntD"
                       style="position: absolute; left: 179; top: 771; width: 76; height: 22; line-height: 18px; z-index: 132;" value="<?php echo$estoqueFinal_CPC; ?>" readonly="true">
    
    <input type="text" id="edReadOnly" readonly="true"
                       style="position: absolute; left: 179; top: 792; width: 76; height: 22; line-height: 18px; z-index: 132;"
                       name="edEstqAntD" value=<?php echo$estq_ant_diesel; ?>>

                <input                       type="text" id="edNaoEditavel" readOnly="true"
                                             style="position: absolute; left: 339px; top: 771; width: 72; height: 22; line-height: 18px; z-index: 1;"
                                             name="edNFD" >
                <input                       type="text" id="edro" readOnly="true"
                                             style="position: absolute; left: 339px; top: 792; width: 72; height: 22; line-height: 18px; z-index: 133;"
                                             name="edNFD" value="<?php echo$nf_d; ?>">

                <select id="edro" onchange="if (document.diaria.editar.value == '0') {
                this.options[0].selected = true;
            }"
                        style="position: absolute; left: 410px; top: 792; width: 308px; height: 22; line-height: 18px; z-index: 134;"
                        name="edFornD">
                            <?php
                            if ($forn_d != '') {
                                echo"<option value=$cod_forn_d>" . $forn_d . "</option>";
                            }
                            ?>
                    <option></option>
                    <?php
                    include 'conecta.php';
                    $cnsFornd = mysql_query("select * from empresas where categoria = 3 and cod_fornecedor <> $cod_forn_d  order by nome asc") or die(mysql_error());
                    while ($valor = mysql_fetch_array($cnsFornd)) {
                        echo "<option value=$valor[0]>$valor[1]</option>";
                    }
                    ?>
                </select>

                <input type="text" id="edNaoEditavel" readonly="true"
                       style="position: absolute; left: 719px; top: 771; width: 72; height: 22; line-height: 18px; z-index: 135;"
                       name="Editbox7" value="">

                <input type="text" id="edNaoEditavel" readonly="true"
                       style="position: absolute; left: 719px; top: 792; width: 72; height: 22; line-height: 18px; z-index: 135;"
                       name="Editbox7" value="">

                <input name="edCnsD" type="text"
                       id="edReadOnly"
                       style="position: absolute; left: 790px; top: 771; width: 95; height: 22; line-height: 18px; z-index: 136;" readonly="true">


                <input name="edCnsD" type="text"
                       id="edReadOnly"
                       style="position: absolute; left: 790px; top: 792; width: 95; height: 22; line-height: 18px; z-index: 136;"
                       value="<?php echo$consumo_d; ?>" readonly="true">

                <input name="edEstqFD" type="text"
                       id="edReadOnly"
                       style="position: absolute; left: 882px; top: 771; width: 98; height: 22; line-height: 18px; z-index: 137;" readonly="true">

                <input name="edEstqFD" type="text"
                       id="edReadOnly"
                       style="position: absolute; left: 882px; top: 792; width: 98; height: 22; line-height: 18px; z-index: 137;"
                       value="<?php echo$estq_f_diesel; ?>" readonly="true">



                <table
                    style="position: absolute; left: 30px; top: 813px; width: 950; height: 22px; z-index: 200;"
                    cellpadding="0" cellspacing="0" id="tabelaLabel">

                    <tbody>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: top; height: 18px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;">CONTROLE 
                                        DE TEOR E M&Eacute;IDA DE CONSUMO DOS MATERIAIS</span></div></td>
                        </tr>
                    </tbody>
                </table>



                <table style="position: absolute; left: 30px; top: 834; width: 950px; height: 22px; z-index: 200;"cellpadding="0" cellspacing="0" id="tabelaLabel">
                    <tr> 

                        <td style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;"> 
                            <font size="2">TEOR BETUMINOSO DE CAP</font></td>

                        <td style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;">
                            <font size="2"><?php echo$teor_cap; ?></font>
                        </td>
                        <td style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;"> 
                            <font size="2">
                            <?php
                            $teor_cap = explode(',', $teor_cap);
                            $teor_cap = $teor_cap[0] . '.' . $teor_cap[1];
                            if ($teor_cap < 4.8) {
                                echo"TEOR ABAIXO DA MÉDIA";
                            } elseif ($teor_cap < 5.1) {
                                echo "TEOR DENTRO DA MÉDIA";
                            } else {
                                echo "TEOR ACIMA DA MÉDIA";
                            }
                            ?>
                            </font>
                        </td>
                    </tr>
                    <tr> 

                        <td height="24" style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;"> 
                            <font size="2">CONSUMO DE XISTO POR TONELADA</font> </td>
                        <td style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;"> 
                            <font size="2"> <?php echo$teor_x; ?></font> 
                        </td>
                        <td style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;"> 
                            <font size="2">
                            <?php
                            $teor_x = explode(',', $teor_x);
                            $teor_x = $teor_x[0] . '.' . $teor_x[1];
                            if ($teor_x < 4.5) {
                                echo'CONSUMO ABAIXO DA MÉDIA';
                            } elseif ($teor_x < 5.5) {
                                echo 'CONSUMO DENTRO DA MÉDIA';
                            } else {
                                echo('CONSUMO ACIMA DA MÉDIA');
                            }
                            ?>
                            </font>
                        </td>
                    </tr>
                    <tr> 
                        <td style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;"> 
                            <font size="2">
                            MÉDIA DE CONSUMO DA CALDEIRA
                            </font>
                        </td>
                        <td style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;"> 
                            <font size=2><?php echo $teor_dc; ?></font> 
                        </td>
                        <td style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;"> 
                            <font size="2">
                            <?php
                            $teor_dc = explode(',', $teor_dc);
                            $teor_dc = $teor_dc[0] . '.' . $teor_dc[1];
                            if ($teor_dc < 16) {
                                echo'CONSUMO MUITO BAIXO: VERIFICAR CONSUMO!';
                            } elseif ($teor_dc < 19) {
                                echo "CONSUMO ABAIXO DA MÉDIA";
                            } elseif ($teor_dc < 25) {
                                echo 'CONSUMO DENTRO DA MÉDIA';
                            } else {
                                echo('CONSUMO ACIMA DA MÉDIA');
                            }
                            ?>
                            </font>
                        </td>
                    </tr>
                    <tr> 
                        <td style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;"> 
                            <font size="2">
                            MÉDIA DE CONSUMO DE GERADOR
                            </font>
                        </td>
                        <td style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;"> 
                            <font size="2">
                            <?php echo$teor_ger; ?>
                            </font>
                        </td>
                        <td style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;"> 
                            <font size="2">
                            <?php
                            $teor_ger = explode(',', $teor_ger);
                            $teor_ger = $teor_ger[0] . '.' . $teor_ger[1];
                            if ($teor_ger < 13) {
                                echo'CONSUMO ABAIXO DA MÉDIA';
                            } elseif ($teor_ger < 17) {
                                echo 'CONSUMO DENTRO DA MÉDIA';
                            } elseif ($teor_ger > 17) {
                                echo('CONSUMO ACIMA DA MÉDIA');
                            }
                            ?>
                            </font> 
                        </td>
                    </tr>
                    <tr> 
                        <td style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;"> 
                            <font size="2">
                            PORCENTAGEM DE CAL USADO
                            </font>
                        </td>
                        <td style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;"> 
                            <font size="2">
                            <?php echo$teor_cal; ?>
                            </font>
                        </td>
                        <td style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;"> 
                            <font size="2">
                            <?php
                            $teor_cal = explode(',', $teor_cal);
                            $teor_cal = $teor_cal[0] . '.' . $teor_cal[1];
                            if ($teor_cal == 0.00) {
                                echo('NÃO UTILIZADO!!');
                            } elseif ($teor_cal < 0.9) {
                                echo'CONSUMO ABAIXO DA MÉDIA';
                            } elseif ($teor_cal < 1.5) {
                                echo 'CONSUMO DENTRO DA MÉDIA';
                            } else {
                                echo"CONSUMO ACIMA DA MÉDIA";
                            }
                            ?> </font>
                        </td>
                    </tr>
                </table>

                <table
                    style="position: absolute; left: 30px; top: 945px; width: 950; height: 22px; z-index: 206;"
                    cellpadding="0" cellspacing="0" id="tabelaLabel">
                    <tbody>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: top; height: 18px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;">OBSERVA&Ccedil;&Otilde;ES 
                                        GERAIS </span></div></td>
                        </tr>
                    </tbody>
                </table>


                <textarea name="taObs" id="edro" readOnly
                          style="position: absolute; left: 30px; top: 965px; width: 950px; height: 103px; z-index: 205;"
                          rows="3" cols="152"><?php echo$obs_usina; ?></textarea>

                <table
                    style="position: absolute; left: 30px; top: 1067px; width: 950; height: 23; z-index: 200;"
                    cellpadding="0" cellspacing="0" id="tabelaLabel">

                    <tbody>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: top; height: 18px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;">SA&Iacute;DA 
                                        DE MATERIAL BETUMINOSO</span></div></td>
                        </tr>
                    </tbody>
                </table>

                <table
                    style="position: absolute; left: 30px; top: 1089; width: 152; height: 22px; z-index: 157;"
                    cellpadding="0" cellspacing="0" id="tabelaLabel">
                    <tbody>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;">Material</span> 
                                </div></td>
                        </tr>
                    </tbody>
                </table>
                <table
                    style="position: absolute; left: 181px; top: 1089; width: 92; height: 22px; z-index: 158;"
                    cellpadding="0" cellspacing="0" id="tabelaLabel">
                    <tbody>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;">Quantidade</span> 
                                </div></td>
                        </tr>
                    </tbody>
                </table>

                <table
                    style="position: absolute; left: 271px; top: 1089; width: 66px; height: 22px; z-index: 159;"
                    cellpadding="0" cellspacing="0" id="tabelaLabel">

                    <tbody>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;">Cargas</span> 
                                </div></td>
                        </tr>
                    </tbody>
                </table>

                <table
                    style="position: absolute; left: 336px; top: 1089; width: 190px; height: 22px; z-index: 160;"
                    cellpadding="0" cellspacing="0" id="tabelaLabel">
                    <tbody>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;">Obra</span> 
                                </div></td>
                        </tr>
                    </tbody>
                </table>

                <table
                    style="position: absolute; left: 524px; top: 1089; width: 456px; height: 22px; z-index: 161;"
                    cellpadding="0" cellspacing="0" id="tabelaLabel">

                    <tbody>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: center; vertical-align: middle; height: 18px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;">Transportadora</span> 
                                </div></td>
                        </tr>
                    </tbody>
                </table>

                <select id="edro" onchange="if (document.diaria.editar.value == '0') {
                this.options[0].selected = true;
            }"
                        style="position: absolute; left: 30px; top: 1109px; width: 152; height: 24; line-height: 18px; z-index: 162;"
                        name="edMat1">
                            <?php
                            if ($val_betumes[1][0] != '') {
                                echo"<option value={$val_betumes[1][5]}>" . $val_betumes[1][0] . "</option>";
                            }
                            ?>
                    <option></option>
                    <?php
                    $cnsBetume = mysql_query("select * from betumes where cod_betume<>{$val_betumes[1][5]} order by nome asc ");
                    while ($valor = mysql_fetch_array($cnsBetume)) {
                        echo "<option value=$valor[0]>$valor[1]</option>";
                    }
                    ?>
                </select>


                <input name="edQtdMat1" type="text" id="edro" readOnly="true"
                       style="position: absolute; left: 181px; top: 1109; width: 91; height: 24; line-height: 18px; z-index: 163;"
                       onChange="calcMassa();
            teorCAL();" value="<?php echo$val_betumes[1][1]; ?>">


                <input name="edCargas1" type="text" id="edro" readonly="true"
                       style="position: absolute; left: 271px; top: 1109; width: 66; height: 24; line-height: 18px; z-index: 164;"
                       onChange="calcCargas();" value="<?php echo$val_betumes[1][2]; ?>">

                <select id="edro" onchange="if (document.diaria.editar.value == '0') {
                this.options[0].selected = true;
            }"
                        style="position: absolute; left: 336px; top: 1109; width: 189; height: 24; line-height: 18px; z-index: 165;"
                        name="edObra1">
                            <?php
                            if ($val_betumes[1][3] != '') {
                                echo"<option value={$val_betumes[1][6]}>" . $val_betumes[1][3] . "</option>";
                            }
                            ?>
                    <option></option>
                    <?php
                    $cnsObra = mysql_query("select * from obras where cod_obra <> {$val_betumes[1][6]} order by nome asc");
                    while ($valor = mysql_fetch_array($cnsObra)) {
                        echo "<option value=$valor[0]>$valor[1]</option>";
                    }
                    ?>
                </select>

                <select id="edro" onchange="if (document.diaria.editar.value == '0') {
                this.options[0].selected = true;
            }"
                        style="position: absolute; left: 525px; top: 1109; width: 455px; height: 24px; line-height: 18px; z-index: 166;"
                        name="edTransportadora1">
                            <?php
                            if ($val_betumes[1][4] != '') {
                                echo"<option value={$val_betumes[1][7]}>" . $val_betumes[1][4] . "</option>";
                            }
                            ?>
                    <option></option>
                    <?php
                    $cnsTransp = mysql_query("select * from transportadora where cod_transp <> {$val_betumes[1][7]} order by nome asc");
                    while ($valor = mysql_fetch_array($cnsTransp)) {
                        echo "<option value=$valor[0]>$valor[1]</option>";
                    }
                    ?>
                </select>

                <select id="edro"  onchange="if (document.diaria.editar.value == '0') {
                this.options[0].selected = true;
            }"
                        style="position: absolute; left: 30px; top: 1130; width: 152; height: 24; line-height: 18px; z-index: 167;"
                        name="edMat2">
                            <?php
                            if ($val_betumes[2][0] != '') {
                                echo"<option value={$val_betumes[2][5]}>" . $val_betumes[2][0] . "</option>";
                            }
                            ?>
                    <option></option>
                    <?php
                    include 'conecta.php';
                    $cnsBetume = mysql_query("select * from betumes where cod_betume<>{$val_betumes[2][5]} order by nome asc ");
                    while ($valor = mysql_fetch_array($cnsBetume)) {
                        echo "<option value=$valor[0]>$valor[1]</option>";
                    }
                    ?>
                </select>


                <input name="edQtdMat2" type="text" id="edro" readOnly="true"
                       style="position: absolute; left: 181px; top: 1130; width: 91; height: 24; line-height: 18px; z-index: 168;"
                       onChange="calcMassa();
            teorCAL();" value="<?php echo$val_betumes[2][1]; ?>">


                <input name="edCargas2" type="text" id="edro" readonly="true"
                       style="position: absolute; left: 271px; top: 1130; width: 66; height: 24; line-height: 18px; z-index: 169;"
                       onChange="calcCargas();" value="<?php echo$val_betumes[2][2]; ?>">

                <select id="edro" onchange="if (document.diaria.editar.value == '0') {
                this.options[0].selected = true;
            }"
                        style="position: absolute; left: 336px; top: 1130; width: 189; height: 24; line-height: 18px; z-index: 170;"
                        name="edObra2">
                            <?php
                            if ($val_betumes[2][3] != '') {
                                echo"<option value={$val_betumes[2][6]}>" . $val_betumes[2][3] . "</option>";
                            }
                            ?>
                    <option></option>
                    <?php
                    $cnsObra = mysql_query("select * from obras where cod_obra <> {$val_betumes[2][6]} order by nome asc");
                    while ($valor = mysql_fetch_array($cnsObra)) {
                        echo "<option value=$valor[0]>$valor[1]</option>";
                    }
                    ?>
                </select>

                <select id="edro" onchange="if (document.diaria.editar.value == '0') {
                this.options[0].selected = true;
            }"
                        style="position: absolute; left: 525px; top: 1130; width: 455; height: 24; line-height: 18px; z-index: 171;"
                        name="edTransportadora2">
                            <?php
                            if ($val_betumes[2][4] != '') {
                                echo"<option value={$val_betumes[2][7]}>" . $val_betumes[2][4] . "</option>";
                            }
                            ?>
                    <option></option>
                    <?php
                    $cnsTransp = mysql_query("select * from transportadora where cod_transp <> {$val_betumes[2][7]} order by nome asc");
                    while ($valor = mysql_fetch_array($cnsTransp)) {
                        echo "<option value=$valor[0]>$valor[1]</option>";
                    }
                    ?>
                </select>

                <select id="edro"  onchange="if (document.diaria.editar.value == '0') {
                this.options[0].selected = true;
            }"
                        style="position: absolute; left: 30px; top: 1153; width: 152; height: 24; line-height: 18px; z-index: 172;"
                        name="edMat3">
                            <?php
                            if ($val_betumes[3][0] != '') {
                                echo"<option value={$val_betumes[3][5]}>" . $val_betumes[3][0] . "</option>";
                            }
                            ?>
                    <option></option>
                    <?php
                    include 'conecta.php';
                    $cnsBetume = mysql_query("select * from betumes where cod_betume<>{$val_betumes[3][5]} order by nome asc ");
                    while ($valor = mysql_fetch_array($cnsBetume)) {
                        echo "<option value=$valor[0]>$valor[1]</option>";
                    }
                    ?>
                </select>


                <input name="edQtdMat3" type="text" id="edro" readonly="true"
                       style="position: absolute; left: 181px; top: 1153; width: 91; height: 24; line-height: 18px; z-index: 173;"
                       onChange="calcMassa();
            teorCAL();" value="<?php echo$val_betumes[3][1]; ?>">


                <input name="edCargas3" type="text" id="edro" readonly="true"
                       style="position: absolute; left: 271px; top: 1153; width: 66; height: 24; line-height: 18px; z-index: 174;"
                       onChange="calcCargas();" value="<?php echo$val_betumes[3][2]; ?>">

                <select id="edro" onchange="if (document.diaria.editar.value == '0') {
                this.options[0].selected = true;
            }"
                        style="position: absolute; left: 336px; top: 1153; width: 189; height: 24; line-height: 18px; z-index: 175;"
                        name="edObra3">
                            <?php
                            if ($val_betumes[3][3] != '') {
                                echo"<option value={$val_betumes[3][6]}>" . $val_betumes[3][3] . "</option>";
                            }
                            ?>
                    <option></option>
                    <?php
                    $cnsObra = mysql_query("select * from obras where cod_obra <> {$val_betumes[3][6]} order by nome asc");
                    while ($valor = mysql_fetch_array($cnsObra)) {
                        echo "<option value=$valor[0]>$valor[1]</option>";
                    }
                    ?>
                </select>


                <select id="edro" onchange="if (document.diaria.editar.value == '0') {
                this.options[0].selected = true;
            }"
                        style="position: absolute; left: 525px; top: 1153; width: 455; height: 24; line-height: 18px; z-index: 176;"
                        name="edTransportadora3">
                            <?php
                            if ($val_betumes[3][4] != '') {
                                echo"<option value={$val_betumes[3][7]}>" . $val_betumes[3][4] . "</option>";
                            }
                            ?>
                    <option></option>
                    <?php
                    $cnsTransp = mysql_query("select * from transportadora where cod_transp <> {$val_betumes[3][7]} order by nome asc");
                    while ($valor = mysql_fetch_array($cnsTransp)) {
                        echo "<option value=$valor[0]>$valor[1]</option>";
                    }
                    ?>
                </select>

                <select id="edro" onchange="if (document.diaria.editar.value == '0') {
                this.options[0].selected = true;
            }"
                        style="position: absolute; left: 30px; top: 1176; width: 152; height: 24; line-height: 18px; z-index: 177;"
                        name="edMat4">
                            <?php
                            if ($val_betumes[4][0] != '') {
                                echo"<option value={$val_betumes[4][5]}>" . $val_betumes[4][0] . "</option>";
                            }
                            ?>
                    <option></option>
                    <?php
                    include 'conecta.php';
                    $cnsBetume = mysql_query("select * from betumes where cod_betume<>{$val_betumes[4][5]} order by nome asc ");
                    while ($valor = mysql_fetch_array($cnsBetume)) {
                        echo "<option value=$valor[0]>$valor[1]</option>";
                    }
                    ?>
                </select>


                <input name="edQtdMat4" type="text" id="edro" readonly="true"
                       style="position: absolute; left: 181px; top: 1176; width: 91; height: 24; line-height: 18px; z-index: 178;"
                       onChange="calcMassa();
            teorCAL();" value="<?php echo$val_betumes[4][1]; ?>">


                <input name="edCargas4" type="text" id="edro" readonly="true"
                       style="position: absolute; left: 271px; top: 1176; width: 66; height: 24; line-height: 18px; z-index: 179;"
                       onChange="calcCargas();" value="<?php echo$val_betumes[4][2]; ?>">

                <select id="edro" onchange="if (document.diaria.editar.value == '0') {
                this.options[0].selected = true;
            }"
                        style="position: absolute; left: 336px; top: 1176; width: 189; height: 24; line-height: 18px; z-index: 180;"
                        name="edObra4">
                            <?php
                            if ($val_betumes[4][3] != '') {
                                echo"<option value={$val_betumes[4][6]}>" . $val_betumes[4][3] . "</option>";
                            }
                            ?>
                    <option></option>
                    <?php
                    $cnsObra = mysql_query("select * from obras where cod_obra <> {$val_betumes[4][6]} order by nome asc");
                    while ($valor = mysql_fetch_array($cnsObra)) {
                        echo "<option value=$valor[0]>$valor[1]</option>";
                    }
                    ?>
                </select>

                <select id="edro"
                        style="position: absolute; left: 525px; top: 1176; width: 455; height: 24; line-height: 18px; z-index: 181;"
                        name="edTransportadora4">
                    <option></option>
                    <?php
                    include 'conecta.php';
                    $cnsTransp = mysql_query("select * from transportadora");
                    while ($valor = mysql_fetch_array($cnsTransp)) {
                        echo "<option value=$valor[0]>$valor[1]</option>";
                    }
                    ?>
                </select>
                <select id="edro" onchange="if (document.diaria.editar.value == '0') {
                this.options[0].selected = true;
            }"
                        style="position: absolute; left: 30px; top: 1199; width: 152; height: 24; line-height: 18px; z-index: 182;"
                        name="edMat5">
                            <?php
                            if ($val_betumes[5][0] != '') {
                                echo"<option value={$val_betumes[5][5]}>" . $val_betumes[5][0] . "</option>";
                            }
                            ?>
                    <option></option>
                    <?php
                    include 'conecta.php';
                    $cnsBetume = mysql_query("select * from betumes where cod_betume<>{$val_betumes[5][5]} order by nome asc ");
                    while ($valor = mysql_fetch_array($cnsBetume)) {
                        echo "<option value=$valor[0]>$valor[1]</option>";
                    }
                    ?>
                </select>


                <input name="edQtdMat5" type="text" id="edro" readonly="true"
                       style="position: absolute; left: 181px; top: 1199; width: 91; height: 24; line-height: 18px; z-index: 183;"
                       onChange="calcMassa();
            teorCAL();" value="<?php echo$val_betumes[5][1]; ?>">


                <input type="text" id="edro" readonly="true"
                       style="position: absolute; left: 271px; top: 1199; width: 66; height: 24; line-height: 18px; z-index: 184;"
                       name="edCargas5" value="<?php echo$val_betumes[5][2]; ?>">

                <select id="edro" onchange="if (document.diaria.editar.value == '0') {
                this.options[0].selected = true;
            }"
                        style="position: absolute; left: 336px; top: 1199px; width: 189; height: 24; line-height: 18px; z-index: 185;"
                        name="edObra5">
                            <?php
                            if ($val_betumes[5][3] != '') {
                                echo"<option value={$val_betumes[5][6]}>" . $val_betumes[5][3] . "</option>";
                            }
                            ?>
                    <option></option>
                    <?php
                    $cnsObra = mysql_query("select * from obras where cod_obra <> {$val_betumes[5][6]} order by nome asc");
                    while ($valor = mysql_fetch_array($cnsObra)) {
                        echo "<option value=$valor[0]>$valor[1]</option>";
                    }
                    ?>
                </select>


                <select id="edro" onchange="if (document.diaria.editar.value == '0') {
                this.options[0].selected = true;
            }"
                        style="position: absolute; left: 525px; top: 1199; width: 455; height: 24; line-height: 18px; z-index: 186;"
                        name="edTransportadora5">
                            <?php
                            if ($val_betumes[5][4] != '') {
                                echo"<option value={$val_betumes[5][7]}>" . $val_betumes[5][4] . "</option>";
                            }
                            ?>
                    <option></option>
                    <?php
                    $cnsTransp = mysql_query("select * from transportadora where cod_transp <> {$val_betumes[5][7]} order by nome asc");
                    while ($valor = mysql_fetch_array($cnsTransp)) {
                        echo "<option value=$valor[0]>$valor[1]</option>";
                    }
                    ?>
                </select>

                <select id="edro" onchange="if (document.diaria.editar.value == '0') {
                this.options[0].selected = true;
            }"
                        style="position: absolute; left: 30px; top: 1222; width: 152; height: 24; line-height: 18px; z-index: 187;"
                        name="edMat6">
                            <?php
                            if ($val_betumes[6][0] != '') {
                                echo"<option value={$val_betumes[6][5]}>" . $val_betumes[6][0] . "</option>";
                            }
                            ?>
                    <option></option>
                    <?php
                    $cnsBetume = mysql_query("select * from betumes where cod_betume<>{$val_betumes[6][5]} order by nome asc ");
                    while ($valor = mysql_fetch_array($cnsBetume)) {
                        echo "<option value=$valor[0]>$valor[1]</option>";
                    }
                    ?>
                </select>


                <input name="edQtdMat6" type="text" id="edro" readonly="true"
                       style="position: absolute; left: 181px; top: 1222; width: 91; height: 24; line-height: 18px; z-index: 188;"
                       onChange="calcMassa();
            teorCAL();" value="<?php echo$val_betumes[6][1]; ?>">


                <input name="edCargas6" type="text" id="edro" readonly="true"
                       style="position: absolute; left: 271px; top: 1222; width: 66; height: 24; line-height: 18px; z-index: 189;"
                       onChange="calcCargas();" value="<?php echo$val_betumes[6][2]; ?>">

                <select id="edro" onchange="if (document.diaria.editar.value == '0') {
                this.options[0].selected = true;
            }"
                        style="position: absolute; left: 336px; top: 1222; width: 189; height: 24; line-height: 18px; z-index: 190;"
                        name="edObra6">
                            <?php
                            if ($val_betumes[6][3] != '') {
                                echo"<option value={$val_betumes[6][6]}>" . $val_betumes[6][3] . "</option>";
                            }
                            ?>
                    <option></option>
                    <?php
                    $cnsObra = mysql_query("select * from obras where cod_obra <> {$val_betumes[6][6]} order by nome asc");
                    while ($valor = mysql_fetch_array($cnsObra)) {
                        echo "<option value=$valor[0]>$valor[1]</option>";
                    }
                    ?>
                </select>

                <select id="edro" onchange="if (document.diaria.editar.value == '0') {
                this.options[0].selected = true;
            }"
                        style="position: absolute; left: 525px; top: 1222; width: 455; height: 24; line-height: 18px; z-index: 191;"
                        name="edTransportadora6">
                            <?php
                            if ($val_betumes[6][4] != '') {
                                echo"<option value={$val_betumes[6][7]}>" . $val_betumes[6][4] . "</option>";
                            }
                            ?>
                    <option></option>
                    <?php
                    $cnsTransp = mysql_query("select * from transportadora where cod_transp <> {$val_betumes[6][7]} order by nome asc");
                    while ($valor = mysql_fetch_array($cnsTransp)) {
                        echo "<option value=$valor[0]>$valor[1]</option>";
                    }
                    ?>
                </select>

                <select id="edro" onchange="if (document.diaria.editar.value == '0') {
                this.options[0].selected = true;
            }"
                        style="position: absolute; left: 30px; top: 1245; width: 152; height: 24; line-height: 18px; z-index: 192;"
                        name="edMat7">
                            <?php
                            if ($val_betumes[7][0] != '') {
                                echo"<option value=$val_betumes[7][5]>" . $val_betumes[7][0] . "</option>";
                            }
                            ?>
                    <option></option>
                    <?php
                    $cnsBetume = mysql_query("select * from betumes where cod_betume<>{$val_betumes[7][5]} order by nome asc ");
                    while ($valor = mysql_fetch_array($cnsBetume)) {
                        echo "<option value=$valor[0]>$valor[1]</option>";
                    }
                    ?>
                </select>


                <input name="edQtdMat7" type="text" id="edro" readonly="true"
                       style="position: absolute; left: 181px; top: 1245; width: 91; height: 24; line-height: 18px; z-index: 193;"
                       onChange="calcMassa();
            teorCAL();" value="<?php echo$val_betumes[7][1]; ?>">


                <input name="edCargas7" type="text" id="edro" readonly="true"
                       style="position: absolute; left: 271px; top: 1245; width: 66; height: 24; line-height: 18px; z-index: 194;"
                       onChange="calcCargas();" value="<?php echo$val_betumes[7][2]; ?>">

                <select id="edro" onchange="if (document.diaria.editar.value == '0') {
                this.options[0].selected = true;
            }"
                        style="position: absolute; left: 336px; top: 1245; width: 189; height: 24; line-height: 18px; z-index: 195;"
                        name="edObra7">
                            <?php
                            if ($val_betumes[7][3] != '') {
                                echo"<option value={$val_betumes[7][6]}>" . $val_betumes[7][3] . "</option>";
                            }
                            ?>
                    <option></option>
                    <?php
                    $cnsObra = mysql_query("select * from obras where cod_obra <> {$val_betumes[7][6]} order by nome asc");
                    while ($valor = mysql_fetch_array($cnsObra)) {
                        echo "<option value=$valor[0]>$valor[1]</option>";
                    }
                    ?>
                </select>

                <select id="edro" onchange="if (document.diaria.editar.value == '0') {
                this.options[0].selected = true;
            }"
                        style="position: absolute; left: 525px; top: 1245; width: 455; height: 24; line-height: 18px; z-index: 196;"
                        name="edTransportadora7">
                            <?php
                            if ($val_betumes[7][4] != '') {
                                echo"<option value={$val_betumes[7][7]}>" . $val_betumes[7][4] . "</option>";
                            }
                            ?>
                    <option></option>
                    <?php
                    $cnsTransp = mysql_query("select * from transportadora where cod_transp <> {$val_betumes[7][7]} order by nome asc");
                    while ($valor = mysql_fetch_array($cnsTransp)) {
                        echo "<option value=$valor[0]>$valor[1]</option>";
                    }
                    ?>
                </select>

                <select id="edro" onchange="if (document.diaria.editar.value == '0') {
                this.options[0].selected = true;
            }"
                        style="position: absolute; left: 30px; top: 1268px; width: 152; height: 24; line-height: 18px; z-index: 197;"
                        name="edMat8">
                            <?php
                            if ($val_betumes[8][0] != '') {
                                echo"<option value={$val_betumes[8][5]}>" . $val_betumes[8][0] . "</option>";
                            }
                            ?>
                    <option></option>
                    <?php
                    $cnsBetume = mysql_query("select * from betumes where cod_betume<>{$val_betumes[8][5]} order by nome asc ");
                    while ($valor = mysql_fetch_array($cnsBetume)) {
                        echo "<option value=$valor[0]>$valor[1]</option>";
                    }
                    ?>
                </select>


                <input name="edQtdMat8" type="text" id="edro" readonly="true"
                       style="position: absolute; left: 181px;  top: 1268px; width: 91; height: 24; line-height: 18px; z-index: 198;"
                       onChange="calcMassa();
            teorCAL();" value="<?php echo$val_betumes[8][1]; ?>">


                <input name="edCargas8" type="text" id="edro" readonly="true"
                       style="position: absolute; left: 271px; top: 1268px; width: 66; height: 24; line-height: 18px; z-index: 199;"
                       onChange="calcCargas();" value="<?php echo$val_betumes[8][2]; ?>">

                <select id="edro" onchange="if (document.diaria.editar.value == '0') {
                this.options[0].selected = true;
            }"
                        style="position: absolute; left: 336px; top: 1268px; width: 189; height: 24; line-height: 18px; z-index: 200;"
                        name="edObra8">
                            <?php
                            if ($val_betumes[8][3] != '') {
                                echo"<option value=$val_betumes[8][6]>" . $val_betumes[8][3] . "</option>";
                            }
                            ?>
                    <option></option>
                    <?php
                    $cnsObra = mysql_query("select * from obras where cod_obra <> {$val_betumes[8][6]} order by nome asc");
                    while ($valor = mysql_fetch_array($cnsObra)) {
                        echo "<option value=$valor[0]>$valor[1]</option>";
                    }
                    ?>
                </select>

                <select id="edro" onchange="if (document.diaria.editar.value == '0') {
                this.options[0].selected = true;
            }"
                        style="position: absolute; left: 525px; top: 1268px; width: 455; height: 24; line-height: 18px; z-index: 201;"
                        name="edTransportadora8">
                            <?php
                            if ($val_betumes[8][4] != '') {
                                echo"<option value=$val_betumes[8][7]>" . $val_betumes[8][4] . "</option>";
                            }
                            ?>
                    <option></option>
                    <?php
                    $cnsTransp = mysql_query("select * from transportadora where cod_transp <> {$val_betumes[8][7]} order by nome asc");
                    while ($valor = mysql_fetch_array($cnsTransp)) {
                        echo "<option value=$valor[0]>$valor[1]</option>";
                    }
                    ?>
                </select>


                <input name="edTotalCargas" type="text" id="edReadOnly" style="position: absolute; left: 271px; top: 1294px; width: 66; height: 24; line-height: 18px; z-index: 203;" value="<?php echo$total_cargas; ?>" readonly="true">


                <input name="edTotalMassa" type="text" id="edReadOnly" style="position: absolute; left: 181px; top: 1294px; width: 91; height: 24; line-height: 18px; z-index: 204;" value="<?php echo$total_massa; ?>" readonly="true">


                <table width="542" cellpadding="0" cellspacing="0" style="position: absolute; left: 213px; top: 71px; width: 430; height: 135px; z-index: 2;" name="Table64" id="tabelaLabel">

                    <tbody>
                        <tr> 
                            <td height="24" colspan="3"
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 18px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;"><?php echo$endereco; ?> 
                                    </span> </div></td>
                        </tr>
                        <tr> 


                            <td width="228" height="24"
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 18px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;"><?php echo"$rodovia_trecho"; ?> 
                                    </span> </div></td>
                            <td width="94"
                                style="background-color: #CCCCFF; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; width: 89px; height: 18px;"> 
                                <span
                                    style="font-family: Arial; font-size: 13px; color: #000000;">Data:</span> 
                                <div></div></td>

                            <td width="107" style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 18px;" font-family: Arial; font-size: 13px;> 
                                <input name="edHiddenUsina" type="hidden" id="edHiddenUsina" value="<?php echo$unidadeusina; ?>">
                                <?php echo$_SESSION['dt_pesq_D']; ?>          </td>
                        </tr>
                        <tr> 


                            <td height="24" colspan="3"
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 18px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;"><?php echo"$endereco"; ?> 
                                    </span> </div></td>
                        </tr>
                        <tr> 

                            <td height="23" colspan="3"
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 18px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;"><?php echo "$eng_responsavel2"; ?> 
                                    </span> </div></td>
                        </tr>
                        <tr> 
                            <td colspan="3"
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 18px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;"><?php echo "$eng_operacao2"; ?> 
                                    </span> </div></td>
                        </tr>
                        <tr> 
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; width: 155px; height: 18px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;"><?php echo "$encarregado2"; ?> 
                                    </span> </div></td>
                            <td
                                style="background-color: #CCCCFF; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; width: 89px; height: 18px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;">Operador:</span> 
                                </div></td>
                            <td
                                style="background-color: transparent; border: 1px #C0C0C0 solid; text-align: left; vertical-align: top; height: 18px;"> 
                                <div> <span
                                        style="color: #000000; font-family: Arial; font-size: 13px;"><?php echo "$operador2"; ?> 
                                    </span> </div></td>
                        </tr>
                    <tbody>
                </table>

                <input
                    type="text" id="edNaoEditavel"
                    style="position: absolute; left: 339px; top: 729; width: 72; height: 22; line-height: 18px; z-index: 106;"
                    name="Editbox7" readonly="true">
                <input type="hidden" name="vcal" value="0">
                <input type="hidden" name="cadP" value="0">
                <input type="hidden" name="editar" value="0">
                <input type="hidden" name="edData" value=<?php echo$data; ?>>

                <!-- Campos invisíveis que contem o código da parada usado para alterar diária-->
                <input type="hidden" name="p[]" value="<?php echo$val_paradas[1][3]; ?>" style="z-index:150;">
                <input type="hidden" name="p[]" value="<?php echo$val_paradas[2][3]; ?>" style="z-index:151;">
                <input type="hidden" name="p[]" value="<?php echo$val_paradas[3][3]; ?>" style="z-index:152;">
                <input type="hidden" name="p[]" value="<?php echo$val_paradas[4][3]; ?>" style="z-index:153;">

                <!--campos invisíveis que contem o código do registro de saida de material -->
                <input type="hidden" name="sm[]" value="<?php echo$val_betumes[1][8]; ?>" style="z-index:153;">
                <input type="hidden" name="sm[]" value="<?php echo$val_betumes[2][8]; ?>" style="z-index:153;">
                <input type="hidden" name="sm[]" value="<?php echo$val_betumes[3][8]; ?>" style="z-index:153;">
                <input type="hidden" name="sm[]" value="<?php echo$val_betumes[4][8]; ?>" style="z-index:153;">
                <input type="hidden" name="sm[]" value="<?php echo$val_betumes[5][8]; ?>" style="z-index:153;">
                <input type="hidden" name="sm[]" value="<?php echo$val_betumes[6][8]; ?>" style="z-index:153;">
                <input type="hidden" name="sm[]" value="<?php echo$val_betumes[7][8]; ?>" style="z-index:153;">
                <input type="hidden" name="sm[]" value="<?php echo$val_betumes[8][8]; ?>" style="z-index:153;">

                <!-- campos invisíveis que contem o código das entradas de materiais usadas na alteraçao-->
                <input type="hidden" name="cod_entrada_cap" value="<?php echo$cod_entrada_cap; ?>" style="z-index:153;">
                <input type="hidden" name="cod_entrada_x" value="<?php echo$cod_entrada_x; ?>" style="z-index:153;">
                <input type="hidden" name="cod_entrada_cal" value="<?php echo$cod_entrada_cal; ?>" style="z-index:153;">
                <input type="hidden" name="cod_entrada_d" value="<?php echo$cod_entrada_d; ?>" style="z-index:153;">

            </form>


            <img src="images/LOGO%20E-MAIL.png" alt="" width="180" height="59" border="1" style="position: absolute; left: 30px; top: 10px; width: 182; height: 60;"> 
            <span
                style="color: #000000; font-family: Arial; font-size: 13px;"><img src="images/u3.jpg" alt="" width="322" height="157" border="0" id="Image2" style="position:absolute; width: 335; height: 157px; left: 644px; top: 150px; border:1"></span> 
            <span
                style="color: #000000; font-family: Arial; font-size: 13px;"> 
                <input name="edEstqAntCal" type="text"
                       id="edReadOnly"
                       style="position: absolute; left: 179; top: 750; width: 76; height: 22; line-height: 18px; z-index: 123;"
                       value="<?php echo$estq_ant_cal; ?>" readonly="true">
                <img src="images/wwb_img2.jpg" alt="" width="336" height="73" border="0" id="Image3" style=" position:absolute; width: 335; height: 80px;  top:72px; left:644px;"> 
            </span> </div>

    </body>


    
<script type="text/javascript">
        jQuery(function($) {
        $("#campoData").mask("99/99/9999");
        $("#campoTelefone").mask("(99) 999-9999");
        $("#campoSenha").mask("***-****");
        });
    </script>
</html>
