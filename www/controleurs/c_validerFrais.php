<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
$idComptable = $_SESSION['idComptable'];
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
        $lesFrais = filter_input(INPUT_POST, 'lesFrais', FILTER_SANITIZE_STRING);
        $idVisiteur = filter_input(INPUT_POST, 'idVisiteur', FILTER_SANITIZE_STRING);
        $mois = filter_input(INPUT_POST, 'mois', FILTER_SANITIZE_STRING);
        var_dump($lesFrais, $idVisiteur, $mois)
        if (lesQteFraisValides($lesFrais)) {
            $pdo->majFraisForfait($idVisiteur, $mois, $lesFrais);
        } else {
            ajouterErreur('Les valeurs des frais doivent être numériques');
            include 'vues/v_erreurs.php';
        }
        break;
}
