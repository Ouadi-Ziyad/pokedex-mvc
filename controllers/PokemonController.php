<?php

/**
 * Contrôleur Pokémon
 * 
 * Cette classe reçoit les requêtes depuis le routeur (index.php),
 * utilise le modèle pour récupérer les données,
 * puis charge la vue appropriée en lui passant les variables nécessaires.
 */
class PokemonController
{
    /**
     * Instance du modèle Pokémon
     */
    private PokemonModel $model;

    /**
     * Constructeur : reçoit le modèle en paramètre
     * 
     * @param PokemonModel $model Le modèle pour accéder aux données
     */
    public function __construct(PokemonModel $model)
    {
        $this->model = $model;
    }

    /**
     * Charge un fichier de vue en lui rendant disponibles les variables passées
     * 
     * @param string $vue Le chemin de la vue (relatif au dossier views/)
     * @param array $donnees Les variables à rendre accessibles dans la vue
     */
    private function afficherVue(string $vue, array $donnees = []): void
    {
        // extract() transforme les clés du tableau en variables
        // Ex: ['titre' => 'Accueil'] crée une variable $titre = 'Accueil'
        extract($donnees);

        require 'views/layout/header.php';
        require 'views/' . $vue . '.php';
        require 'views/layout/footer.php';
    }

    /**
     * Action : afficher la liste des Pokémon (avec recherche)
     */
    public function list(): void
    {
        $recherche = $_GET['q'] ?? '';
        $tousLesPokemon = $this->model->getTous();

        if ($recherche !== '') {
            $pokemonAffiches = $this->model->rechercher($recherche, $tousLesPokemon);
        } else {
            $pokemonAffiches = $tousLesPokemon;
        }

        $this->afficherVue('pokemon/list', [
            'titre_page' => 'Liste des Pokémon',
            'recherche' => $recherche,
            'pokemonAffiches' => $pokemonAffiches,
        ]);
    }

    /**
     * Action : afficher la fiche détaillée d'un Pokémon
     */
    public function detail(): void
    {
        $id = $_GET['id'] ?? null;

        if ($id === null) {
            header('Location: index.php');
            exit;
        }

        $pokemon = $this->model->getParId($id);

        if ($pokemon === null || (isset($pokemon['status']) && $pokemon['status'] === 404)) {
            $this->afficherVue('pokemon/detail', [
                'titre_page' => 'Pokémon non trouvé',
                'pokemon' => null,
            ]);
            return;
        }

        $this->afficherVue('pokemon/detail', [
            'titre_page' => $pokemon['name']['fr'] ?? 'Détail',
            'pokemon' => $pokemon,
        ]);
    }

    /**
     * Action : comparer deux Pokémon
     */
    public function compare(): void
    {
        $id1 = $_GET['id1'] ?? '';
        $id2 = $_GET['id2'] ?? '';

        $pokemon1 = null;
        $pokemon2 = null;

        if ($id1 !== '') {
            $pokemon1 = $this->model->getParId($id1);
        }
        if ($id2 !== '') {
            $pokemon2 = $this->model->getParId($id2);
        }

        $this->afficherVue('pokemon/compare', [
            'titre_page' => 'Comparer deux Pokémon',
            'id1' => $id1,
            'id2' => $id2,
            'pokemon1' => $pokemon1,
            'pokemon2' => $pokemon2,
        ]);
    }
}
