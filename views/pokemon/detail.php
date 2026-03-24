<?php
/**
 * Vue : Détail d'un Pokémon
 * 
 * Variables disponibles (passées par le contrôleur via extract) :
 * - $pokemon : array|null — les données du Pokémon, ou null si non trouvé
 */
?>

<?php if ($pokemon === null): ?>

    <h1>Pokémon non trouvé</h1>
    <p>Le Pokémon demandé n'existe pas.</p>
    <a href="index.php?page=list" role="button">Retour à la liste</a>

<?php else: ?>

    <a href="index.php?page=list">&larr; Retour à la liste</a>

    <article>
        <header>
            <hgroup>
                <h1>
                    #<?= str_pad($pokemon['pokedex_id'], 3, '0', STR_PAD_LEFT) ?>
                    - <?= htmlspecialchars($pokemon['name']['fr'] ?? 'Inconnu') ?>
                </h1>
                <p>
                    <?= htmlspecialchars($pokemon['name']['en'] ?? '') ?>
                    | <?= htmlspecialchars($pokemon['name']['jp'] ?? '') ?>
                    | <?= htmlspecialchars($pokemon['category'] ?? '') ?>
                </p>
            </hgroup>
        </header>

        <div style="display: flex; flex-wrap: wrap; gap: 2rem; align-items: flex-start;">
            <!-- Image -->
            <div style="text-align: center;">
                <img 
                    class="pokemon-detail-img"
                    src="<?= htmlspecialchars($pokemon['sprites']['regular'] ?? '') ?>" 
                    alt="<?= htmlspecialchars($pokemon['name']['fr'] ?? '') ?>"
                >
                <?php if (!empty($pokemon['sprites']['shiny'])): ?>
                    <br>
                    <details>
                        <summary>Version Shiny</summary>
                        <img 
                            class="pokemon-detail-img"
                            src="<?= htmlspecialchars($pokemon['sprites']['shiny']) ?>" 
                            alt="<?= htmlspecialchars($pokemon['name']['fr'] ?? '') ?> shiny"
                        >
                    </details>
                <?php endif; ?>
            </div>

            <!-- Informations -->
            <div style="flex: 1; min-width: 300px;">
                <h3>Types</h3>
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
                    <?php else: ?>
                        <p>Aucun type connu</p>
                    <?php endif; ?>
                </div>

                <h3>Caractéristiques</h3>
                <table>
                    <tr>
                        <th>Taille</th>
                        <td><?= htmlspecialchars($pokemon['height'] ?? '?') ?></td>
                    </tr>
                    <tr>
                        <th>Poids</th>
                        <td><?= htmlspecialchars($pokemon['weight'] ?? '?') ?></td>
                    </tr>
                    <?php if (isset($pokemon['catch_rate'])): ?>
                    <tr>
                        <th>Taux de capture</th>
                        <td><?= $pokemon['catch_rate'] ?></td>
                    </tr>
                    <?php endif; ?>
                    <?php if (!empty($pokemon['egg_groups'])): ?>
                    <tr>
                        <th>Groupes d'oeufs</th>
                        <td><?= htmlspecialchars(implode(', ', $pokemon['egg_groups'])) ?></td>
                    </tr>
                    <?php endif; ?>
                    <?php if (isset($pokemon['sexe'])): ?>
                    <tr>
                        <th>Sexe</th>
                        <td>
                            <?php if ($pokemon['sexe']['male'] == 0 && $pokemon['sexe']['female'] == 0): ?>
                                Asexué
                            <?php else: ?>
                                ♂ <?= $pokemon['sexe']['male'] ?>% | ♀ <?= $pokemon['sexe']['female'] ?>%
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endif; ?>
                </table>

                <?php if (!empty($pokemon['talents'])): ?>
                    <h3>Talents</h3>
                    <ul>
                        <?php foreach ($pokemon['talents'] as $talent): ?>
                            <li>
                                <?= htmlspecialchars($talent['name'] ?? '') ?>
                                <?php if (!empty($talent['tc'])): ?>
                                    <small>(talent caché)</small>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>

        <!-- Statistiques -->
        <?php if (!empty($pokemon['stats'])): ?>
            <h3>Statistiques</h3>
            <?php
            $stats = [
                'hp' => 'PV',
                'atk' => 'Attaque',
                'def' => 'Défense',
                'spe_atk' => 'Atq. Spé.',
                'spe_def' => 'Déf. Spé.',
                'vit' => 'Vitesse',
            ];
            foreach ($stats as $cle => $nom):
                $valeur = $pokemon['stats'][$cle] ?? 0;
            ?>
                <div class="stat-row">
                    <strong><?= htmlspecialchars($nom) ?></strong>
                    <span><?= $valeur ?></span>
                    <progress value="<?= $valeur ?>" max="255"></progress>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <!-- Évolutions -->
        <?php if (!empty($pokemon['evolution'])): ?>
            <h3>Évolutions</h3>
            <?php if (!empty($pokemon['evolution']['pre'])): ?>
                <h4>Pré-évolution(s)</h4>
                <ul>
                    <?php foreach ($pokemon['evolution']['pre'] as $evo): ?>
                        <li>
                            <a href="index.php?page=detail&id=<?= $evo['pokedex_id'] ?>">
                                <?= htmlspecialchars($evo['name']) ?>
                            </a>
                            <small>(<?= htmlspecialchars($evo['condition'] ?? '') ?>)</small>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <?php if (!empty($pokemon['evolution']['next'])): ?>
                <h4>Évolution(s) suivante(s)</h4>
                <ul>
                    <?php foreach ($pokemon['evolution']['next'] as $evo): ?>
                        <li>
                            <a href="index.php?page=detail&id=<?= $evo['pokedex_id'] ?>">
                                <?= htmlspecialchars($evo['name']) ?>
                            </a>
                            <small>(<?= htmlspecialchars($evo['condition'] ?? '') ?>)</small>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Résistances -->
        <?php if (!empty($pokemon['resistances'])): ?>
            <details>
                <summary>Résistances</summary>
                <table>
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Multiplicateur</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pokemon['resistances'] as $resistance): ?>
                            <tr>
                                <td><?= htmlspecialchars($resistance['name'] ?? '') ?></td>
                                <td>
                                    <?php
                                    $mult = $resistance['multiplier'] ?? 1;
                                    if ($mult == 0) {
                                        echo '0 (immunisé)';
                                    } elseif ($mult < 1) {
                                        echo 'x' . $mult . ' (résistant)';
                                    } elseif ($mult > 1) {
                                        echo 'x' . $mult . ' (faible)';
                                    } else {
                                        echo 'x1 (neutre)';
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </details>
        <?php endif; ?>
    </article>

<?php endif; ?>
