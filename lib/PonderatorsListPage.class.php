<?php

/*\
--------------------------------------------
PonderatorsListPage.class.php
--------------------------------------------
Cette classe est destinée à afficher la
page Web. Si une méthode doit renvoyer
du HTML, elle se trouvera sûrement ici.

Patron de conception : singleton.

Pour instancier la WebPage :
PonderatorsListPage::display();
--------------------------------------------
\*/

// On utilise le typage strict
declare (strict_types = 1);

class PonderatorsListPage extends AbstractWebPage {

    /*\
    ----------------------------------------
    Attributs
    ----------------------------------------
    \*/

    private static $PageInstance = null; // PonderatorsListPage

    // Dépendences
    private $dataBase; // DataBase
    private $formProcessor; // DataBase

    // Messages
    const DEL_SUCC = 'Pondérateur supprimé.';
    const DEL_ERR  = 'Problème lors de la suppression.';
    const NEW_POND = 'Nouveau pondérateur ajouté.';

    /*\
    ----------------------------------------
    Méthodes
    ----------------------------------------
    \*/

    /**
     * __construct
     * En private car singleton.
     * @SuppressWarnings(PHPMD.StaticAccess)
     *
     * @return void
     */
    private function __construct() {

        // Dépendances
        $this->dataBase      = DataBase::connect();
        $this->formProcessor = FormProcessor::process();

        // Traitement du formulaire de suppression de pondérateur
        switch ($this->formProcessor->deletePonderator()) {
        case $this->formProcessor::SUCC_CODE:

            // Pondérateur supprimé
            $this->addAlertMessage(self::DEL_SUCC);
            break;

        case $this->formProcessor::ERR_CODE:

            // Erreur
            $this->addAlertMessage(self::DEL_ERR);
            break;
        }
        // retours = 0, pas de traitement

        // Formulaire d'ajour de pondérateur
        if ($this->formProcessor->newPond() === true) {
            $this->addAlertMessage(self::NEW_POND);
        }
    }

    /**
     * display.
     * Instancie la page
     *
     * @return PonderatorsListPage
     */
    public static function display(): PonderatorsListPage {
        if (!self::$PageInstance) {
            self::$PageInstance = new PonderatorsListPage();
        }
        return self::$PageInstance;
    }

    /**
     * getHtmlContent
     *
     * @return string
     */
    public function getHtmlContent(): string {

        // On récupère la liste des pondérateurs
        $ponderators = $this->dataBase->getPonderators();

        $content = '<ul>';
        foreach ($ponderators as $key => $ponderator) {
            $content .= '<li>' . ($key + 1) . ' - ' . htmlspecialchars($ponderator["name"]) . ' (coefficient ' . $ponderator["coefficient"] . ') <a href="?page=ponderators&delete-pond=' . $ponderator["id"] . '">[X]</a></li>';
        }
        $content .= '</ul>';

        $content .= $this->newPonderatorForm();

        return $content;
    }

    /**
     * newPonderatorForm
     *
     * @return string
     */
    public function newPonderatorForm(): string {
        return '
        <form method="post">
            <fieldset>

                <!-- Form Name -->
                <legend>Ajouter un pondérateur</legend>

                <!-- Text input-->
                <div>
                    <label for="ponderator-name">Nom</label>
                    <div>
                        <input name="ponderator-name" type="text" required="">
                    </div>
                </div>

                <!-- Number input-->
                <div>
                    <label control-label" for="coefficient">Coefficient</label>
                    <div>
                        <input name="coefficient" type="number" min="1" max="10" value="1">
                    </div>
                </div>

                <!-- Button -->
                <div>
                    <div>
                        <input type="submit" value="Ajouter">
                    </div>
                </div>

            </fieldset>
        </form>
        ';
    }

    /**
     * getTitle
     *
     * @return string
     */
    public function getTitle(): string {
        return '
            <h1>TODO Organizer</h1>
            <h3>Gérer les pondérateurs</h3>
        ';
    }
}
