<?php 

namespace CDC\Loja\FluxoDeCaixa;

use CDC\Exemplos\RelogioDoSistema;
use CDC\Loja\Test\TestCase;
use \Mockery;


class GeradorDeNotaFiscalTest extends TestCase{
	

	public function testDevePersistirNFGerada(){
		$dao = Mockery::mock("CDC\Loja\FluxoDeCaixa\NFDao");
		$dao->shouldReceive("executa")->andReturn(true);
		
		$tabela	= Mockery::mock("CDC\Loja\Tributos\TabelaInterface");
		$tabela->shouldReceive("paraValor")->with(1000.0)->andReturn(0.2);

		$gerador = new GeradorDeNotaFiscal([$dao], new RelogioDoSistema(), $tabela);
		$pedido = new Pedido("Andre", 1000, 1);

		$nf = $gerador->gera($pedido);

		$this->assertTrue($dao->executa($nf));
		$this->assertEquals(1000 * 0.8, $nf->getValor(), null, 0.00001);

	}

	public function testDeveEnviarNFGeradaParaSAP(){
		$sap = Mockery::mock("CDC\Loja\FluxoDeCaixa\SAP");
		$sap->shouldReceive("executa")->andReturn(true);

		$tabela	= Mockery::mock("CDC\Loja\Tributos\TabelaInterface");
		$tabela->shouldReceive("paraValor")->with(1000.0)->andReturn(0.2);

		$gerador = new GeradorDeNotaFiscal([$sap], new RelogioDoSistema(), $tabela);
		$pedido	= new Pedido("Andre", 1000, 1);
		$nf	= $gerador->gera($pedido);
		
		$this->assertTrue($sap->executa($nf));
		$this->assertEquals(1000 * 0.8, $nf->getValor(), null, 0.00001);

	}
 
	public function testDeveInvocarAcoesPosteriores(){
		$acao1 =  Mockery::mock("CDC\Loja\FluxoDeCaixa\AcaoAposGerarNotaInterface");
		$acao1->shouldReceive("executa")->andReturn(true);

		$acao2 =  Mockery::mock("CDC\Loja\FluxoDeCaixa\AcaoAposGerarNotaInterface");
		$acao2->shouldReceive("executa")->andReturn(true);

		$tabela	= Mockery::mock("CDC\Loja\Tributos\TabelaInterface");
		$tabela->shouldReceive("paraValor")->with(1000.0)->andReturn(0.2);

		$gerador = new GeradorDeNotaFiscal([$acao1, $acao2], new RelogioDoSistema(), $tabela);
		$pedido = new Pedido('André', 1000, 1);

		$nf = $gerador->gera($pedido);

		$this->assertTrue($acao1->executa($nf));
		$this->assertTrue($acao2->executa($nf));
		$this->assertNotNull($nf);

		$this->assertInstanceOf("CDC\Loja\FluxoDeCaixa\NotaFiscal", $nf);
	}

	public function testDeveConsultarATabelaParaCalcularValor(){
		//	mockando	uma	tabela,	que	ainda	nem	existe
		$tabela	=	Mockery::mock("CDC\Loja\Tributos\TabelaInterface");
		
		//	definindo	o	futuro	comportamento	"paraValor",
		//	que	deve	retornar	0.2	caso	valor	seja	1000.0
		$tabela->shouldReceive("paraValor")->with(1000.0)->andReturn(0.2);

		$gerador = new GeradorDeNotaFiscal(array(), new RelogioDoSistema(), $tabela);
		$pedido	= new Pedido("Andre", 1000.0, 1);
		$nf	= $gerador->gera($pedido);

		//garantindo	que	a	tabela	foi	consultada
		$this->assertEquals(1000 * 0.8,	 $nf->getValor(), null, 0.00001);


	}


}


?>