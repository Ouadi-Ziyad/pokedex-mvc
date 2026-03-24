<?php

/**
 * Modèle Pokémon
 * 
 * Cette classe gère toutes les interactions avec l'API Tyradex.
 * Elle contient la logique d'accès aux données (requêtes cURL,
 * décodage JSON, filtrage, recherche).
 */
class PokemonModel
{
    /**
     * URL de base de l'API Tyradex
     */
    private string $apiBase = 'https://tyradex.app/api/v1';

    /**
     * Effectue une requête GET vers l'API Tyradex avec cURL
     * 
     * @param string $url L'URL complète à appeler
     * @return array|null Les données décodées ou null en cas d'erreur
     */
    private function appelApi(string $url): ?array
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'User-Agent: PokedexBTS-MVC',
            'Content-type: application/json',
        ]);

        $reponse = curl_exec($ch);
        $codeHttp = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($codeHttp !== 200 || $reponse === false) {
            return null;
        }

        return json_decode($reponse, true);
    }

    /**
     * Récupère la liste de tous les Pokémon
     * 
     * @return array La liste des Pokémon (filtrée des entrées vides)
     */
    public function getTous(): array
    {
        $donnees = $this->appelApi($this->apiBase . '/pokemon');

        if ($donnees === null) {
            return [];
        }

        return array_filter($donnees, function ($pokemon) {
            return isset($pokemon['pokedex_id']) && $pokemon['pokedex_id'] > 0;
        });
    }

    /**
     * Récupère les détails d'un Pokémon par son ID ou son nom
     * 
     * @param int|string $identifiant L'ID ou le nom du Pokémon
     * @return array|null Les données du Pokémon ou null si non trouvé
     */
    public function getParId($identifiant): ?array
    {
        return $this->appelApi($this->apiBase . '/pokemon/' . urlencode($identifiant));
    }

    /**
     * Recherche des Pokémon par nom français dans une liste
     * 
     * @param string $recherche Le terme de recherche
     * @param array $liste La liste complète des Pokémon
     * @return array Les Pokémon correspondants
     */
    public function rechercher(string $recherche, array $liste): array
    {
        $recherche = mb_strtolower($recherche);

        return array_filter($liste, function ($pokemon) use ($recherche) {
            $nom = mb_strtolower($pokemon['name']['fr'] ?? '');
            return str_contains($nom, $recherche);
        });
    }
}
