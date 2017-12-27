<?php

namespace CDC\Loja\FluxoDeCaixa;

use CDC\Loja\FluxoDeCaixa\NotaFiscal;
use CDC\Loja\FluxoDeCaixa\Pedido;

class GeradorDeNotaFiscal{
	
	public function gera(Pedido $pedido){
		return new NotaFiscal($pedido->getCliente(), $pedido->getValorTotal() * 0.94, new \DateTime());
	}
}

?>