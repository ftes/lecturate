<?php T::setEditable(false); ?>

<h1>
	View OTPW
	</h1>

	<form method="POST">
		<table>
			<tr>
				<th>ID</th>
				<td><?=T::input($model->getAttribute("id")); ?>
				</td>
			</tr>
			<tr>
				<th>OTPW</th>
				<td><?=T::input($model->getAttribute("otpw")); ?></td>
			</tr>
			<tr>
				<th>DocentLecture</th>
				<td><?=T::select($model->getAttribute("dl_id"), array($docentLecture)); ?>
				</td>
			</tr>
			<tr>
				<th>Used</th>
				<td><?=T::select($model->getAttribute("used"), $usedOptions, true); ?>
				</td>
			</tr>
			<tr>
				<th>Created</th>
				<td><?=$model->getAttribute("created")->getValue(); ?></td>
			</tr>
			<tr>
				<th>Used</th>
				<td><?=$model->getAttribute("used_ts")->getValue(); ?></td>
			</tr>
		</table>
	</form>

	<a
		href="<?=T::href("otpw", "edit", array("id" => $model->getValue("id"))); ?>">Edit</a>
	<a
		href="<?=T::href("otpw", "delete", array("id" => $model->getValue("id"))); ?>">Delete</a>