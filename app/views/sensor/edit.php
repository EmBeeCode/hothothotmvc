<main>
    <section>
        <h2><?= $head_title ?></h2>

        <?php if ($action === 'update') : ?>
            <form action='index.php?ctrl=sensors&action=update&id=<?= $sensor['db_data']['id'] ?>' method='post'>
            <?php elseif ($action === 'create') : ?>
                <form action='index.php?ctrl=sensors&action=create' method='post'>
                <?php endif ?>

                <p>Entrez une adresse https://hothothot.dog</p>
                <label for="url">URL</label>
                <input type="url" name="url" id="url-input"></input>

                <button type="submit">OK</button>
                </form>
                <form action="index.php?ctrl=sensors" method="post">
                    <button>Annuler</button>
                </form>
    </section>
</main>