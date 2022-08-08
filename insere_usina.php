<?php

include 'conecta.php';
$codUsina = $_POST['edCodUsina'];
$endereco = $_POST['edEndereco'];
$cidade = $_POST['edCidade'];
$ObraContrato = $_POST['edObraContrato'];
$RodoviaTrecho = $_POST['edRodoviaTrecho'];
$engResponsavel = $_POST['edEngResp'];
$engOperacao = $_POST['edEngOp'];
$encarregado = $_POST['edEncarregado'];
$operador = $_POST['edOp'];
$dataCadastro = $_POST['edDataCadastro'];
$capacidadeCap = $_POST['edCPCAP'];
$capacidadeXisto = $_POST['edCPXisto'];
$capacidadeDieC = $_POST['edCPCald'];
$capacidadeDieG = $_POST['edCPGerador'];
$capacidadeD = $_POST['edCPRes'];



$consulta = mysql_query("insert into usinas values(
                        $codUsina,
                        '$endereco',
                        '$cidade',
                        '$ObraContrato',
                        '$RodoviaTrecho',
                        $engResponsavel,
                        $engOperacao,
                        $encarregado,
                        $operador,
                        '$dataCadastro',
                         $capacidadeCap,
                         $capacidadeXisto,
                        $capacidadeDieC,
                        $capacidadeDieG,
                        $capacidadeD
 )");
if ($consulta) {

    // echo("<script>history.back();</script>");volta à página anterior
    header('location:cadastro_usinas.php');
}
?>