<!-- Atualizando o sistema a cada 1s -->
<script>
	setTimeout(function() {
  		window.location.reload(1);
	}, 1000);			
</script>

<?php
	include('functions.php');

	echo "Sistema Operando...";

	// Criar pasta de entrada
	if(!is_dir("data/in")) {
		mkdir(__DIR__.'/data/in/', 0777, true);
	}

	// Criar pasta de saida
	if(!is_dir("data/out")) {
		mkdir(__DIR__.'/data/out/', 0777, true);
	}

	$expensive_sale = 0;
	$id_expensive_sale = 0;
	$value_sale = null;
	$name_value_sale = '';
	// Definindo diretorio 
	$dh = dir ("data/in/");

	// Loop para verificar arquivos
	while ($input = $dh->read()) {

		//Filtrar pelo formato 
		$ext = pathinfo($input, PATHINFO_EXTENSION);

		if($ext == "dat") {
			$files = $input;
			$read_file = file("data/in/".$files);
			
			// Loop para inserção da informação
			foreach($read_file as $file) {
				$explode_file = explode('ç', $file);

				switch($explode_file[0]) {
					case 001:
						$result_seller[] = insertSeller($explode_file);
						break;
					case 002:
						$result_client[] = insertClient($explode_file);
						break;	
					case 003:
						$result_sales[] = insertSales($explode_file, $expensive_sale, $id_expensive_sale, $value_sale, $name_value_sale);
						break;
				}
			}	

		}


	}

	// Contagem dos clientes e vendedores
	$count_seller = count($result_seller);
	$count_client = count($result_client);


	// Estruturando e criando arquivo de retorno
	$arquivo = fopen('data/out/retorno.done.dat','w');
	fwrite($arquivo, "Quantidade de clientes: ".$count_client."\r\r");
	fwrite($arquivo, "Quantidade de Vendedor: ".$count_seller."\r\r");
	fwrite($arquivo, "Id da venda mais cara: ".$id_expensive_sale."\r\r");
	fwrite($arquivo, "Pior vendedor de todos os tempos: ".$name_value_sale."\r\r");


?>