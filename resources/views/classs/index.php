<h1>Kurse</h1>

<table>
	<tr>
		<th>ID</th>
		<th>Kürzel</th>
		<th>Größe</th>
		<th>Studiengangsleiter</th>
		<th></th>
		<th></th>
		<th></th>
	</tr>
	<?php foreach($models as $model): ?>
	<tr>
		<td><?=$model->getValue("id"); ?></td>
		<td><?=$model->getValue("token"); ?></td>
		<td><?=$model->getValue("size"); ?></td>
		<td><?=$advisors[$model->getValue("id")]; ?></td>
		<td><?=T::iconButton(T::VIEW, false, "classs", "view", 
				array("id"=>$model->getValue("id")))?>
		</td>
		<td><?=T::iconButton(T::EDIT, false, "classs", "edit", 
				array("id"=>$model->getValue("id")))?>
		</td>
		<td><?=T::iconButton(T::DELETE, false, "classs", "delete", 
				array("id"=>$model->getValue("id")))?>
		</td>
	</tr>
	<?php endforeach; ?>
</table>
