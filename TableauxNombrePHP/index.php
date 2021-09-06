<?php
   function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data); 
      return htmlspecialchars($data);
    } 
 
 
   function myIsNumeric($char) {
      for ($i=0; isset($char[$i]); $i++) { 
         if (!($char[$i]>='0' && $char[$i]<='9')){
             return false;
        }
     }
    return ($char>0);
  }
?>
<!DOCTYPE HTML>  
<html lang="fr">
<head>
<title>Exercice - Tableaux</title>
<style>
.error {color: #FF0000;}
body{text-align: center;}
</style>
</head>
<body>  

<?php
// définir les variables et définir des valeurs vides
$N = "";
$mot = "";
$formvalid = false;
$nombre = "";
$t = 1;
$p = 2;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["N"]) && $_POST['N']!='0') {
    $errors['N'] = "Veuillez remplir ce champ.";
  } else {
    $N = test_input($_POST["N"]);
    if (!(myIsNumeric($N))) {
      $errors['N'] = "Le nombre doit être un entier positif.";
    } else {
        $formvalid=true;
    }
  }
}
if (isset($_POST['submit']) && $_POST['submit'] == 'Envoyer') {
  for ($i=0; $i < $N; $i++) {
    if (empty($_POST['mot'.$i])) {
      $errors['mot'.$i] = "Veuillez remplir ce champ.";
    } else {
      $mot = test_input($_POST["mot".$i]);
      if(($mot)<0) {
        $errors['mot'.$i] = "Un nombre doit etre positif.";
      } else {
        if (!(myIsNumeric($mot))) {
          $errors['mot'.$i] = "Un nombre ne doit contenir des lettres.";
        }
      }
    }
  }
}
?>

<h2>Exercice: Tableaux</h2>
<p><span class="error">* champ obligatoire</span></p>
<p>Saisissez la taile N du tableau que vous souhaitez saisir. N doit être un nombre entier.</p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
    Entrer N : <input type="text" name="N" value="<?= $N ?>">
    <span class="error">* <?php if(!empty($errors['N'])){echo $errors['N'];} ?></span>
    <br><br>
    <input type="submit" name="generate" value="Saisir le tableau">
    <br><br> 
    <?php
        if($formvalid) {
            for ($i=0; $i < $N; $i++) { 
    ?>
    <?php echo 'Nombre N°'.($i+1); ?> : <input type="text" name="mot<?= $i ?>" value="<?php if (isset($_POST['mot'.$i])) {echo $_POST['mot'.$i];}?>">
    <span class="error">* <?php if(!empty($errors['mot'.$i])){echo $errors['mot'.$i];} ?></span><br>
    <br><br>
    <?php
            }
    ?>
    <input type="submit" name="submit" value="Envoyer">
    <!-- <input type="submit" name="submit" value="Modifier"> -->
    <?php
        }
    ?>

      <?php
        if (isset($_POST['submit']) && empty($errors) && $_POST['submit'] == 'Envoyer'){
          ?>
           <input type="submit" name="submit" value="Modifier">
           <?php
        }
     ?>

    <?php
      if (isset($_POST['submit']) && empty($errors) && $_POST['submit'] == 'Modifier') {
       
       echo "<h2>Faire des modifications du tableau</h2>";
       ?>
       <?php echo 'Entrer la position'; ?> : <input type="text" name="nombre<?= $t ?>" value="<?php if (isset($_POST['nombre'.$t])) {echo $_POST['nombre'.$t];}?>">
       <?php echo 'Entrer la valeur'; ?> : <input type="text" name="nombre<?= $p ?>" value="<?php if (isset($_POST['nombre'.$p])) {echo $_POST['nombre'.$p];}?>">
  
       <input type="submit" name="submit" value="Valider">
       <?php
       }
        if (isset($_POST['submit']) && empty($errors) && $_POST['submit'] == 'Valider'){
          $t = $_POST['nombre'.$t];
          $p = $_POST['nombre'.$p];

          echo "<h2>Voici les nombres du nouveau tableau</h2>";
          for ($i=0; $i < $t; $i++) { 
            echo "<h4>".$_POST['mot'.$i]."</h4>";
           }
          echo "<h4>".$p."</h4>";
          for ($i=$t+1; $i < $N; $i++) { 
           echo "<h4>".$_POST['mot'.$i]."</h4>";
          }
        }
      ?>

</form>

<?php
 if (isset($_POST['submit']) && empty($errors) && $_POST['submit'] == 'Envoyer') {
    echo "<h2>Voici les nombre dans l'ordre de saisie</h2>";
    for ($i=0; $i < $N; $i++) { 
        echo "<h4>".$_POST['mot'.$i]."</h4>";
    }
 }
?>

<?php
  if (isset($_POST['submit']) && empty($errors) && $_POST['submit'] == 'Envoyer') {
    echo "<h2>Voici les nombre saisie dans l'ordre de croissant</h2>";
    for ($i=0; $i < $N; $i++) { 
      $tmp=0;
      $imin = $i;
      $min = $_POST['mot'.$i];
      for ($j=$i+1; $j < $N; $j++){
      if ( $_POST['mot'.$j] < $min){
        $min= $_POST['mot'.$j];
        $imin=$j;
        }
        $tmp=$_POST['mot'.$imin];
        $_POST['mot'.$imin]=$_POST['mot'.$i];
        $_POST['mot'.$i]=$tmp;
       }
      }
    for ($i=0; $i < $N; $i++) {
       echo "<h4>".$_POST['mot'.$i]."</h4>";
       }
   }
  ?>

 </body>
</html>