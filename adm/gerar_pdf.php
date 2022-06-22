<?php
	//baixar a class mPDF no site http://www.mpdf1.com/mpdf/index.php
	//Descompactar o arquivo na pasta pdf
	include ('pdf/mpdf.php');
	
	$servidor = "localhost";
	$usuario = "root";
	$senha = "33261577";
	$dbname = "fidelize_master";
	
	//Criar a conexão
	$conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
	if(!$conn){
		die("Falha na conexao: " . mysqli_connect_error());
	}else{
		//echo "Conexao realizada com sucesso";
	}
	
	$result_usuario = "SELECT * FROM clientes";
	$resultado_usuario = mysqli_query($conn, $result_usuario);	
	$row_usuario = mysqli_fetch_assoc($resultado_usuario);	
	
	
	$pagina = 
		"<html>
			<body>
				<h1>Informações do Usuário</h1>
				Nome: ".$row_usuario['nome']."<br>
				E-mail: ".$row_usuario['email']."<br>
				Senha: ".$row_usuario['senha']."<br>
				<h4>http://www.celke.com.br</h4>
			</body>
		</html>
		";


$mpdf = new mPDF();
$mpdf->WriteHTML($pagina);


// I - Abre no navegador
// F - Salva o arquivo no servido
// D - Salva o arquivo no computador do usuário
?>
