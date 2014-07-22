<?php
switch ($vd->getSottoPagina()) {
    case 'anagrafica':
        include_once 'anagrafica.php';
        break;

    case 'elencoFilm':
        include_once 'elencoFilm.php';
        break;
        
    case 'cancella_dvd':
        include_once 'cancella_dvd.php';
        break;
        
        ?>
<?php default: ?>
<h2>Pannello di Controllo</h2>
<p id="benvenuto">
Benvenuto, <?= $user->getNome() ?>
</p>
<p>
Scegli una fra le seguenti sezioni:
</p>
<ul class="panel" id="panel"> 
<li><a id="anagrafica" href="cliente/anagrafica">Anagrafica</a></li>
<li><a id="film" href="cliente/film">Film</a></li>
</ul>
<?php
        break;
}
?>
