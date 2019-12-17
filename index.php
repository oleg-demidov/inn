
<form action="" method="post">
    <input type="text" name="inn" size="100"><br>
    <button type="submit">Проверить</button>
</form>

<br>

<?php
if (isset($_POST['inn'])){
    include_once ('authenticity.php');
    $authenticity = new Authenticity();
    echo '<p>Проверка ИНН=' . $_POST['inn'] . ':</p><pre>';
    print_r($authenticity->get($_POST['inn']));
    echo '</pre>';
}
