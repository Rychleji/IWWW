<form method="post" action="<?= BASE_URL . "?page=tvorbaclanku" ?>">
    <label for="nazevClanku"><b>Nadpis:</b></label>
    <input type="text" name="nazevClanku" placeholder="Název" required>
    <input type='text' name='textClanku' value='<?PHP echo $_POST['text']; ?>'required>
    <div class="right">
        <button type="submit" id="get-text" class="btn">Uložit</button>
    </div>
</form>