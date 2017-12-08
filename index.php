<?php
$title = 'Accueil';
include_once('./inc/pdo.php');
include_once('./inc/fonctions.php');
session_start();
include_once('./inc/header.php');


$sql = "SELECT * FROM all_movies ORDER BY rand() LIMIT 100";
//
$query = $pdo->prepare($sql);
$query->execute();
$movies = $query->fetchAll();


$errors = array();
$nomTableauSource = array('2000','2001');


if (isset($_GET['log'])) {
  if($_GET['log'] == 'out') {
    session_destroy();
    setcookie('auth', '', time()-3600, '/', 'localhost', false, true);
    header('Location: ./index.php');
  } else { header ('Location: ./index.php');}
}

?>

      <main>

        <div id="buttons">
          <a href="index.php"><button type="button" name="button"> + de films ! </button></a>

          <button type="button" name="button"> Filtres  </button>
            <form  action="index.php" method="post">
              <?php   nouvelInputSQL2($textLabel='Action',$typeInput='checkbox',$nomInput='categ',$placeholder='',$errors) ?>
              <?php   nouveauSelect2($textLabel='Année',$nomSelect='years',$placeholder='???? ',$errors,$nomTableauSource) ?>
              <input type="submit" value="Submit">
            </form>
        </div>



        <div id="flexAffiches">
        <?php
        foreach ($movies as $movie) {
          if (file_exists('posters/' . $movie['id'] . '.jpg')) { ?>
            <div class="affiche">
              <a href="./details.php?movie=<?= $movie['slug'] ?>">  <img class="img" src="posters/<?=$movie['id'] ?>.jpg" alt="<?= $movie['title'] ?>"/> </a>
            </div> <?php
          }
          else { ?>
            <div class="affiche">
              <a href="./details.php?movie=<?= $movie['slug'] ?>">  <div class="img sansimage"><p><?=$movie['title'] ?></p></div> </a>
            </div> <?php
          }
        }
        ?>
        </div>
         ?>





      </main>

<?php
include_once('./inc/footer.php');
?>
