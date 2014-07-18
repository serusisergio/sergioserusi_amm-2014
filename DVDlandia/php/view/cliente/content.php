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
    
    case 'prenotazione':
        include_once 'prenotazione.php';
        break;

    default:
        ?>
<h2 class="icon-title">Area Cliente</h2>
<p>
Benvenuto, <?= $user->getNome() ?>
</p>
<p>
Scegli una fra le seguenti sezioni:
</p>
<ul class="panel"> 
<li><a href="cliente/anagrafica">Anagrafica</a></li>
<li><a href="cliente/dvdi">Film</a></li>
<li><a href="cliente/noleggi">Elenco Noleggi</a></li>


</ul>
<?php
        break;
}
?>
