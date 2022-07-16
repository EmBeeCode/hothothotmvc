<main>
    <section>
        <h2><?= $head_title ?></h2>
        <ul aria-label="liste de capteurs">

            <?php foreach ($sensors as $sensor) : ?>
                <li>
                    <h3>
                        <?= $sensor['db_data']['name'] ?>
                    </h3>

                    <span class="thermo-icon" aria-label="icône thermomètre">&#127777;</span> <!-- thermometer icon -->

                    <span class="sensor-value">
                        <?= $sensor['api_data']['Valeur'] ?><sup>°C</sup>
                    </span>

                    <div class="buttons-container">
                        <form action="index.php?ctrl=sensors&action=edit&id=<?= $sensor['db_data']['id'] ?>" method="post">
                            <button class="button button-edit">Editer</button>
                        </form>
                        <form action="index.php?ctrl=sensors&action=delete&id=<?= $sensor['db_data']['id'] ?>" method="post">
                            <button class="button button-delete">Supprimer</button>
                        </form>
                    </div>

                </li>
            <?php endforeach ?>

        </ul>

        <form action="index.php?ctrl=sensors&action=creation" method="post">
            <button class="button button-add">Ajouter capteur</button>
        </form>
        <form action="index.php?ctrl=sensors&action=store" method="post">
            <button class="button button-store">Sauvegarder données</button>
        </form>

    </section>
    <section>
        <h2>Graphique des températures</h2>
        <table>
            <tr>
                <th>Capteur</th>
                <th>Date</th>
                <th>Température</th>
            </tr>
            <?php foreach ($sensors_history as $sensor_history) : ?>
                <tr>
                    <td><?= $sensor_history['name'] ?></td>
                    <td><?= $sensor_history['timestamp'] ?></td>
                    <td><?= $sensor_history['value'] ?></td>
                </tr>
            <?php endforeach ?>
        </table>


    </section>


</main>