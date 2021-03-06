<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ProjetLecteur\Vue;

/**
 * Description of MusiqueView
 *  Retourner le code HTML de l'affichage d'une musique 
 * @author alexd
 */
class MusiqueView {
    
    
    public static function getHTMLMusiqueRow($musique,$sanitizePolicy= \ProjetLecteur\Controleur\ValidationUtils::SANITIZE_POLICY_ESCAPE_ENTITIES){ 
        if (\ProjetLecteur\Metier\MusiqueValidation::filterMusique($musique,false,$sanitizePolicy) === false){ 
            return "Musique Incorrecte"; 
        }
        if ($musique->cheminAudio!=""){ 
            $htmlCode="<td class=\"play\"><audio src=".$musique->cheminAudio."></audio></td>";
        }
        else { 
            $htmlCode="<td>Pas de lien pour écouter</td>"; 
        }
        
        $htmlCode.="<td ><a class=\"titre\" href=\"?action=infos&idMusique=".$musique->idMusique."\">".$musique->titre."</a></td>"; 
        $htmlCode.="<td ><image height=\"50px\" witdh=\"50px\" src=".$musique->couvertureAlbum."></td>"; 
        $htmlCode.="<td><p class=\"periodeMel\">".$musique->periodeMel."</p></td>"; 
        $htmlCode.="<td><p class=\"avpos\" >".$musique->nbavisFavorables."</p></td>"; 
        return $htmlCode; 
    }
    
    
    public static function getHTMLDevelopped($musique,$sanitizePolicy= \ProjetLecteur\Controleur\ValidationUtils::SANITIZE_POLICY_ESCAPE_ENTITIES){  
        if (\ProjetLecteur\Metier\MusiqueValidation::filterMusique($musique,false,$sanitizePolicy) === false){ 
            return "Musique Incorrecte"; 
        }
       
        $htmlCode="<p class=\"titreI\">".$musique->titre."</p>"; 
        if ($musique->nomAuteur!=""){
            $htmlCode.="<p class=\"auteur\"> Auteur : ".$musique->nomAuteur."</p>";
        }
        else { 
            $htmlCode.=""; 
        }
        $htmlCode.="<p><image src=".$musique->couvertureAlbum."></p>"; 
        if (!empty($musique->nomAlbum)){
        $htmlCode.="<p class=\"nomAlbumI\"> Album :".$musique->nomAlbum."</p>";
        }
        else { 
            $htmlCode.=""; 
        }
        
        if ($musique->duree!=""){
            $htmlCode.="<p class=\"duree\">".$musique->duree."secondes</p>";
        }
        else { 
            $htmlCode.=""; 
        }
        if ($musique->anneeParution!=""){
            $htmlCode.="<p class=\"annee\">Sorti en ".$musique->anneeParution."</p>";
        }
        else { 
            $htmlCode.=""; 
        }
        return $htmlCode; 
    } 
    
