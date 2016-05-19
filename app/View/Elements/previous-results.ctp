
<?php

$userData = NULL;
$count = 0;
foreach($data as $d)
{
	foreach($d['data'] as $values)
	{

		if((count($d['data']) - 1) > $count)
			$userData .= $values['name'].' : '.$values['value'].', ';
		else
			$userData .= $values['name'].' : '.$values['value'];

		$count++;
	}
		

	?>
		<div class="workout-template-detail-block">
			Created : <?php echo $d['created']; ?><br />
			Results: <?php echo $userData; ?>
		</div>
	<?php

	$userData = NULL;
	$count = 0;
}