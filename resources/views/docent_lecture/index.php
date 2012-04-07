<h1>DocentLectures</h1>

<table>
	<tr>
		<th>ID</th>
		<th>Docent</th>
		<th>Lecture</th>
		<th></th>
		<th></th>
		<th></th>
	</tr>
	<?php foreach($models as $model): ?>
	<tr>
		<td><?=$model->getValue("id"); ?></td>
		<td><?=$docents[$model->getValue("id")]; ?></td>
		<td><?=$lectures[$model->getValue("id")]; ?></td>
		<td><a href="<?=T::href("docent_lecture", "view", array("id"=>$model->getValue("id"))); ?>">View</a></td>
		<td><a href="<?=T::href("docent_lecture", "edit", array("id"=>$model->getValue("id"))); ?>">Edit</a></td>
		<td><a href="<?=T::href("docent_lecture", "delete", array("id"=>$model->getValue("id"))); ?>">X</a></td>
	</tr>
	<?php endforeach; ?>
</table>