<h1>Lectures</h1>

<table>
	<tr>
		<th>ID</th>
		<th>Token</th>
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
		<td><a href="<?=T::href("lecture", "view", array("id"=>$model->getValue("id"))); ?>">View</a></td>
		<td><a href="<?=T::href("lecture", "edit", array("id"=>$model->getValue("id"))); ?>">Edit</a></td>
		<td><a href="<?=T::href("lecture", "delete", array("id"=>$model->getValue("id"))); ?>">X</a></td>
	</tr>
	<?php endforeach; ?>
</table>