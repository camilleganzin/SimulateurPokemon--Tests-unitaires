<?php
require_once('class.php');

class PokemonTest extends PHPUnit_Framework_TestCase {

	public function setUp(){
		$this->pokemon = new Pokemon('Pokemon', 'electrik', 80, 20, 3, 4, 100);
	}

	public function testConstructNom() {
		$this->assertEquals('Pokemon', $this->pokemon->nom, 'Le nom ne correspond pas');
	}

	public function testConstructType() {
		$this->assertEquals('electrik', $this->pokemon->type, 'Le type ne correspond pas');
	}

	public function testConstructPv() {
		$this->assertEquals(80, $this->pokemon->pv, 'Les pv ne correpondent pas');
		$this->assertEquals(80, $this->pokemon->pvmax, 'Les pvmax ne correspondent pas');
	}

	public function testConstructForce() {
		$this->assertEquals(3, $this->pokemon->force, 'La force ne correspond pas');
	}	

	public function testConstructDefense() {
		$this->assertEquals(20, $this->pokemon->defense, 'La defense ne correspond pas');
	}

	public function testConstructInitiative() {
		$this->assertEquals(4, $this->pokemon->initiative, 'L\'initiative ne correspond pas');
	}	
		
	public function testConstructPrecision() {
		$this->assertEquals(100, $this->pokemon->precision, 'La précision ne corespond pas');
	}

		
	public function testConstructAffinites() {
		$aff = array('electrik' => 1, 'eau' => 2, 'feu' => 1, 'plante' => 1, 'roche' => 0);
		$this->assertEquals($aff, $this->pokemon->affinites, 'Les affinités ne correspondent pas');
	}

	public function testCombat() {
		$pokemon2 = new Pokemon('pokemon', 'eau', 80, 30, 4, 3, 100);

		$combat = $this->pokemon->combat($pokemon2);

		$this->assertEquals(78, $this->pokemon->pv, 'les pv de pokemon 1 ne correspondent pas');

		$this->assertEquals(76, $pokemon2->pv, 'les pv de pokemon 2 ne correspondent pas');

	}

	/**
     * @expectedException InvalidArgumentException
     */
    public function testCombatErreur() {
        $cible = 'pouet';
        $combat = $this->pokemon->combat($cible);
    }

    /**
     * @expectedException Exception
     */
    public function testCombatMortErreur() {
        $cible = new Pokemon('Cible morte', 'eau', 0, 1, 1, 1, 1);
        $combat = $this->pokemon->combat($cible);
    }

    public function testCombatRetour() {
        $cible = new Pokemon('Cible', 'eau', 4, 2, 2, 1, 100);
        $combat = $this->pokemon->combat($cible);
        $this->assertInternalType('array', $combat);
        $this->assertCount(4, $combat);
        return array($cible, $combat);
    }

    /**
     * @depends testCombatRetour
     */
    public function testCombatVie($tableau) {
        list($pokemon, $combat) = $tableau;
        $this->assertEquals(0, $pokemon->pv);
        $this->assertEquals($this->pokemon->pvmax, $this->pokemon->pv);
    }

	public function testCombatPremierAttaquant(){
		$pokemon2 = new Pokemon('Cible', 'eau', 80, 30, 4, 5, 0);

		$combat = $this->pokemon->combat($pokemon2);

        $this->assertEquals($combat[0], 'Cible attaque Pokemon… mais rate son coup !');
	}

	public function testCombatInitiativesEgales(){
		$pokemon2 = new Pokemon('Cible', 'eau', 80, 30, 4, 4, 0);

		$combat = $this->pokemon->combat($pokemon2);

        $this->assertEquals($combat[0], 'Pokemon attaque Cible.');
	}	

}