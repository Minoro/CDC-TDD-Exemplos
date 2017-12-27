<?php 

namespace CDC\Loja\FluxoDeCaixa;

use \Mockery;
use CDC\Loja\Test\TestCase;


class GeradorDeNotaFiscalTest extends TestCase{
	

	public function testDevePersistirNFGerada(){
		$dao = Mockery::mock("CDC\Loja\FluxoDeCaixa\NFDao");
		$dao->shouldReceive("executa")->andReturn(true);
		
		$gerador = new GeradorDeNotaFiscal([$dao]);
		$pedido = new Pedido("Andre", 1000, 1);

		$nf = $gerador->gera($pedido);

		$this->assertTrue($dao->executa($nf));
		$this->assertEquals(1000 * 0.94, $nf->getValor(), null, 0.00001);

	}

	public function testDeveEnviarNFGeradaParaSAP(){
		$sap = Mockery::mock("CDC\Loja\FluxoDeCaixa\SAP");
		$sap->shouldReceive("executa")->andReturn(true);

		$gerador = new GeradorDeNotaFiscal([$sap]);
		$pedido	= new Pedido("Andre", 1000, 1);
		$nf	= $gerador->gera($pedido);
		
		$this->assertTrue($sap->executa($nf));
		$this->assertEquals(1000 * 0.94, $nf->getValor(), null, 0.00001);

	}
 
	public function testDeveInvocarAcoesPosteriores(){
		$acao1 =  Mockery::mock("CDC\Loja\FluxoDeCaixa\AcaoAposGerarNotaInterface");
		$acao1->shouldReceive("executa")->andReturn(true);

		$acao2 =  Mockery::mock("CDC\Loja\FluxoDeCaixa\AcaoAposGerarNotaInterface");
		$acao2->shouldReceive("executa")->andReturn(true);

		$gerador = new GeradorDeNotaFiscal([$acao1, $acao2]);
		$pedido = new Pedido('André', 1000, 1);

		$nf = $gerador->gera($pedido);

		$this->assertTrue($acao1->executa($nf));
		$this->assertTrue($acao2->executa($nf));
		$this->assertNotNull($nf);

		$this->assertInstanceOf("CDC\Loja\FluxoDeCaixa\NotaFiscal", $nf);
	}


}


?>