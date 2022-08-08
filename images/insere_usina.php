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
if ($consulta==true) {

   echo'
<div id="Layer1" style="position:absolute; left:130px; top:40px; width:590px; height:372px; z-index:1; background-color: #DDDDFF; layer-background-color: #DDDDFF; border: 1px none #000000;"></div>
<div id="Layer2" style="position:absolute; left:140px; top:50px; width:570px; height:30px; z-index:2">Cadastro 
  Realizado com sucesso!</div>
<div id="Layer2" style="position:absolute; left:140px; top:90px; width:570px; height:310px; z-index:2"> 
</div>
<div id="Layer2" style="position:absolute; left:160px; top:100px; width:30px; height:18px; z-index:2"> 
  <input type="button" name="btVoltar" value="          Página Inicial         " >  ';
   
   
   echo'
</div>
</form>
';
}
?>