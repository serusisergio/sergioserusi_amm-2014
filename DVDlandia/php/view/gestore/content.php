<?php
switch ($vd->getSottoPagina()) {
    case 'anagrafica':
        include_once 'anagrafica.php';
        break;

    case 'noleggi':
        include_once 'noleggi.php';
        break;
    
    case 'elencoFilm':
        include_once 'elencoFilm.php';
        break;
    
    case 'noleggi_json':
        include 'noleggi_json.php';
        break;
    
    case 'crea_dvd':
        include_once 'crea_dvd.php';
        break;
        ?>


<?php default: ?>
<h2>Pannello di Controllo</h2>
<p>
Benvenuto, <?= $user->getNome() ?>
</p>
<p>
Scegli una fra le seguenti sezioni:
</p>
<ul>
<li><a href="gestore/anagrafica">Anagrafica</a></li>
<li><a href="gestore/noleggi">Noleggi</a></li>
<li><a href="gestore/film">Film</a></li>

</ul>
<?php
        break;
}
?>
