<?php
?>

<form method="post" action="<?= BASE_URL . "?page=clanek&clanek=".$_GET['cl'] ?>">
    <div class="container">
        <label for="komentar"><b>Komentář:</b></label>
        <input type="text" name="komentar" required>
        <input type="hidden" name="pred_kom" value='<?PHP echo $_GET['kom']; ?>'>

        <hr>
        <button type="submit" class="right">Odeslat</button>
    </div>
</form>
