<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<form action="index.php?uc=suivrePaiement&action=etatSuivrePaiement" 
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
                    foreach ($lesmois as $unMois) {
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
                    </br>
            </br>
            </br>
            </br>
            </br>
            </br>
            </br>
        <div>
     <input id="ok" type="submit" value="Valider" class="btn btn-success center-block" 
            role="button"></br></br>
        </div>
            
</form>