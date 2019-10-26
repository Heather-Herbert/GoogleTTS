<?php

require('classes/tts.php');
use MI\GoogleTTS;

if (isset($_POST['story'])) {
    $tts = (new GoogleTTS());
    $tts->saveMp3HTTP($_POST['story']);
}

?><!DOCTYPE html>
<html>
<body>

<form action="/index.php" method="POST">
    First name:<br>
    <textarea name="story">

    </textarea>

    <input type="submit" value="Submit">
</form>
</body>
</html>
