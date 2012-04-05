<table border="0">
<form method="POST">
<tr><th>ID</th><td><?php formElement("id", $modul->getIdDef()); ?></td></tr>
<tr><th>Name</th><td><?php formElement("name", $modul->getNameDef()); ?></td></tr>
<tr><th></th><td><?php submitButton(); ?></td></tr>
<tr><th></th><td><?php quitButton(); ?></td></tr>
</form>
</table>