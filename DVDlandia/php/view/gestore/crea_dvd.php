<div class="input-form">
    <h3>Crea Film</h3>
    <form method="post" action="gestore/crea_dvd">
        <input type="hidden" name="cmd" value="dvd_nuovo"/>
        <label for="categoria">Categoria</label>
        <select name="categoria" id="categoria">
            <?php foreach ($categorie as $categoria) { ?>
<option value="<?= $categoria->getId() ?>" >
<?= $categoria->getCasaDiscografica()->getNome() . " " . $categoria->getNome()                    ?></option>
<?php } ?>
</select>
<br/>
<label for="anno">Anno</label>
<input type="anno" name="anno" id="anno"/>
<br/>
<label for="titolo">Titolo</label>
<input type="titolo" name="titolo" id="titolo"/>
<br/>
<div class="btn-group">
<button type="submit" name="cmd" value="dvd_nuovo">Salva</button>
<button type="submit" name="cmd" value="a_annulla">Annulla</button>
</div>
</form>
</div>
