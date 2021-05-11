<?php

// Inserir vendedores
function insertSeller($file) {

	$seller_info['id'] = $file[0];
	$seller_info['cpf'] = $file[1];
	$seller_info['nome'] = $file[2];
	$seller_info['salario'] = $file[3];
	return($seller_info);
}

// Inserir Clientes
function insertClient($file) {

	$client_info['id'] = $file[0];
	$client_info['cnpj'] = $file[1];
	$client_info['nome'] = $file[2];
	$client_info['ramo_de_atividade'] = $file[3];

	return$client_info;
}
// Inserir vendas
function insertSales($file, &$expensive_sale, &$id_expensive_sale, &$value_sale, &$name_value_sale) {



	$sales_info['id'] = $file[0];
	$sales_info['id_vendedor'] = $file[1];
	$sales_info['nome_vendedor'] = $file[3];

	//tratando String de vendas
	$formater = str_replace('[','',$file[2]);
	$formater = str_replace(']','',$formater);
	$formater = str_replace(' ','',$formater);
	$formater = explode(',', $formater);

	$count = 1;
	$sales_info['valor_total_venda'] = 0;

	//Loop para inserir vendas depois de tratada
	foreach($formater as $f) {

		$formater2 = explode('-', strval($f));
		$sales_info['venda']['lista'][] = array(
			"id" => $sales_info['id_vendedor']." - ".$count,
			"id_item" => $formater2[0],
			"quantidade" => $formater2[1],
			"preco" => $formater2[2],
			"valor_venda" => ($formater2[1] * $formater2[2]),
			
		);
		
		$count++ ;

		// Definindo Valor total das vendas
		$sales_info['valor_total_venda'] = ($formater2[1] * $formater2[2]) + $sales_info['valor_total_venda'];

		if($sales_info['valor_total_venda'] < $value_sale) {
			$value_sale = $sales_info['valor_total_venda'];
			$name_value_sale = $sales_info['nome_vendedor'];
		}

	}

	// Definindo venda mais cara
	foreach($sales_info['venda']['lista'] as $lista) {
		
		if($lista['valor_venda'] > $expensive_sale) {
			$expensive_sale = $lista['valor_venda'];
			$id_expensive_sale = $lista['id'];
		}
	}
	
	return $sales_info;
}
