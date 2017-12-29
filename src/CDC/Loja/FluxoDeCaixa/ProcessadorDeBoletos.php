<?php 

namespace CDC\Loja\FluxoDeCaixa;

use CDC\Loja\FluxoDeCaixa\Fatura;
use CDC\Loja\FluxoDeCaixa\MeioPagamento;

class ProcessadorDeBoletos{
	
	public function processa(\ArrayObject $boletos, Fatura $fatura){
		
		$pagamentosFatura = $fatura->getPagamentos();
		foreach ($boletos as $boleto) {
			$pagamento = new Pagamento($boleto->getValor(), MeioPagamento::BOLETO);
			$fatura->adicionaPagamento($pagamento);
		}

	}

}


?>