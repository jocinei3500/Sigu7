<?php
//conexão com o servidor online
//$conexao=mysql_connect("mysql6.000webhost.com","a6479392_jocinei","230891@rosa");
$conexao=mysql_connect("localhost","root","root");
mysqli_select_db("sgu",$conexao) or die("Não foi possivel se conectar ao banco ");

 ?>


