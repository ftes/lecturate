<?php T::setEditable(false); ?>

<h1>Vorlesung anzeigen</h1>

<form method="POST">
<table>
		<tr>
			<th>ID</th>
			<td><?=T::input($model->getAttribute("id")); ?>
			</td>
		</tr>
		<tr>
			<th>Kürzel</th>
			<td><?=T::input($model->getAttribute("token")); ?>
			</td>
		</tr>		
		<tr>
			<th>Name</th>
			<td><?=T::input($model->getAttribute("name")); ?>
			</td>
		</tr>
</table>
<?=T::iconButton(T::EDIT, "Bearbeiten", "lecture", "edit", array("id"=>$model->getValue("id"))); ?>
<?=T::iconButton(T::DELETE, "Löschen", "lecture", "delete", array("id"=>$model->getValue("id"))); ?>
</form>