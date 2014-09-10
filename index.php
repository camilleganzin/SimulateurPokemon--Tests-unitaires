<?php
require_once('class.php');
require_once('header.php');




//Pour créer un objet, on instancie et on donne les paramètres 
$pika = new Pokemon('Pika', //nom
					'electrik', //type
					'100', //pv
					'60', //defense
					'2', //force
					'80', //initiative
					'100'); //precision

$cara = new Pokemon('Cara', //nom
					'eau', //type
					'100', //pv
					'45', //defense
					'3', //force
					'70', //initiative
					'90'); //precision

$rondoudou = new Pokemon('Rondoudou', //nom
						 'eau', //type
						 '100', //pv
						 '30', //defense
						 '4', //force
						 '100', //initiative
						 '80'); //precision

$ponita = new Pokemon('Ponita', //nom
					 'feu', //type
					 '100', //pv
					 '50', //defense
					 '5', //force
					 '110', //initiative
					 '100'); //precision

$pokemons = array($pika, $cara, $rondoudou, $ponita);

foreach(range(1, 10) as $i) {
    $combat = $pika->combat($cara);

    echo '<h1>Résultats du tour '.$i.' :</h1>'.PHP_EOL;
    echo '<ul>'.PHP_EOL;

    foreach($combat as $info) {
        echo '<li>'.$info.'</li>'.PHP_EOL;
    }
    echo '</ul>';
    echo '<p>État des pokémons : <br />';
    echo $pika->nom.' : '.$pika->pv.'/'.$pika->pvmax.'<br />';
    echo $cara->nom.' : '.$cara->pv.'/'.$cara->pvmax.'</p>'.PHP_EOL;
}

foreach(range(1, 10) as $i) {
    $combat = $ponita->combat($rondoudou);

    echo '<h1>Résultats du tour '.$i.' :</h1>'.PHP_EOL;
    echo '<ul>'.PHP_EOL;

    foreach($combat as $info) {
        echo '<li>'.$info.'</li>'.PHP_EOL;
    }
    echo '</ul>';
    echo '<p>État des pokémons : <br />';
    echo $ponita->nom.' : '.$ponita->pv.'/'.$ponita->pvmax.'<br />';
    echo $rondoudou->nom.' : '.$rondoudou->pv.'/'.$rondoudou->pvmax.'</p>'.PHP_EOL;
}