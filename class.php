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
        // $this veut attaquer $adversaire. On détermine qui touche en premier
        $log = array();
        if($this->pv <= 0 || $adversaire->pv <= 0) {
            $log[] = 'Les morts ne se battent pas !';
        } else {
            if($this->initiative < $adversaire->initiative) {
                $log = array_merge($log, $adversaire->attaque($this));
                if($this->pv > 0) {
                    $log = array_merge($log, $this->attaque($adversaire));
                }
            } else {
                $log = array_merge($log, $this->attaque($adversaire));
                if($adversaire->pv > 0) {
                    $log = array_merge($log, $adversaire->attaque($this));
                }
            }
        }
        return $log;
    }

	public function attaque($cible) {
			$log = array();
        // on vérifie si le coup touche
        if(mt_rand(1, 100) <= $this->precision) { // on touche !
            $log[] = $this->nom.' attaque '.$cible->nom.'.';
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
            $log[] = $this->nom.' attaque '.$cible->nom.'… mais rate son coup !';
        }
        return $log;
    }

    public function defense($degats) {
        $log = array();
        // on applique la défense
        $pv_perdus = round($degats * ($this->defense / 100));
        $log[] = $this->nom.' subit '.$pv_perdus.' points de dégats.';
        $this->pv -= $pv_perdus;
        if($this->pv < 0) $this->pv = 0;
        return $log;
    }
}