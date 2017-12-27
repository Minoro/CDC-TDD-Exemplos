<?php

namespace CDC\Loja\RH;

use	CDC\Loja\RH\CalculadoraDeSalario;
use	CDC\Loja\RH\Funcionario;
use	CDC\Loja\RH\TabelaCargos;
use CDC\Loja\Test\TestCase;

class CalculadoraDeSalarioTest extends TestCase{
	
	public function testCalculoSalarioDesenvolvedoresComSalarioAbaixoDoLimite(){
		$calculadora = new CalculadoraDeSalario();

		$desenvolvedor = new Funcionario("Andre", 1500.0, 'desenvolvedor');

		$salario = $calculadora->calculaSalario($desenvolvedor);

		$this->assertEquals(1500.0 * 0.9, $salario, null, 0.000001);
	}

	public function testCalculoSalarioDesenvolvedoresComSalarioAcimaDoLimite(){
		$calculadora = new CalculadoraDeSalario();

		$desenvolvedor = new Funcionario("Andre", 4000.0, 'desenvolvedor');

		$salario = $calculadora->calculaSalario($desenvolvedor);

		$this->assertEquals(4000.0 * 0.8, $salario, null, 0.000001);
	}

	public function testDeveCalcularSalarioParaDBAsComSalarioAbaixoDoLimite()
    {
        $calculadora = new CalculadoraDeSalario();
     
        $dba = new Funcionario("Mauricio", 1500.0, 'dba');
        $salario = $calculadora->calculaSalario($dba);
        $this->assertEquals(1500.0 * 0.85, $salario, null, 0.00001);
    }

    public function testDeveCalcularSalarioParaDBAsComSalarioAcimaDoLimite(){

    	$calculadora = new CalculadoraDeSalario();

    	$dba = new Funcionario("Mauricio", 4500.0, 'dba');
    	$salario = $calculadora->calculaSalario($dba);

    	$this->assertEquals(4500.0 * 0.75, $salario, null, 0.00001);	
    }

}

?>