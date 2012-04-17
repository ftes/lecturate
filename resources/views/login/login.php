<?php T::setEditable(true); ?>

<h1>Anmelden</h1>

<form method="POST">
	<table>
		<tr>
			<th>Benutzername</th>
			<td><?=T::input($model->getAttribute("username")); ?>
			</td>
		</tr>
		<tr>
			<th>Passwort</th>
			<td><input type="password" name="model[password]" />
			</td>
		</tr>
	</table>
	<?=T::button(T::CANCEL, "Abbrechen"); ?>
	<?=T::button(T::SUBMIT, "Anmelden"); ?>
</form>
