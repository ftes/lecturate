<h1>Ratings</h1>

<table>
	<tr>
		<th>ID</th>
		<th>Mark</th>
		<th>Created</th>
		<th>OTPW</th>
		<th>DocentLecture</th>
		<th>Comment</th>
		<th></th>
		<th></th>
		<th></th>
	</tr>
	<?php foreach($models as $model): ?>
	<tr>
		<td><?=$model->getValue("id"); ?></td>
		<td><?=$model->getValue("mark"); ?></td>
		<td><?=$model->getValue("created"); ?></td>
		<td><?=$otpws[$model->getValue("id")]; ?></td>
		<td><?=$docentLectures[$model->getValue("id")]; ?></td>
		<td><?=$model->getValue("comment"); ?></td>
		<td><a href="<?=T::href("rating", "view", array("id"=>$model->getValue("id"))); ?>">View</a></td>
		<td><a href="<?=T::href("rating", "edit", array("id"=>$model->getValue("id"))); ?>">Edit</a></td>
		<td><a href="<?=T::href("rating", "delete", array("id"=>$model->getValue("id"))); ?>">X</a></td>
	</tr>
	<?php endforeach; ?>
</table>