    public static function getHTMLInfosAdmin($musique,$sanitizePolicy= \ProjetLecteur\Controleur\ValidationUtils::SANITIZE_POLICY_ESCAPE_ENTITIES){ 
        if (\ProjetLecteur\Metier\MusiqueValidation::filterMusique($musique,false,$sanitizePolicy) === false){ 
            return "Musique Incorrecte"; 
        }
       
        $htmlCode="<p class=\"titreI\">".$musique->titre."</p>"; 
        if ($musique->nomAuteur!=""){
            $htmlCode.="<p class=\"auteur\"> ".$musique->nomAuteur."</p>";
        }
        else { 
            $htmlCode.=""; 
        }
        $htmlCode.="<p><image src=".$musique->couvertureAlbum."></p>"; 
        if (!empty($musique->nomAlbum)){
        $htmlCode.="<p class=\"nomAlbumI\"> Album :".$musique->nomAlbum."</p>";
        }
        else { 
            $htmlCode.=""; 
        }
        
        if ($musique->duree!=""){
            $htmlCode.="<p class=\"duree\">".$musique->duree."secondes</p>";
        }
        else { 
            $htmlCode.=""; 
        }
        if ($musique->anneeParution!=""){
            $htmlCode.="<p class=\"annee\">".$musique->anneeParution."</p>";
        }
        else { 
            $htmlCode.=""; 
        }
        $htmlCode.="<p class=\"periodeMelI\">Mise en ligne le : ".$musique->periodeMel."</p>"; 
        $htmlCode.="<table class=\"avis\">";
        $htmlCode.="<th>Avis positifs </th>"; 
        $htmlCode.="<th>Avis Indifférents </th>"; 
        $htmlCode.="<th >Avis Défavorables </th>";
        $htmlCode .="<tr>"; 
        $htmlCode.="<td>".$musique->nbavisFavorables."</td>";
        $htmlCode.="<td>".$musique->nbavisIndifferents."</td>";
        $htmlCode.="<td>".$musique->nbavisDefavorables."</td>";
        $htmlCode.="</tr>"; 
        $htmlCode.="<tr>"; 
        $htmlCode.="<td><form action=\"?action=jaime&idMusique=".$musique->idMusique."\" method=\"post\"><input type=\"submit\" value=\"+\"/></form></td>"; 
        $htmlCode.="<td><form action=\"?action=indiffere&idMusique=".$musique->idMusique."\" method=\"post\"><input type=\"submit\" value=\"+\"/></form></td>";
        $htmlCode.="<td><form action=\"?action=jaimepas&idMusique=".$musique->idMusique."\" method=\"post\"><input type=\"submit\" value=\"+\"/></form></td>";
        $htmlCode.="</tr></table>";
        $htmlCode.="<div id=\"comment\"  >";
        if (isset($verifTexte)){ 
            $htmlCode.= "<p style=\"color : red; font-size : 12px;\">".$modele->getError()['texte']."</p>"; 
        }
        
        $htmlCode.="<p id=\"ajoutComment\"  >Ajouter un commentaire (200 caractères maximum)</p>";
        $htmlCode.="<form action=\"?action=ajoutComment\" method=\"post\" id=\"formulaire\">";
        $htmlCode.=\ProjetLecteur\Vue\FormManager::addHiddenInput("idCommentaire", "idCommentaire", uniqid()); 
        $htmlCode.=\ProjetLecteur\Vue\FormManager::addHiddenInput("heureInsertion", "heureInsertion", null);  
        $htmlCode.=\ProjetLecteur\Vue\FormManager::addHiddenInput("dateInsertion", "dateInsertion", null);  //pour que l\'index 'dateInsertion' existe 
        $htmlCode.=\ProjetLecteur\Vue\FormManager::addHiddenInput("idMusique", "idMusique", $musique->idMusique); 
        $htmlCode.=\ProjetLecteur\Vue\FormManager::addHiddenInput("login", "login", $_SESSION['email']); 
        $htmlCode.=\ProjetLecteur\Vue\FormManager::addTextArea("", "texte", "textarea", 8, 50, null); 
        $htmlCode.="<button type=\"submit\" >Ajouter</button>";                    
        $htmlCode.="</form></div>";
        $htmlCode.= "<p id=\"affich\">Cliquez pour afficher les commentaires</p>";
        $htmlCode.=  "<div class=\"afficherComms\" id=\"afficherComms\">";
        foreach ($musique->commentaires as $com){ 
            $htmlCode.= CommentaireView::getHtmlCompactAdmin($com); 
                            
        }

        return $htmlCode; 
    }
    
