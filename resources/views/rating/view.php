<?php T::setEditable(false); ?>

<h1>View Rating</h1>

<form method="POST">
<table>
		<tr>
			<th>ID</th>
			<td><?=T::input($model->getAttribute("id")); ?>
			</td>
		</tr>
		<tr>
			<th>Mark</th>
			<td><?=T::input($model->getAttribute("mark")); ?>
			</td>
		</tr>
		<tr>
			<th>Created</th>
			<td><?=$model->getAttribute("created")->getValue(); ?></td>
		</tr>
		<tr>
			<th>OTPW</th>
			<td><?=T::select($model->getAttribute("o_id"), $otpws); ?></td>
		</tr>
		<tr>
			<th>DocentLecture</th>
			<td><?=T::select($model->getAttribute("dl_id"), $docentLectures); ?>
			</td>
		</tr>
		<tr>
			<th>Comment</th>
			<td><?=T::input($model->getAttribute("comment")); ?>
			</td>
		</tr>
		<tr>
			<th></th>
			<td><?=T::button(T::CANCEL) ?> <?=T::button(T::SAVE) ?>
			</td>
		</tr>
</table>
</form>

<a href="<?=T::href("rating", "edit", array("id" => $model->getValue("id"))); ?>">Edit</a>
<a href="<?=T::href("rating", "delete", array("id" => $model->getValue("id"))); ?>">Delete</a>