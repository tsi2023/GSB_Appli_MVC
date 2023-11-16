<?php
/**
 * Vue Liste des mois
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Réseau CERTA <contact@reseaucerta.org>
 * @author    José GIL <jgil@ac-nice.fr>
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.reseaucerta.org Contexte « Laboratoire GSB »
 */
?>
<h2>Mes fiches de frais</h2>
<form action="index.php?uc=validerFrais&action=validerFrais" 
      method="post" role="form">
 <div class="row">
        <div class="col-md-4">
            <h3>Choisir un visteur : </h3>
        
        
            <div class="form-group">
                <label for="lstMois" accesskey="n">Visiteur : </label>
                <select id="lstMois" name="lstVisiteur" class="form-control">
                    <?php
                    foreach ($lesVisiteurs as $unVisiteur) {
                        $idVisiteur = $unVisiteur['id'];
                        $nomVisiteur = $unVisiteur['nom'];
                        $prenomVisiteur = $unVisiteur['prenom'];
                        if ($idVisiteur == $visiteurASelectionner) {
                            ?>
                            <option selected value="<?php echo $idVisiteur ?>">
                                <?php echo $nomVisiteur . ' ' . $prenomVisiteur ?> </option>
                            <?php
                        } else {
                            ?>
                            <option value="<?php echo $idVisiteur ?>">
                                <?php echo $nomVisiteur . ' ' . $prenomVisiteur ?> </option>
                            <?php
                        }
                    }
                    ?>    

                </select>
            </div>
            </div>
            <div class="col-md-4">
                 <h3>Choisir un mois : </h3>
      
        
            <div class="form-group">
                <label for="lstMois" accesskey="n">Mois : </label>
                <select id="lstMois" name="lstMois" class="form-control">
                    <?php
                    foreach ($lesMois as $unMois) {
                        $mois = $unMois['mois'];
                        $numAnnee = $unMois['numAnnee'];
                        $numMois = $unMois['numMois'];
                        if ($mois == $moisASelectionner) {
                            ?>
                            <option selected value="<?php echo $mois ?>">
                                <?php echo $numMois . '/' . $numAnnee ?> </option>
                            <?php
                        } else {
                            ?>
                            <option value="<?php echo $mois ?>">
                                <?php echo $numMois . '/' . $numAnnee ?> </option>
                            <?php
                        }
                    }
                    ?>   
                </select>    
            </div>
                 </div>
        </div>
     <input id="ok" type="submit" value="Valider" class="btn btn-success" 
            role="button"></br></br>
     <input id="annuler" type="reset" value="Effacer" class="btn btn-danger" 
                       role="button">
       </div>
    <div></div>
</form>
