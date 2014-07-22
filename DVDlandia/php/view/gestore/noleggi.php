<h3>Ricerca Film noleggiati</h3>
<div class="error">
    <div>
        <ul><li>Testo</li></ul>
    </div>
</div>
<div class="input-form">
    <h3>Filtro</h3>
    <form method="get" action="gestore/noleggi">
        <label for="dvd">Film</label>
        <select name="dvd" id="dvd">
            <option value="">Qualsiasi</option>
            <?php foreach ($dvdi as $dvd) { ?>
                <option value="<?= $dvd->getId() ?>" ><?= $dvd->getCategoria()->getNome() . " " . $dvd->getTitolo() ?></option>
            <?php } ?>
        </select>
        <br/>
        <label for="cliente">Cliente</label>
        <select name="cliente" id="cliente">
            <option value="">Qualsiasi</option>
            <?php foreach ($clienti as $cliente) { ?>
                <option value="<?= $cliente->getId() ?>" ><? echo $cliente->getNome() . " " . $cliente->getCognome() ?></option>
            <?php } ?>
        </select>
        <br/>
        <label for="datainizio">Data inizio</label>
        <input name="datainizio" id="datainizio" type="text"/>
        <br/>
        <label for="datafine">Data fine</label>
        <input name="datafine" id="datafine" type="text"/>
        <br/>
        <button id="filtra" type="submit" name="cmd">Cerca</button>
    </form>
</div>



<h3>Elenco Noleggi</h3>

<p id="nessuno">Nessun noleggio trovato</p>

<table id="tabella_noleggi">
    <thead>
        <tr>
            <th>Cliente</th>
            <th>Dvd</th>
            <th>Titolo</th>
            <th>Data inizio</th>
            <th>Data fine</th>
            <th>Costo</th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>
