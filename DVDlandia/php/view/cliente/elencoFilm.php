<h2>Elenco Film</h2>
<table>
    <tr>
        <th>Casa Editrice</th>
        <th>Categoria</th>
        <th>Titolo</th>
        <th>Anno</th>
        <th>Costo</th>
        <th>Prenota</th>
    </tr>
    <?
    foreach ($dvdi as $dvd) {
        ?>
<tr>
<td><?= $dvd->getCategoria()->getCasaEditrice()->getNome() ?></td>
<td><?= $dvd->getCategoria()->getNome() ?></td>
<td><?= $dvd->getTitolo() ?></td>
<td><?= $dvd->getAnno() ?></td>
<td><?= $dvd->getCategoria()->getPrezzo() . " €/giorno" ?></td>
<td><a href="cliente/dvdi?cmd=prenota&dvd=<?= $veicolo->getId() ?>" title="Prenotazione Film">
<img src="../images/navigazione-mini.png" alt="Prenota"></a></td>
</tr>
<? } ?>
</table>
