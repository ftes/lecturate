<h1>Classes</h1>

<table>
	<tr>
		<th>ID</th>
		<th>Token</th>
		<th>Advisor</th>
		<th></th>
		<th></th>
		<th></th>
	</tr>
	<?php foreach($models as $model): ?>
	<tr>
		<td><?=$model->getValue("id"); ?></td>
		<td><?=$model->getValue("token"); ?></td>
		<td><?=$advisors[$model->getValue("id")]; ?></td>
		<td><a href="<?=T::href("classs", "view", array("id"=>$model->getValue("id"))); ?>">View</a></td>
		<td><a href="<?=T::href("classs", "edit", array("id"=>$model->getValue("id"))); ?>">Edit</a></td>
		<td><a href="<?=T::href("classs", "delete", array("id"=>$model->getValue("id"))); ?>">X</a></td>
	</tr>
	<?php endforeach; ?>
</table>