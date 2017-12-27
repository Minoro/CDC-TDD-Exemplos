<?php 

namespace CDC\Loja\FluxoDeCaixa;

use \Mockery;
use CDC\Loja\Test\TestCase;


class GeradorDeNotaFiscalTest extends TestCase{
	

	public function testDevePersistirNFGerada(){
		$dao = Mockery::mock("CDC\Loja\FluxoDeCaixa\NFDao");
		$dao->shouldReceive("persiste")->andReturn(true);

		$sap = Mockery::mock("CDC\Loja\FluxoDeCaixa\SAP");
		$sap->shouldReceive("envia")->andReturn(true);
		
		$gerador = new GeradorDeNotaFiscal($dao, $sap);
		$pedido = new Pedido("Andre", 1000, 1);

		$nf = $gerador->gera($pedido);


		$this->assertTrue($dao->persiste($nf));
		$this->assertEquals(1000 * 0.94, $nf->getValor(), null, 0.00001);

	}

	public function testDeveEnviarNFGeradaParaSAP(){
		$dao = Mockery::mock('CDC\Loja\FluxoDeCaixa\NFDao');
		$dao->shouldReceive('persiste')->andReturn(true);

		$sap = Mockery::mock("CDC\Loja\FluxoDeCaixa\SAP");
		$sap->shouldReceive("envia")->andReturn(true);
		$gerador = new GeradorDeNotaFiscal($dao, $sap);
		$pedido	= new Pedido("Andre", 1000, 1);
		$nf	= $gerador->gera($pedido);
		$this->assertTrue($sap->envia($nf));
		$this->assertEquals(1000 * 0.94, $nf->getValor(), null, 0.00001);

	}
 

}


?>