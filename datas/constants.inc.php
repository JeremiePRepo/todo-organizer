<?php
/*\
 | Datas
\*/
define ('TASKS_FOLDER', 'datas/tasks/');
define ('TASKS_FILES_NAMING_RULES', '/[0-9]+\.txt/');

/*\
 | HTML Parts
\*/
define ('HEAD', '<!DOCTYPE html><html lang="fr"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><meta http-equiv="X-UA-Compatible" content="ie=edge">');
define ('TITLE','TODO Organizer');
define ('BODY', '</head><body>');
define ('FOOTER', '</body></html>');

define ('ADD_TASK_FORM', '
<form class="form-horizontal" method="post">
<fieldset>

<!-- Form Name -->
<legend>Ajouter une tâche</legend>

<!-- Text input-->
<div class="form-group">
    <label class="col-md-4 control-label" for="title">Tâche*</label>  
    <div class="col-md-4">
        <input id="title" name="title" type="text" placeholder="" class="form-control input-md" required="">
        <span class="help-block">*Champ obligatoire</span>  
    </div>
</div>

<!-- Textarea -->
<div class="form-group">
    <label class="col-md-4 control-label" for="comments">Commentaires</label>
    <div class="col-md-4">                     
        <textarea class="form-control" id="comments" name="comments"></textarea>
    </div>
</div>

<!-- Button -->
<div class="form-group">
    <label class="col-md-4 control-label" for="validate"></label>
    <div class="col-md-4">
        <button id="validate" name="validate" class="btn btn-primary">Ajouter</button>
    </div>
</div>

</fieldset>
</form>
');