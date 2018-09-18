<?php

class Forca
{
	private $palavras = [
		"ABELHA",
		"BARATA",
		"ENCANADOR",
		"TAMPA",
		"PTERODACTILO",
		"OTORRINOLARINOLOGISTA",
	];
	private $palpites = [];
	private $chances  = 5;
	private $acertos  = 0;

	public function __construct()
	{
		$indice = array_rand($this->palavras);
		$this->palavraSecreta = $this->palavras[$indice];
		$this->palavraEmArray = str_split($this->palavraSecreta);
		$this->quantidadeDeLetrasIguais = array_count_values($this->palavraEmArray);
		echo "Jogo iniciado! <br>";
		// echo "Palavra secreta: {$this->palavraSecreta}<br>";
	}

	/**
	 * Recebe uma letra, e faz a jogada
	 *
	 * @param string $letra
	 * @return void
	 */
	public function fazPalpite($letra)
	{
		echo "--------------------------------------------------------<br>";
		echo "Palpite dado: '{$letra}'<br>";

		if (!$this->verificaChancesRestantes()) {
			echo "Voce perdeu! Fim de jogo!<br><br>";
			die();
		}

		if ($this->verificaLetraJaCitada($letra)) {
			echo "Este palpite ja foi dado. Tente outra letra.<br>";
			return;
		}

		array_push($this->palpites, $letra);

		if (in_array($letra, $this->palavraEmArray)) {
			$this->acertos += $this->quantidadeDeLetrasIguais[$letra];
		} else {
			$this->chances -= 1;
		}

		$this->printPalavra();

		if ($this->verificaJogoGanho()) {
			echo "Jogo terminado! Voce venceu!<br><br>";
			die();
		}
	}

	/**
	 * Verifica se a letra citada ja nao foi citada anteriormente
	 *
	 * @param string $letra
	 * @return void
	 */
	private function verificaLetraJaCitada($letra)
	{
		return in_array($letra, $this->palpites);
	}

	/**
	 * Printa o jogo, usando '_' no lugar de letras que n�o foram citadas ainda.
	 *
	 * @return void
	 */
	private function printPalavra()
	{
		foreach ($this->palavraEmArray as $letra) {
			if (in_array($letra, $this->palpites)) {
				echo " {$letra}  ";
			} else {
				echo " _ ";
			}
		}
		echo "<br>";
		$this->printChances();
		$this->printPalpites();
	}

	/**
	 * Printa a quantidade de chances restantes
	 *
	 * @return void
	 */
	private function printChances()
	{
		echo "Chances restantes: {$this->chances}<br>";
	}

	/**
	 * Printa as letras que j� foram palpitadas
	 *
	 * @return void
	 */
	private function printPalpites()
	{
		echo "Palpites dados: ";
		echo implode(", ", $this->palpites);
		echo "<br>";
	}

	/**
	 * Verifica se ainda ha chances restantes para jogar
	 *
	 * @return boolean
	 */
	private function verificaChancesRestantes()
	{
		return $this->chances > 0;
	}

	/**
	 * Verifica se a palavra ja nao foi descoberta
	 *
	 * @return boolean
	 */
	private function verificaJogoGanho()
	{
		return $this->acertos == count($this->palavraEmArray);
	}
}

$teste = new Forca();

$teste->fazPalpite("A");
echo "<br><br>";