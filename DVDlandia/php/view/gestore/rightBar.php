<h3>Gestore</h3>
<ul>
    <li class="<?= $vd->getSottoPagina() == 'home' || $vd->getSottoPagina() == null ? 'current_page_item' : ''?>"><a href="gestore/home">Home</a></li>
    <li class="<?= $vd->getSottoPagina() == 'anagrafica' ? 'current_page_item' : '' ?>"><a href="gestore/anagrafica">Anagrafica</a></li>
    <li class="<?= $vd->getSottoPagina() == 'film' ? 'current_page_item' : '' ?>"><a href="gestore/film">Film Presenti</a></li>
</ul>


