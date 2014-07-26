<h2>Cliente</h2>
<ul>
    <li class="<?= $vd->getSottoPagina() == 'home' || $vd->getSottoPagina() == null ? 'current_page_item' : '' ?>"><a href="cliente">Home</a></li>
    <li class="<?= $vd->getSottoPagina() == 'anagrafica' ? 'current_page_item' : '' ?>"><a href="cliente/anagrafica">Anagrafica</a></li>
    <li class="<?= $vd->getSottoPagina() == 'film' ? 'current_page_item' : '' ?>"><a href="cliente/film">Film</a></li>
    
</ul>