    public static function getHTMLInfosVisitorAuth($musique,$sanitizePolicy= \ProjetLecteur\Controleur\ValidationUtils::SANITIZE_POLICY_ESCAPE_ENTITIES){ 
        if (\ProjetLecteur\Metier\MusiqueValidation::filterMusique($musique,false,$sanitizePolicy) === false){ 
            return "Musique Incorrecte"; 
        }
       
        $htmlCode="<p class=\"titreI\">".$musique->titre."</p>"; 
        if ($musique->nomAuteur!=""){
            $htmlCode.="<p class=\"auteur\"> ".$musique->nomAuteur."</p>";
        }
        else { 
            $htmlCode.=""; 
        }
        $htmlCode.="<p><image src=".$musique->couvertureAlbum."></p>"; 
        if (!empty($musique->nomAlbum)){
        $htmlCode.="<p class=\"nomAlbumI\"> Album :".$musique->nomAlbum."</p>";
        }
        else { 
            $htmlCode.=""; 
        }
        
        if ($musique->duree!=""){
            $htmlCode.="<p class=\"duree\">".$musique->duree."secondes</p>";
        }
        else { 
            $htmlCode.=""; 
        }
        if ($musique->anneeParution!=""){
            $htmlCode.="<p class=\"annee\">".$musique->anneeParution."</p>";
        }
        else { 
            $htmlCode.=""; 
        }
        $htmlCode.="<p class=\"periodeMelI\">Mise en ligne le : ".$musique->periodeMel."</p>"; 
        $htmlCode.="<table class=\"avis\">";
        $htmlCode.="<th>Avis positifs </th>"; 
        $htmlCode.="<th>Avis Indifférents </th>"; 
        $htmlCode.="<th >Avis Défavorables </th>";
        $htmlCode .="<tr>"; 
        $htmlCode.="<td>".$musique->nbavisFavorables."</td>";
        $htmlCode.="<td>".$musique->nbavisIndifferents."</td>";
        $htmlCode.="<td>".$musique->nbavisDefavorables."</td>";
        $htmlCode.="</tr>"; 
        $htmlCode.="<tr>"; 
        $htmlCode.="<td><form action=\"?action=jaime&idMusique=".$musique->idMusique."\" method=\"post\"><input type=\"submit\" value=\"+\"/></form></td>"; 
        $htmlCode.="<td><form action=\"?action=indiffere&idMusique=".$musique->idMusique."\" method=\"post\"><input type=\"submit\" value=\"+\"/></form></td>";
        $htmlCode.="<td><form action=\"?action=jaimepas&idMusique=".$musique->idMusique."\" method=\"post\"><input type=\"submit\" value=\"+\"/></form></td>";
        $htmlCode.="</tr></table>";
        $htmlCode.="<div id=\"comment\"  >";
        if (isset($verifTexte)){ 
            $htmlCode.= "<p style=\"color : red; font-size : 12px;\">".$modele->getError()['texte']."</p>"; 
        }
        
        $htmlCode.="<p id=\"ajoutComment\"  >Ajouter un commentaire (200 caractères maximum)</p>";
        $htmlCode.="<form action=\"?action=ajoutComment\" method=\"post\" id=\"formulaire\">";
        $htmlCode.=\ProjetLecteur\Vue\FormManager::addHiddenInput("idCommentaire", "idCommentaire", uniqid()); 
        $htmlCode.=\ProjetLecteur\Vue\FormManager::addHiddenInput("heureInsertion", "heureInsertion", null);  
        $htmlCode.=\ProjetLecteur\Vue\FormManager::addHiddenInput("dateInsertion", "dateInsertion", null);  //pour que l\'index 'dateInsertion' existe 
        $htmlCode.=\ProjetLecteur\Vue\FormManager::addHiddenInput("idMusique", "idMusique", $musique->idMusique); 
        $htmlCode.=\ProjetLecteur\Vue\FormManager::addHiddenInput("login", "login", $_SESSION['email']); 
        $htmlCode.=\ProjetLecteur\Vue\FormManager::addTextArea("", "texte", "textarea", 8, 50, null); 
        $htmlCode.="<button type=\"submit\" >Ajouter</button>";                    
        $htmlCode.="</form></div>";
        $htmlCode.= "<p id=\"affich\">Cliquez pour afficher les commentaires</p>";
        $htmlCode.=  "<div class=\"afficherComms\" id=\"afficherComms\">";
        foreach ($musique->commentaires as $com){ 
            $htmlCode.= CommentaireView::getHtmlCompactVisitorAuth($com); 
                            
        }

        return $htmlCode; 
    }
}
