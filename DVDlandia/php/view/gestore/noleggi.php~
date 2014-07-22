<h2>Noleggi</h2>
<table id="tbnl">
    <thead>
        <tr>
            <th>Film</th>
            <th>Titolo</th>
            <th>Data inizio</th>
            <th>Data fine</th>
            <th>Costo</th>
        </tr>
    </thead>
    <tbody>
        <? foreach($noleggi as $noleggio) { ?>
<tr>
<td><?= $noleggio->getDvd()->getCategoria()->getCasaDiscografica()->getNome() . " " . $noleggio->getDvd()->getCategoria()->getNome() ?></td>
<td><?= $noleggio->getDvd()->getTitolo() ?></td>
<td><?= $noleggio->getDatainizio() ?></td>
<td><?= $noleggio->getDatafine() ?></td>
<td><?= $noleggio->getCosto() ?> €</td>
</tr>
<? } ?>

</tbody>
</table>
