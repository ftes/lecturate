<?php T::setEditable(true); ?>

<h1>Create OTPW</h1>

<form method="POST">
	<table>
		<tr>
			<th>OTPW</th>
			<td><?=T::input($model->getAttribute("otpw")); ?></td>
			<td><?=T::error(); ?></td>
		</tr>
		<tr>
			<th>DocentLecture</th>
			<td><?=T::select($model->getAttribute("dl_id"), $docentLectures); ?>
			</td>
			<td><?=T::error(); ?></td>
		</tr>
		<tr>
			<th></th>
			<td><?=T::button(T::CANCEL) ?> <?=T::button(T::SAVE) ?>
			</td>
			<td></td>
		</tr>
	</table>
</form>
