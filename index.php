<?php

/**
 * Point d'entrée unique de l'application (Front Controller)
 * 
 * Toutes les requêtes passent par ce fichier.
 * Il lit le paramètre "page" dans l'URL pour déterminer
 * quelle action du contrôleur appeler.
 */

// Chargement du modèle et du contrôleur
require_once 'models/PokemonModel.php';
require_once 'controllers/PokemonController.php';

// Créer le modèle puis le contrôleur
$model = new PokemonModel();
$controller = new PokemonController($model);

// Lire l'action demandée dans l'URL (par défaut : "list")
$page = $_GET['page'] ?? 'list';

// Router vers la bonne méthode du contrôleur
switch ($page) {
    case 'detail':
        $controller->detail();
        break;

    case 'compare':
        $controller->compare();
        break;

    case 'list':
    default:
        $controller->list();
        break;
}
