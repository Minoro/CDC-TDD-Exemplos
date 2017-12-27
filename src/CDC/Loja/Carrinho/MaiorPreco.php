<?php

namespace CDC\Loja\Carrinho;

use CDC\Loja\Carrinho\CarrinhoDeCompras;

class MaiorPreco{
	
	public function encontra(CarrinhoDeCompras $carrinho){
		if(count($carrinho->getItens()) === 0){
			return 0;
		}

		$maiorValor = $carrinho->getProdutos()[0]->getValorUnitario();
		foreach ($carrinho->getProdutos() as $produto) {
			if($maiorValor < $produto->getValorUnitario()){
				$maiorValor = $produto->getValorUnitario();
			}
		}

		return $maiorValor;
	}

}

?>