<h1>Einmal-PW</h1>

<table>
	<tr>
		<th>ID</th>
		<th>Einmal-PW</th>
		<th>Dozent hält Vorlesung</th>
		<th>Verwendet</th>
		<th></th>
		<th></th>
	</tr>
	<?php foreach($models as $model): ?>
	<tr>
		<td><?=$model->getValue("id"); ?></td>
		<td><?=$model->getValue("otpw"); ?></td>
		<td><?=$docentLectures[$model->getValue("id")]; ?></td>
		<td><?=$model->getValue("used"); ?></td>
		<td><?=T::iconButton(T::VIEW, false, "otpw", "view", 
				array("id"=>$model->getValue("id")))?>
		</td>
		<td><?=T::iconButton(T::DELETE, false, "otpw", "delete", 
				array("id"=>$model->getValue("id")))?>
		</td>
	</tr>
	<?php endforeach; ?>
</table>
