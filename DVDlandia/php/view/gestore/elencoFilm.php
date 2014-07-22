<h3>Elenco Film</h3>
<table>
    <tr>
        <th>Casa Discografica</th>
        <th>Categoria </th>
        <th>Titolo</th>
        <th>Anno Produzione</th>
        <th>Prezzo</th>
        <th>Cancella</th>
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
            <td><a href="gestore/film?cmd=cancella_dvd&dvd=<?= $dvd->getId()?>" title="Elimina il dvd">
<img src="../images/cancella.png" alt="Elimina"></a>
        </tr>
    <? } ?>
</table>

<div class="input-form">

    <form method="post" action="gestore/film">
        <button type="submit" name="cmd" value="new_dvd">Crea Film</button>
    </form>

</div>
