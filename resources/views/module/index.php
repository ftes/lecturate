<h1>Module List</h2>

<table border="0">
	<tr>
		<th>ID</th>
		<th>Token</th>
	</tr>
	<?php foreach($models as $model): ?>
	<tr>
		<td><?=$model->getValue("id"); ?></td>
		<td><?=$model->getValue('token'); ?></td>
		<td><?=$model->getValue('inti'); ?></td>
		<td><a href="<?=T::href("module", "view", array("id"=>$model->getValue("id"))); ?>">View</a></td>
		<td><a href="<?=T::href("module", "edit", array("id"=>$model->getValue("id"))); ?>">Edit</a></td>
		<td><a href="<?=T::href("module", "delete", array("id"=>$model->getValue("id"))); ?>">X</a></td>
	</tr>
	<?php endforeach; ?>
</table>