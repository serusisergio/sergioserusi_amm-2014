<?php

$json = array();
$json['errori'] = $errori;
$json['noleggi'] = array();
foreach ($noleggi as $noleggio) {

    $element = array();
    $element['cliente'] = $noleggio->getCliente()->getNome() . " " . $noleggio->getCliente()->getCognome();
    $element['datainizio'] = $noleggio->getDatainizio();
    $element['dvd'] = $noleggio->getDvd()->getCategoria()->getCasaDiscografica()->getNome() . " " . $noleggio->getDvd()->getCategoria()->getNome();
    $element['titolo'] = $noleggio->getDvd()->getTitolo();    
    
    $element['datafine'] = $noleggio->getDatafine();
    $element['costo'] = $noleggio->getCosto();

    $json['noleggi'][] = $element;
}
echo json_encode($json);
?>
