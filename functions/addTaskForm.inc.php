<?php

function addTaskForm(){

    // Form created with https://bootsnipp.com/forms

    $form = '
    <form class="form-horizontal">
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
    </form>';

    return $form;

}