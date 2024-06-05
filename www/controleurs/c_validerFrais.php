<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);


$mois = getMois(date('d/m/Y'));
$lesMois = getLesDouzeDerniersMois($mois);
$idVisiteur = filter_input(INPUT_POST, 'lstVisiteur', FILTER_SANITIZE_STRING);
$visiteurASelectionner = $idVisiteur;
$moisActuelle = getMois(date('d/m/Y'));
$moisSelectionneC = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $moisSelectionneC);
$visiteur = $pdo->getLesVisiteursDisponibles();
$lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $moisSelectionneC);
$lesFrais = filter_input(INPUT_POST, 'lesFrais', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
$moisASelectionner = $moisSelectionneC;

switch ($action) {
    case 'Choisirlevisiteur':
        $lesVisiteurs = $pdo->getLesVisiteursDisponibles();
        // Afin de sélectionner par défaut le dernier mois dans la zone de liste
        // on demande toutes les clés, et on prend la première,
        // les mois étant triés décroissants
        $lesCles[] = array_keys($lesVisiteurs);
        $moisASelectionner = $lesCles[0];
        
        include 'vues/v_listemoisC.php';
        break;
    case 'validerFrais':

       
        $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
        
        var_dump($idVisiteur);
        // Afin de sélectionner par défaut le dernier mois dans la zone de liste
        // on demande toutes les clés, et on prend la première,
        // les mois étant triés décroissants
       
        $moisASelectionner = $leMois;
        $mois = getMois(date('d/m/Y'));
        
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $leMois);
        $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $leMois);
        if (empty($lesFraisForfait) && (empty($lesFraisHorsForfait))) {
            ajouterErreur('Pas de fiche de frais pour ce visiteur ce mois');
            include 'vues/v_erreurs.php';
            header("Refresh: 2;URL=index.php?uc=validerFrais&action=Choisirlevisiteur");
        } else {
             $nbJustificatifs = $pdo->getNbjustificatifs($idVisiteur, $moisSelectionneC);
            include 'vues/v_validerFrais.php';
        }
        break;
    case 'corrigerFrais':
         if (lesQteFraisValides($lesFrais)) {
            $pdo->majFraisForfait($idVisiteur, $moisSelectionneC, $lesFrais);
            
            $nbJustificatifs = $pdo->getNbjustificatifs($idVisiteur, $moisSelectionneC);
             ajouterErreur('Votre modification a bien été pris en compte !');
             include 'vues/v_erreurs.php';
            include 'vues/v_validerFrais.php';
        } else {
            ajouterErreur('Les valeurs des frais doivent être numériques');
            include 'vues/v_erreurs.php';
        }
        break;
    case 'corrigerFrais2':
        if (isset($_POST['corrigerFHF'])) {
            $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING);
            $libelle = filter_input(INPUT_POST, 'libelle', FILTER_SANITIZE_STRING);
            $montant = filter_input(INPUT_POST, 'montant', FILTER_SANITIZE_STRING);
            $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
            $visiteur = $pdo->getLesVisiteursDisponibles();
            $pdo->majFraisHorsForfait($date, $libelle, $montant, $id, $idVisiteur, $moisSelectionneC);
           $nbJustificatifs = $pdo->getNbjustificatifs($idVisiteur, $moisSelectionneC);
            ajouterErreur('Votre modification a bien été pris en compte !');
             include 'vues/v_erreurs.php';
            include 'vues/v_validerFrais.php';
        } elseif (isset($_POST['supprimerFHF'])) {
           $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
            $visiteur = $pdo->getLesVisiteursDisponibles();
            $pdo->supprimerFraisHorsForfait($id);
            var_dump($id);
            ajouterErreur('Votre modification a bien été pris en compte !');
             include 'vues/v_erreurs.php';
            include 'vues/v_validerFrais.php';
        } elseif (isset($_POST['reporterFHF'])) {
             $dateFrais = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING);
            $libelle = filter_input(INPUT_POST, 'libelle', FILTER_SANITIZE_STRING);
            $montant = filter_input(INPUT_POST, 'montant', FILTER_VALIDATE_FLOAT);
            $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
            
            $visiteur = $pdo->getLesVisiteursDisponibles();
            $libelle2 = "reporter".$libelle;
            $mois = getMoisSuivant($moisSelectionneC);
            var_dump($idVisiteur,$mois,$libelle,$dateFrais,$montant);
            if ($pdo->estPremierFraisMois($idVisiteur, $mois)) {
                $pdo->creeNouvellesLignesFrais($idVisiteur, $mois);
             }
            $pdo->creeNouveauFraisHorsForfait($idVisiteur,$mois,$libelle,$dateFrais,$montant);
            //$pdo->creeNouveauFraisHorsForfait($idVisiteur,$mois,$libelle,$dateFrais,$montant);
            $pdo->majFraisHorsForfait($dateFrais, $libelle2, $montant, $id, $idVisiteur, $moisSelectionneC);
            var_dump($moisSelectionneC);
            ajouterErreur('Votre modification a bien été pris en compte !');
             include 'vues/v_erreurs.php';
            include 'vues/v_validerFrais.php';
        }

        break;
         case 'validerTotalFrais':
        var_dump($idVisiteur, $moisSelectionneC);
        $total=$pdo->getFraisForfaitTotal($idVisiteur, $moisSelectionneC);
        $somme1=$total[0][0];
        $total2=$pdo->getFraisHorsForfaitTotal($idVisiteur, $moisSelectionneC);
        $somme2=$total2[0][0];
        var_dump($somme1, $somme2);
        var_dump($total, $total2);
        $totaux=$somme1+$somme2;
        $pdo->InserTotauxFF($totaux, $idVisiteur, $moisSelectionneC);
        var_dump($totaux);
        include 'vues/v_accueil_c.php';
        
         
        break;
}
    