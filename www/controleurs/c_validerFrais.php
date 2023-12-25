<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);

$mois = getMois(date('d/m/Y'));
switch ($action) {
    case 'Choisirlevisiteur':
        $lesVisiteurs = $pdo->getLesVisiteursDisponibles();
        // Afin de sélectionner par défaut le dernier mois dans la zone de liste
        // on demande toutes les clés, et on prend la première,
        // les mois étant triés décroissants
        $lesCles[] = array_keys($lesVisiteurs);
        $moisASelectionner = $lesCles[0];
        $lesMois = getLesDouzeDerniersMois($mois);
        include 'vues/v_listemoisC.php';
        break;
    case 'validerFrais':

        $idVisiteur = filter_input(INPUT_POST, 'lstVisiteur', FILTER_SANITIZE_STRING);
        $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
        $visiteur = $pdo->getLesVisiteursDisponibles();
        var_dump($idVisiteur);
        // Afin de sélectionner par défaut le dernier mois dans la zone de liste
        // on demande toutes les clés, et on prend la première,
        // les mois étant triés décroissants
        $visiteurASelectionner = $idVisiteur;
        $moisASelectionner = $leMois;
        $mois = getMois(date('d/m/Y'));
        $lesMois = getLesDouzeDerniersMois($mois);
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $leMois);
        $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $leMois);
        if (empty($lesFraisForfait) && (empty($lesFraisHorsForfait))) {
            ajouterErreur('Pas de fiche de frais pour ce visiteur ce mois');
            include 'vues/v_erreurs.php';
            header("Refresh: 2;URL=index.php?uc=validerFrais&action=Choisirlevisiteur");
        } else {
            include 'vues/v_validerFrais.php';
        }
        break;
    case 'corrigerFrais':
        $lesFrais = filter_input(INPUT_POST, 'lesFrais', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
        $idVisiteur = filter_input(INPUT_POST, 'lstVisiteur', FILTER_SANITIZE_STRING);
        $moisSelectionneC = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
        $visiteur = $pdo->getLesVisiteursDisponibles();
        $visiteurASelectionner = $idVisiteur;
        $moisASelectionner = $moisSelectionneC;
        $moisActuelle = getMois(date('d/m/Y'));
        $lesMois = getLesDouzeDerniersMois($moisActuelle);
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur,$moisSelectionneC);
        if (lesQteFraisValides($lesFrais)) {
            $pdo->majFraisForfait($idVisiteur, $moisSelectionneC, $lesFrais);
            $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $moisSelectionneC);
            include 'vues/v_validerFrais.php';
        } else {
            ajouterErreur('Les valeurs des frais doivent être numériques');
            include 'vues/v_erreurs.php';
        }
        break;
    case 'corrigerFrais2':
        if (isset($_POST['corrigerFHF'])) {
           $lesFrais = filter_input(INPUT_POST, 'lesFrais', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
        $idVisiteur = filter_input(INPUT_POST, 'lstVisiteur', FILTER_SANITIZE_STRING);
        $moisSelectionneC = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
        $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING);
        $libelle = filter_input(INPUT_POST, 'libelle', FILTER_SANITIZE_STRING);
        $montant = filter_input(INPUT_POST, 'montant', FILTER_SANITIZE_STRING);
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
        $visiteur = $pdo->getLesVisiteursDisponibles();
        $visiteurASelectionner = $idVisiteur;
        $moisASelectionner = $moisSelectionneC;
        $moisActuelle = getMois(date('d/m/Y'));
        $lesMois = getLesDouzeDerniersMois($moisActuelle);
        $pdo->majFraisHorsForfait($date, $libelle, $montant,$id, $idVisiteur, $moisSelectionneC);
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur,$moisSelectionneC);
        $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $moisSelectionneC);
        include 'vues/v_validerFrais.php';
        }
        elseif (isset($_POST['supprimerFHF'])) {
        $idVisiteur = filter_input(INPUT_POST, 'lstVisiteur', FILTER_SANITIZE_STRING);
        $moisSelectionneC = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
        $visiteur = $pdo->getLesVisiteursDisponibles();
        $visiteurASelectionner = $idVisiteur;
        $moisActuelle = getMois(date('d/m/Y'));
        $lesMois = getLesDouzeDerniersMois($moisActuelle);
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur,$moisSelectionneC);
        $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $moisSelectionneC);
        //$pdo->supprimerFraisHorsForfait($id);
        var_dump($id);
        include 'vues/v_validerFrais.php';
        
        }
        elseif (isset($_POST['reporterFHF'])) {
        $idVisiteur = filter_input(INPUT_POST, 'lstVisiteur', FILTER_SANITIZE_STRING);
        $moisSelectionneC = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
        $visiteur = $pdo->getLesVisiteursDisponibles();
        $visiteurASelectionner = $idVisiteur;
        $moisActuelle = getMois(date('d/m/Y'));
        $lesMois = getLesDouzeDerniersMois($moisActuelle);
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur,$moisSelectionneC);
        $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $moisSelectionneC);
        include 'vues/v_validerFrais.php';
        
        }

        break;
}
    