<?php
$conexao=mysql_connect("dbmy0029.whservidor.com","sigu7","innova200");
mysql_select_db("sigu7",$conexao);
$cod=$_GET['cod'];
$con=  mysql_query("select foto from usuario where cod_user=$cod");
$val=  mysql_fetch_array($con);
$foto=$val[0];
header('content-type:image/jpg');
echo $foto;
?>