<?php

namespace CDC\Exemplos;

use CDC\Exemplos\RelogioInterface;

class RelogioDoSistema implements RelogioInterface{
	
	public function hoje(){
		return \DateTime::createFromFormat('Y-m-d', date('Y-m_d'));
	}

}

?>