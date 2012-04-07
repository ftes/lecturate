<?php T::setEditable(true); ?>

<h1>Create Advisor</h1>

<form method="POST">
<table>
		<tr>
			<th>User name</th>
			<td><?=T::input($model->getAttribute("username")); ?>
			</td>
			<td><?=T::error(); ?>
			</td>
		</tr>
		<tr>
			<th>Password</th>
			<td><?=T::input($model->getAttribute("password")); ?>
			</td>
			<td><?=T::error(); ?>
			</td>
		</tr>
		<tr>
			<th>First name</th>
			<td><?=T::input($model->getAttribute("firstname")); ?>
			</td>
			<td><?=T::error(); ?>
			</td>
		</tr>
		<tr>
			<th>Last name</th>
			<td><?=T::input($model->getAttribute("lastname")); ?>
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