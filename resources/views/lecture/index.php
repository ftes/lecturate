<h1>Vorlesungen</h1>

<table>
	<tr>
		<th>ID</th>
		<th>Kürzel</th>
		<th>Name</th>
		<th></th>
		<th></th>
		<th></th>
	</tr>
	<?php foreach($models as $model): ?>
	<tr>
		<td><?=$model->getValue("id"); ?></td>
		<td><?=$model->getValue("token"); ?></td>
		<td><?=$model->getValue("name"); ?></td>
		<td><?=T::iconButton(T::VIEW, false, "lecture", "view", array("id"=>$model->getValue("id")))?></td>
		<td><?=T::iconButton(T::EDIT, false, "lecture", "edit", array("id"=>$model->getValue("id")))?></td>
		<td><?=T::iconButton(T::DELETE, false, "lecture", "delete", array("id"=>$model->getValue("id")))?></td>
	</tr>
	<?php endforeach; ?>
</table>