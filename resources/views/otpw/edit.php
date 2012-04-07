<?php T::setEditable(true); ?>

<h1>Edit OTPW</h1>
	
<form method="POST">
<table>
			<tr>
				<th>ID</th>
				<td><?=T::input($model->getAttribute("id")); ?></td>
				<td><?=T::error(); ?></td>
			</tr>
			<tr>
				<th>OTPW</th>
				<td><?=T::input($model->getAttribute("otpw")); ?></td>
				<td><?=T::error(); ?></td>
			</tr>
			<tr>
				<th>DocentLecture</th>
				<td><?=T::select($model->getAttribute("dl_id"), $docentLectures); ?></td>
				<td><?=T::error(); ?></td>
			</tr>
			<tr>
				<th>Used</th>
				<td><?=T::select($model->getAttribute("used"), $usedOptions, true); ?></td>
				<td><?=T::error(); ?></td>
			</tr>
			<tr>
				<th>Created</th>
				<td><?=$model->getAttribute("created")->getValue(); ?></td>
				<td></td>
			</tr>
			<tr>
				<th>Used</th>
				<td><?=$model->getAttribute("used_ts")->getValue(); ?></td>
				<td></td>
			</tr>
			<tr>
			<th></th>
			<td><?=T::button(T::CANCEL) ?>
				<?=T::button(T::SAVE) ?>
			</td>
			<td></td>
		</tr>
</table>
</form>