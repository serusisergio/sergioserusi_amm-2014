<h2>Elenco Film</h2>
<table>
    <tr>
        <th>Casa Discografica</th>
        <th>Categoria </th>
        <th>Titolo</th>
        <th>Anno Produzione</th>
        <th>Prezzo</th>
    </tr>
    <?
    foreach ($dvdi as $dvd) {
        ?>
<tr>
            <td><?= $dvd->getCategoria()->getCasaDiscografica()->getNome() ?></td>
            <td><?= $dvd->getCategoria()->getNome() ?></td>
            <td><?= $dvd->getTitolo() ?></td>
            <td><?= $dvd->getAnno() ?></td>
            <td><?= $dvd->getPrezzo() ?> €/giorno</td>
</tr>
<? } ?>
</table>
