<?php T::setEditable(false); ?>

<h1>View OTPW</h1>

<form method="POST">
<table>
		<tr>
			<th>ID</th>
			<td><?=T::input($model->getAttribute("id")); ?>
			</td>
		</tr>
		<tr>
			<th>User name</th>
			<td><?=T::input($model->getAttribute("username")); ?>
			</td>
		</tr>
		<tr>
			<th>Password</th>
			<td><?=T::input($model->getAttribute("password")); ?>
			</td>
		</tr>
		<tr>
			<th>First name</th>
			<td><?=T::input($model->getAttribute("firstname")); ?>
			</td>
		</tr>
		<tr>
			<th>Last name</th>
			<td><?=T::input($model->getAttribute("lastname")); ?>
			</td>
		</tr>
</table>
</form>

<a href="<?=T::href("advisor", "edit", array("id" => $model->getValue("id"))); ?>">Edit</a>
<a href="<?=T::href("advisor", "delete", array("id" => $model->getValue("id"))); ?>">Delete</a>