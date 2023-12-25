<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<form action="index.php?uc=validerFrais&action=corrigerFrais" 
      method="post" role="form">
    <div class="row">
        <div class="col-md-4">
            <h3>Choisir un visteur : </h3>


            <div class="form-group">
                <label for="lstMois" accesskey="n">Visiteur : </label>
                <select id="lstMois" name="lstVisiteur" class="form-control">
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

            <fieldset>       
                <?php
                foreach ($lesFraisForfait as $unFrais) {
                    $idFrais = $unFrais['idfrais'];
                    $libelle = htmlspecialchars($unFrais['libelle']);
                    $quantite = $unFrais['quantite'];
                    ?>
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

        </div>
    </div>

</form>
<form action="index.php?uc=validerFrais&action=corrigerFrais2"
      method="post" role="form">
    <input name="lstMois" type="hidden" id="lstMois" class="form-control" value="<?php echo $moisASelectionner ?>">
    <input name="lstVisiteur" type="hidden" id="lstVisiteurs" class="form-control" value="<?php echo $visiteurASelectionner ?>">
<hr>
<div class="row">
    <div class="panel panel-info">
        <div class="panel-heading">Descriptif des éléments hors forfait</div>
        <table class="table table-bordered table-responsive">
            <thead>
                <tr>
                    <th class="date">Date</th>
                    <th class="libelle">Libellé</th>  
                    <th class="montant">Montant</th>  
                    <th class="action">&nbsp;</th> 
                </tr>
            </thead>  
            <tbody>
                <?php
                foreach ($lesFraisHorsForfait as $unFraisHorsForfait) {
                    $libelle = htmlspecialchars($unFraisHorsForfait['libelle']);
                    $date = $unFraisHorsForfait['date'];
                    $montant = $unFraisHorsForfait['montant'];
                    $id = $unFraisHorsForfait['id'];
                    ?>           
                    <tr>
                        <td><input type="text" id="idFrais" 
                               name="date"
                               size="10" maxlength="5" 
                               value="<?php echo $date ?>" 
                               class="form-control"></td>
                        <td><input type="text" id="idFrais" 
                               name="libelle"
                               size="10" maxlength="5" 
                               value="<?php echo $libelle ?>" 
                               class="form-control"></td>
                        <td><input type="text" id="idFrais" 
                               name="montant"
                               size="10" maxlength="5" 
                               value="<?php echo $montant ?>" 
                               class="form-control">
                        <input type="hidden" id="idFrais" 
                               name="id"
                               size="10" maxlength="5" 
                               value="<?php echo $id ?>" 
                               class="form-control"></td>
                        <td>
                            <input id="corrigerFHF" name="corrigerFHF" type="submit" value="Corriger" class="btn btn-success"/>  
                            <input id="supprimerFHF" name="supprimerFHF" type="submit" value="Supprimer" class="btn btn-danger"/>
                            <input id="reporterFHF" name="reporterFHF" type="submit" value="Reporter" class="btn btn-danger" style="background-color: orange"/>
                            </td>
                       
                      <!--<td><a href="index.php?uc=gererFrais&action=supprimerFrais&idFrais=<?php echo $id ?>" 
                              onclick="return confirm('Voulez-vous vraiment supprimer ce frais?');">Supprimer ce frais</a></td> -->
                       
                    </tr>
                    <?php
                }
                ?>
            </tbody>  
        </table>
    </div>
    </div>
</form>
    <div>
                <label for="txtLibelleHF">Nombre de justificatifs</label>             
                <input type="text" id="txtLibelleHF" name="libelle" 
                       class="form-control" id="text">
    </div> 
    </br>
     <button class="btn btn-success" type="submit">Valider</button>
                <button class="btn btn-danger" type="reset">Réinitialiser</button>

