<form method="post" action="<?= BASE_URL . "?page=tvorbaclanku" ?>">
    <label for="nazevClanku"><b>Nadpis:</b></label>
    <input type="text" name="nazevClanku" placeholder="Název" required>
    <label for="tagy"><b>Tagy (ve tvaru: "tag1;tag2;tag3"):</b></label>
    <input type="text" name="tagy" palaceholder="Tag1;Tag2" required>

    <input type='hidden' name='textClanku' value='<?PHP echo $_POST['text']; ?>'required>
    <div class="right">
        <button type="submit" id="get-text" class="btn">Uložit</button>
    </div>
</form>