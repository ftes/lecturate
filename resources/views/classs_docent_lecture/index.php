<h1>ClassDocentLectures</h1>

<table>
	<tr>
		<th>ID</th>
		<th>Classt</th>
		<th>DocentLecture</th>
		<th></th>
		<th></th>
		<th></th>
	</tr>
	<?php foreach($models as $model): ?>
	<tr>
		<td><?=$model->getValue("id"); ?></td>
		<td><?=$classses[$model->getValue("id")]; ?></td>
		<td><?=$docentLectures[$model->getValue("id")]; ?></td>
		<td><a href="<?=T::href("classs_docent_lecture", "view", array("id"=>$model->getValue("id"))); ?>">View</a></td>
		<td><a href="<?=T::href("classs_docent_lecture", "edit", array("id"=>$model->getValue("id"))); ?>">Edit</a></td>
		<td><a href="<?=T::href("classs_docent_lecture", "delete", array("id"=>$model->getValue("id"))); ?>">X</a></td>
	</tr>
	<?php endforeach; ?>
</table>