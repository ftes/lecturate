<?php T::setEditable(true); ?>

<h1>Create Rating</h1>

<form method="POST">
<table>
		<tr>
			<th>Mark</th>
			<td><?=T::input($model->getAttribute("mark")); ?>
			</td>
			<td><?=T::error(); ?>
			</td>
		</tr>
		<tr>
			<th>OTPW</th>
			<td><?=T::select($model->getAttribute("o_id"), $otpws); ?></td>
			<td></td>
		</tr>		
		<tr>
			<th>DocentLecture</th>
			<td><?=T::select($model->getAttribute("dl_id"), $docentLectures); ?></td>
			<td></td>
		</tr>
		<tr>
			<th>Comment</th>
			<td><?=T::input($model->getAttribute("comment")); ?></td>
			<td></td>
		</tr>
		<tr>
			<th></th>
			<td><?=T::button(T::CANCEL) ?>
				<?=T::button(T::SAVE) ?>
				<td></td>
			</td>
		</tr>
</table>
</form>