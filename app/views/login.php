<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $head_title ?></title>
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <section>
    <form id="login" action="index.php?ctrl=page" method="post">
      <h1>HotHotHot</h1>
      <label for="user">Nom d'utilisateur</label>
      <input id="user" type="text" placeholder="Entrez votre nom" />
      <label for="pass">Mot de passe</label>
      <input id="pass" type="password" placeholder="Entrez votre mot de passe" />
      <button>Se connecter</button>
      <p>Vous n'êtes pas inscrit ?</p>
      <a href="#">Créer un nouveau compte</a>
    </form>
  </section>

  <?php include 'standard/footer.php' ?>
</body>

</html>