<?php

namespace CDC\Loja\FluxoDeCaixa;

use CDC\Loja\FluxoDeCaixa\AcaoAposGerarNotaInterface;
use CDC\Loja\FluxoDeCaixa\NotaFiscal;

class NFDao implements AcaoAposGerarNotaInterface{
	
	public function executa(NotaFiscal $nf){
		return true;
	}
}

?>