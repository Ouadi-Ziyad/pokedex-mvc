📖 Pokédex Interactif (Architecture MVC)
Bienvenue sur le projet Pokédex ! Il s'agit d'un site web interactif qui permet de consulter les informations de tous les Pokémon existants.

Ce projet a été conçu pour être à la fois facile à utiliser pour les visiteurs et bien organisé "sous le capot" pour les développeurs.

✨ Ce que vous pouvez faire sur le site
🔍 Explorer et chercher : Parcourez la liste complète des Pokémon ou utilisez la barre de recherche pour trouver votre préféré rapidement.

📖 Voir les détails : Cliquez sur un Pokémon pour découvrir toutes ses caractéristiques (sa taille, son poids, ses statistiques de combat, ses évolutions et même sa version brillante/"shiny").

⚖️ Comparer : Vous hésitez entre deux Pokémon ? Un outil de comparaison permet de mettre leurs statistiques côte à côte pour voir lequel est le plus fort.

🧠 Comment ça marche sous le capot ? (Explications simples)
Ce projet utilise deux concepts clés en informatique : l'API et l'architecture MVC. Voici une explication simple de ce que cela signifie.

1. Les données (L'API Tyradex)
Le site ne stocke aucune information sur les Pokémon directement dans ses dossiers. À la place, il va "poser la question" en direct à une immense base de données publique sur internet appelée Tyradex API. C'est comme si notre site consultait une grande encyclopédie en ligne à chaque fois que vous cliquez sur un Pokémon.

2. L'organisation du code (MVC)
Le code du site est rangé selon une méthode appelée MVC (Modèle, Vue, Contrôleur). Imaginez que notre site est un restaurant :

Le Modèle (Le Cuisinier) : C'est lui qui gère la "nourriture" (les données). Quand on a besoin des infos de Pikachu, le Modèle va les chercher dans l'encyclopédie (l'API) et les prépare.

La Vue (La Présentation de l'assiette) : C'est ce que vous voyez à l'écran. La Vue prend les données brutes préparées par le cuisinier et les rend jolies (avec des images, des couleurs, des tableaux).

Le Contrôleur (Le Serveur) : C'est lui qui fait le lien. Quand vous cliquez sur "Voir Pikachu", vous parlez au Contrôleur. Il va voir le Modèle en disant "Prépare-moi les infos de Pikachu", puis il donne ces infos à la Vue en disant "Mets ça en page pour le client".

🛠️ Comment lancer le projet chez vous ?
Pour que le site fonctionne sur n'importe quel ordinateur sans avoir à installer des dizaines de logiciels complexes, nous utilisons un outil appelé Docker. C'est une sorte de "boîte magique" qui contient tout ce dont le site a besoin pour fonctionner, y compris la bonne version du langage de programmation (PHP 8.4).

Si vous avez Docker installé sur votre ordinateur, voici les étapes :

Ouvrez un terminal (invite de commande) dans le dossier de ce projet.

Tapez la commande suivante :

Bash
docker-compose up -d
Ouvrez votre navigateur internet et allez à l'adresse suivante : http://localhost:8000

Profitez de votre Pokédex !

🤝 Crédits
Données : Toutes les informations et images des Pokémon proviennent de l'excellente API Tyradex (https://tyradex.app/).

Design : L'apparence visuelle claire et moderne est réalisée grâce à PicoCSS, un outil qui rend les sites élégants très facilement.

Pokémon et tous les noms respectifs sont des marques déposées de The Pokémon Company International.
