<?php
switch ($vd->getSottoPagina()) {
    case 'anagrafica':
        include_once 'anagrafica.php';
        break;

    case 'elencoFilm':
        include_once 'elencoFilm.php';
        break;

    default:
        ?>
<h2 class="icon-title">Area Cliente</h2>
<p id="benv">
Benvenuto, <?= $user->getNome() ?>
</p>
<p>
Scegli una fra le seguenti sezioni:
</p>
<ul class="panel" id="panel"> 
<li><a id="anagraficaa" href="cliente/anagrafica">Anagrafica</a></li>
<li><a id="filmm" href="cliente/dvdi">Film</a></li>
</ul>
<?php
        break;
}
?>
