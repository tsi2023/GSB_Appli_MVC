<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
$lesVisiteurs = $pdo->getLesVisiteursVA();
$idVisiteur = filter_input(INPUT_POST, 'lstVisiteur', FILTER_SANITIZE_STRING);
$leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);

switch ($action) {
    case 'suivrelepaiementdesfichesdeFrais':
        $lesVisiteurs = $pdo->getLesVisiteursVA();
        $lesmois = $pdo->getLesMoisVA();

        $lesCles[] = array_keys($lesVisiteurs);
        $moisASelectionner = $lesCles[0];
        include 'vues/v_suivrePaiement.php';
        break;
    case 'etatSuivrePaiement':
        echo 'coucou';
        $lesMois = $pdo->getLesMoisDisponibles($idVisiteur);
        $moisASelectionner = $leMois;
        $visiteurASelectionner = $idVisiteur ;
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $leMois);
        $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $leMois);
        $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur, $leMois);
        $numAnnee = substr($leMois, 0, 4);
        $numMois = substr($leMois, 4, 2);
        $libEtat = $lesInfosFicheFrais['libEtat'];
        $montantValide = $lesInfosFicheFrais['montantValide'];
        $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
        $dateModif = dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);
        include 'vues/v_nouveauxFrais_c.php';
        break;
    case 'Rembourser':
        var_dump($idVisiteur, $leMois);
        $rep = $pdo->majEtatFicheFrais($idVisiteur, $leMois, "RB");
        include 'vues/v_accueil_c.php';
        break;
}
    
