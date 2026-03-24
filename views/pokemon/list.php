<?php
/**
 * Vue : Liste des Pokémon
 * 
 * Variables disponibles (passées par le contrôleur via extract) :
 * - $recherche : string — le terme de recherche actuel
 * - $pokemonAffiches : array — la liste des Pokémon à afficher
 */
?>

<h1>Pokédex</h1>

<!-- Formulaire de recherche -->
<form method="get" action="index.php" class="search-form">
    <input type="hidden" name="page" value="list">
    <input 
        type="search" 
        name="q" 
        placeholder="Rechercher un Pokémon..." 
        value="<?= htmlspecialchars($recherche) ?>"
    >
    <button type="submit">Rechercher</button>
    <?php if ($recherche !== ''): ?>
        <a href="index.php?page=list" role="button" class="outline">Effacer</a>
    <?php endif; ?>
</form>

<?php if ($recherche !== ''): ?>
    <p><?= count($pokemonAffiches) ?> résultat(s) pour "<?= htmlspecialchars($recherche) ?>"</p>
<?php endif; ?>

<?php if (empty($pokemonAffiches)): ?>
    <p>Aucun Pokémon trouvé.</p>
<?php else: ?>
    <div class="pokemon-grid">
        <?php foreach ($pokemonAffiches as $pokemon): ?>
            <a href="index.php?page=detail&id=<?= $pokemon['pokedex_id'] ?>" style="text-decoration: none; color: inherit;">
                <article class="pokemon-card">
                    <span class="pokemon-id">#<?= str_pad($pokemon['pokedex_id'], 3, '0', STR_PAD_LEFT) ?></span>
                    <br>
                    <img 
                        src="<?= htmlspecialchars($pokemon['sprites']['regular'] ?? '') ?>" 
                        alt="<?= htmlspecialchars($pokemon['name']['fr'] ?? 'Inconnu') ?>"
                        loading="lazy"
                    >
                    <h4><?= htmlspecialchars($pokemon['name']['fr'] ?? 'Inconnu') ?></h4>
                    <div>
                        <?php if (!empty($pokemon['types'])): ?>
                            <?php foreach ($pokemon['types'] as $type): ?>
                                <span class="type-badge">
                                    <?php if (!empty($type['image'])): ?>
                                        <img src="<?= htmlspecialchars($type['image']) ?>" alt="<?= htmlspecialchars($type['name'] ?? '') ?>" width="20" height="20">
                                    <?php endif; ?>
                                    <?= htmlspecialchars($type['name'] ?? '') ?>
                                </span>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </article>
            </a>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
