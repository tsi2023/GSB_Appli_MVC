<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<form action="index.php?uc=validerFrais&action=validerFrais" 
      method="post" role="form">
 <div class="row">
        <div class="col-md-4">
            <h3>Choisir un visteur : </h3>
        
        
            <div class="form-group">
                <label for="lstMois" accesskey="n">Visiteur : </label>
                <select id="lstMois" name="lstMois" class="form-control">
                    <?php
                    foreach ($visiteur as $unVisiteur) {
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
<div class="row">    
    <h2>Valider la fiche de frais 
    </h2>
    <h3>Eléments forfaitisés</h3>
    <div class="col-md-4">
        <form method="post" 
              action="index.php?uc=validerFrais&action=validerFrais" 
              role="form">
            <fieldset>       
                <?php
                foreach ($lesFraisForfait as $unFrais) {
                    $idFrais = $unFrais['idfrais'];
                    $libelle = htmlspecialchars($unFrais['libelle']);
                    $quantite = $unFrais['quantite']; ?>
                    <div class="form-group">
                        <label for="idFrais"><?php echo $libelle ?></label>
                        <input type="text" id="idFrais" 
                               name="lesFrais[<?php echo $idFrais ?>]"
                               size="10" maxlength="5" 
                               value="<?php echo $quantite ?>" 
                               class="form-control">
                    </div>
                    <?php
                }
                ?>
                <button class="btn btn-success" type="submit">Corriger</button>
                <button class="btn btn-danger" type="reset">Réinitialiser</button>
            </fieldset>
        </form>
    </div>
</div>

