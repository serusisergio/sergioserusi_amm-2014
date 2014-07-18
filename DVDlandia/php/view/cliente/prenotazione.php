<div class="input-form">
    <h2>Nuova prenotazione</h2>
    <form method="post" action="cliente/prenota">
        <input type="hidden" name="cmd" value="nuova_prenotazione"/>
        <input type="hidden" name="iddvd" value="<?= $iddvd ?>" />
        <label for="datainizio">Data inizio</label>
        <input type="andatainiziono" name="datainizio" id="datainizio"/>
        <br/>
        <label for="datafine">Data fine</label>
        <input type="datafine" name="datafine" id="datafine"/>
        <br/>
        <div class="btn-group">
            <button type="submit" name="cmd" value="nuova_prenotazione">Salva</button>
            <button type="submit" name="cmd" value="p_annulla">Annulla</button>
        </div>
    </form>
</div>
