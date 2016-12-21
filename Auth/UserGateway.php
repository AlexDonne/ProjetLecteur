<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ProjetLecteur\Auth;

/**
 * Description of UserGateway
 *
 * @author alexd
 */
class UserGateway {
    public static function getRoleByPassword (&$dataError,$email,$hashedPassword){ 
        $args=array($email); 
        $queryResult= \ProjetLecteur\Persistance\DataBaseManager::getInstance()->prepareAndExecuteQuery
                ('SELECT * FROM admin WHERE login=?', $args);
                
                if ($queryResult !==false){ 
                    if (count($queryResult)==1){ 
                        $row=$queryResult[0];  
                    }
                    if (count($queryResult)!=1 || $row['password'] != $hashedPassword){ 
                        echo $hashedPassword ." NUT ".$row['password']; 
                        $dataError['login']="Adresse email ou mot de passe incorrect"; 
                        return ""; 
                    }
                    return $row['role']; 
                }
                else { 
                    $dataError['login']="Impossible d'accéder à la table des utilisateurs"; 
                    return ""; 
                }
                
    }
    
    public static function createUser (&$dataError,$inputArray){ 
        $inputArray['password']=hash("sha512",$inputArray['password']); 
        $queryResult= \ProjetLecteur\Persistance\DataBaseManager::getInstance()->prepareAndExecuteQueryAssoc('INSERT INTO admin(login,password,role)'
                . ' VALUES (:email,:password,:role)',$inputArray); 
        if ($queryResult===false){
            $dataError['persistance']= "Problème d'exécution de la requête (login peut-être existant)"; 
        }
    }
}
