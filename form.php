<?php

require_once __DIR__ . '/effort.php';

$challenge = 'bob';

$form = <<<HTML
<html>
<body>

<script>


</script>

<form action="form.php" method="post">
    Name: <input type="text" name="name"><br>
    <input type="submit">
</form>

<script src="https://cdnjs.cloudflare.com/ajax/libs/js-sha1/0.6.0/sha1.min.js"></script>

</body>
</html>
HTML;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

} else {
    echo $form;
}


