<h1>Bewertungen</h1>

<table>
	<tr>
		<th>ID</th>
		<th>Bewertung</th>
		<th>Dozent hält Vorlesung</th>
		<th></th>
		<th></th>
	</tr>
	<?php foreach($models as $model): ?>
	<tr>
		<td><?=$model->getValue("id"); ?></td>
		<td><?=$model->getValue("mark"); ?></td>
		<td><?=$docentLectures[$model->getValue("id")]; ?></td>
		<td><?=T::iconButton(T::VIEW, false, "rating", "view", 
				array("id"=>$model->getValue("id")))?>
		</td>
		<td><?=T::iconButton(T::DELETE, false, "rating", "delete", 
				array("id"=>$model->getValue("id")))?>
		</td>
	</tr>
	<?php endforeach; ?>
</table>
