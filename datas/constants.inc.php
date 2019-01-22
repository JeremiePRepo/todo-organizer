<?php

/*\
 | Params
\*/

define ('TASKS_FOLDER', 'datas/tasks/');

define ('TASKS_FILES_NAMING_RULES', '/^[0-9]{4}-[0-9]{2}-[0-9]{2}-[0-9]+\.txt$/');

define ('PASSWORD', 'aaaa');

define ('TITLE','TODO Organizer');



/*\
 | HTML Parts
\*/

define ('HEAD', '
    <!DOCTYPE html>
        <html lang="fr">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <meta http-equiv="X-UA-Compatible" content="ie=edge">
                <link rel="stylesheet" href="https://unpkg.com/sakura.css/css/sakura.css" type="text/css">
                <link rel="stylesheet" href="/css/style.css" type="text/css">');

define ('BODY', '</head><body>');

define ('FOOTER', '</body></html>');

// Formulaire d'ajout de tâche
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

    <!-- Multiple Checkboxes -->
    <div class="form-group">
    <label class="col-md-4 control-label" for="categories">Catégorie(s)</label>
    <div class="col-md-4">
    <div class="checkbox">
        <label for="categories-1">
        <input type="checkbox" name="categorie-1" id="categories-1" value="1">
        Travail
        </label>
        </div>
    <div class="checkbox">
        <label for="categories-2">
        <input type="checkbox" name="categorie-2" id="categories-2" value="1">
        Cours
        </label>
        </div>
    <div class="checkbox">
        <label for="categories-3">
        <input type="checkbox" name="categorie-3" id="categories-3" value="1">
        Loisirs
        </label>
        </div>
    <div class="checkbox">
        <label for="categories-4">
        <input type="checkbox" name="categorie-4" id="categories-4" value="1">
        Maison
        </label>
        </div>
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
    </form>');

// Formulaire de connexion
define('CONNECTION_FORM', '
    <form class="form-horizontal" method="post">
        <fieldset>

        <!-- Form Name -->
        <legend>Connexion</legend>

        <!-- Password input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="pass">Mot de passe</label>
            <div class="col-md-4">
                <input id="pass" name="pass" type="password" placeholder="" class="form-control input-md" required="">
                
            </div>
        </div>

        <!-- Multiple Checkboxes (inline) -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="remember"></label>
            <div class="col-md-4">
                <label class="checkbox-inline" for="remember-0">
                    <input type="checkbox" name="remember" id="remember-0" value="1">
                    Se souvenir de moi ?
                </label>
            </div>
        </div>

        <!-- Button -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="connection"></label>
            <div class="col-md-4">
                <button id="connection" name="connection" class="btn btn-primary">Connexion</button>
            </div>
        </div>

        </fieldset>
    </form>');

// Bouton de déconnexion
define('DISCONNECTION_BUTTON','
    <form class="form-horizontal">
        <!-- Button -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="deconnection"></label>
            <div class="col-md-4">
                <button id="deconnection" name="deconnection" class="btn btn-primary">Déconnexion</button>
            </div>
        </div>
    </form>');