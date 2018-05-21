
<p>задачи:</p>
<?php
foreach (glob("tests/*.json") as $i => $filename) {
	$name = basename($filename);?>

<label ><a href="test.php?testname=<?= $name ?>">Выбрать задачу</a> <?= ++$i, "</br>" ?> </label>
    
<?php }?>





