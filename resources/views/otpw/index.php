<h1>OTPWs</h1>

<table>
	<tr>
		<th>ID</th>
		<th>OTPW</th>
		<th>DocentLecture</th>
		<th>Used</th>
		<th>Created</th>
		<th>Used</th>
		<th></th>
		<th></th>
		<th></th>
	</tr>
	<?php foreach($models as $model): ?>
	<tr>
		<td><?=$model->getValue("id"); ?></td>
		<td><?=$model->getValue("otpw"); ?></td>
		<td><?=$docentLectures[$model->getValue("id")]; ?></td>
		<td><?=$model->getValue("used"); ?></td>
		<td><?=$model->getValue("created"); ?></td>
		<td><?=$model->getValue("used_ts"); ?></td>
		<td><a href="<?=T::href("otpw", "view", array("id"=>$model->getValue("id"))); ?>">View</a></td>
		<td><a href="<?=T::href("otpw", "edit", array("id"=>$model->getValue("id"))); ?>">Edit</a></td>
		<td><a href="<?=T::href("otpw", "delete", array("id"=>$model->getValue("id"))); ?>">X</a></td>
	</tr>
	<?php endforeach; ?>
</table>