<?php

class Pokemon {
	
	public $nom;

	public $type;

	public $pv;

	public $pvmax;

	public $defense;

	public $force;

	public $initiative;

	public $precision;

	public $affinites = array('electrik' => array('electrik' => 1, 'eau' =>							2, 'feu' => 1, 'plante' => 1, 'roche' => 0						),
                              'eau' => array('electrik' => 0.5, 'eau' => 1, 'feu' => 2, 'plante' => 0.5, 'roche' => 2),
                              'feu' => array('electrik' => 1, 'eau' => 0.5, 'feu' => 1, 'plante' => 2, 'roche' => 0.5)
                             );

	public function __construct($nom, $type, $pv, $defense, $force, $initiative, $precision) {
		$this->nom = $nom;
		$this->type = $type;
		$this->pv = $this->pvmax = $pv;
		$this->defense = $defense;
		$this->force = $force;
		$this->initiative = $initiative;
		$this->precision = $precision;
		$this->affinites = $this->affinites[$this->type];
	}

	public function combat($adversaire) {
        if(!$adversaire instanceof Pokemon) {
            throw new InvalidArgumentException('L’adversaire n’est pas un pokémon.');
        }
        // $this veut attaquer $adversaire. On détermine qui touche en premier
        $log = array();
        if($this->pv <= 0 || $adversaire->pv <= 0) {
            throw new Exception('Les morts ne se battent pas !');
        }
        if($this->initiative < $adversaire->initiative) {
            $log = array_merge($log, $adversaire->attaque($this));
            if($this->pv > 0) {
                $log = array_merge($log, $this->attaque($adversaire, true));
            }
        } else {
            $log = array_merge($log, $this->attaque($adversaire));
            if($adversaire->pv > 0) {
                $log = array_merge($log, $adversaire->attaque($this, true));
            }
        }
        return $log;
    }

	public function attaque($cible, $contre = false) {
			$log = array();
        // on vérifie si le coup touche
        $log[] = $this->nom.' '.($contre ? 'contre-' : '').'attaque '.$cible->nom.'.';
        if(mt_rand(1, 100) <= $this->precision) { // on touche !
            // on calcule les dégâts
            $degats = $this->force;
            // gestion des affinités
            $degats *= $this->affinites[$cible->type];
            if($this->affinites[$cible->type] > 1) {
                $log[] = 'C’est super efficace !';
            } elseif($this->affinites[$cible->type] < 1) {
                $log[] = 'Ce n’est pas très efficace…';
            }
            $log = array_merge($log, $cible->defense($degats));
            if($cible->pv <= 0) {
                $log[] = $cible->nom.' est KO !';
            }
        } else { // on a raté
            $log[] = '… mais échoue !';
        }
        return $log;
    }

    public function defense($degats) {
        $log = array();
        // on applique la défense
        //echo 'on attaque avec '.$degats.' points (def '.($this->defense/100).').'.PHP_EOL;
        $pv_perdus = round($degats * (1-($this->defense / 100)));
        //echo 'on subit '.$pv_perdus.' points.'.PHP_EOL;
        $log[] = $this->nom.' subit '.$pv_perdus.' points de dégats.';
        $this->pv -= $pv_perdus;
        if($this->pv < 0) $this->pv = 0;
        return $log;
    }
}