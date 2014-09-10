<?php

require_once('header.php');

class Pokemon {
	
	public $nom;

	public $type;

	public $pv;

	public $pvmax;

	public $defense;

	public $force;

	public $initiative;

	public $precision;

	public function __construct($nom, $type, $pv, $defense, $force, $initiative, $precision) {
		$this->nom = $nom;
		$this->type = $type;
		$this->pv = $this->pvmax = $pv;
		$this->defense = $defense;
		$this->force = $force;
		$this->initiative = $initiative;
		$this->precision = $precision;
	}

	public function attaque($cible) {
			//this veut attaquer cible. On determine qui touche en premier grace à l'initative. 
		if($cible->pv > 0 && $this->pv > 0) {
			if ($this->initiative > $cible->initiative) {
				$cible->pv = $cible->pv-$this->force;
				$this->force = $this->force+1;

				if($cible->pv > 0){
					$this->pv = $this->pv-$cible->force;
					$this->initiative = $this->initiative-1;
				} else {
					echo '<p>Fin de l\'attaque, '.$cible->nom.' est mort</p>';
				}

			} else {
				$this->pv = $this->pv-$cible->force;
				$cible->force = $cible->force+1;

				if($this->pv > 0){
					$cible->pv = $cible->pv-$this->force;
					$cible->initiative = $cible->initiative-1;
				} else {
					echo '<p>Fin de l\'attaque, '.$this->nom.' est mort</p>';
				}
			}

			echo '<h1>Tour de combat</h1><p>'.$this->nom.' attaque '.$cible->nom.'<br>'.$cible->nom.' se defend contre '.$this->nom.' avec '.$cible->defense.'</p><br>'.$this->nom.' a maintenant '.$this->pv.'/'.$this->pvmax.' points de vie et '.$cible->nom.' a maintenant '.$cible->pv.'/'.$cible->pvmax.' points de vie';

		} echo '<p>Fin de l\'attaque</p>';
	}
}

//Pour créer un objet, on instancie et on donne les paramètres 
$pika = new Pokemon('Pika', //nom
					'Pokemon', //type
					'100', //pv
					'100', //pv max
					'une attaque éclair', //defense
					'2', //force
					'80', //initiative
					'100'); //precision

$cara = new Pokemon('Cara', //nom
					'Pokemon', //type
					'100', //pv
					'100', //pv max
					'des Paillettes', //defense
					'3', //force
					'70', //initiative
					'90'); //precision

$rondoudou = new Pokemon('Rondoudou', //nom
						 'Pokemon', //type
						 '100', //pv
						 '100', //pv max
						 'Zzzzz', //defense
						 '4', //force
						 '100', //initiative
						 '80'); //precision

$ponita = new Pokemon('Ponita', //nom
					 'Pokemon', //type
					 '100', //pv
					 '100', //pv max
					 'une Licorne', //defense
					 '5', //force
					 '110', //initiative
					 '100'); //precision

$pokemons = array($pika, $cara, $rondoudou, $ponita);

foreach($pokemons as $att) {
		echo '<p style="color:red">Attaquant : '.$att->nom.'</p>';
		foreach($pokemons as $def) {
				echo '<p style="color:blue">Défenseur : '.$def->nom.' <span style="color:red">(attaquant : '.$att->nom.')</span></p>';
				if($att != $def) {
					$att->attaque($def);
				}
		}

}