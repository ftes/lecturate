<?php T::setEditable(true); ?>

<h1>Create Lecture</h2>

<form method="POST">
<table>
		<tr>
			<th>Token</th>
			<td><?=T::input($model->getAttribute("token")); ?>
			</td>
			<td><?=T::error(); ?>
			</td>
		</tr>
		<tr>
			<th>Name</th>
			<td><?=T::input($model->getAttribute("name")); ?>
			</td>
			<td><?=T::error(); ?>
			</td>
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