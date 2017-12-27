<?php 

namespace CDC\Loja\FluxoDeCaixa;

use CDC\Loja\Test\TestCase;


class GeradorDeNotaFiscalTest extends TestCase{
	
	public function testDeveGerarNFComValorDeImpostoDescontado(){
		$gerador = new GeradorDeNotaFiscal();
	
		$pedido = new Pedido("André", 1000, 1);

		$nf = $gerador->gera($pedido);


		$this->assertEquals(1000 * 0.94, $nf->getValor(), null, 0.000001);
	}

	
}


?>