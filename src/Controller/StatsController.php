<?php

namespace App\Controller;

use App\Entity\Porteur;use App\Repository\PorteurRepository;

use Doctrine\Common\Collections\ArrayCollection;
use PhpParser\Node\Expr\BinaryOp\Equal;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class StatsController extends AbstractController{

    /**
    *@Route("/stats", name="statistique")
    */
    function stats(PorteurRepository $pr){

        $catBienFav = array( // tableau du nombre de favoris par categorie
            'terrain agricole' => 0, 
            'prairie' => 0, 
            'bois' => 0, 
            'batiments' => 0,
            'exploitations' => 0
        );

        $deptBienFav = array();// tableau du nombre de favoris par departement

        $p = $pr->findall(); // récupérration de tous les Porteurs (de projet)
        
        foreach($p as $unPorteur){
            $bienFav = $unPorteur->getBiens(); // liste des biens favoris
            
            foreach($bienFav as $b){

                # update de la liste par catégorie
                $cat = $b->getCategorie();
                $catBienFav[$cat->getNom()]++; // increment du nombre dans le tableau

                # update de la liste par département
                $dept = $b->getCp(); // departement (code postal) du bien
                $t = $b->getTitre(); // titre du bien
                if(!array_key_exists($dept, $deptBienFav)){
                    $biensFav = array($t => 1); // liste du nombre de fois que le bien apparrait dans un département
                    $deptBienFav[$dept] = $biensFav; // ajout du departement dans le tableau
                }else{
                    if (!array_key_exists($t, $deptBienFav[$dept])) {
                        $deptBienFav[$dept] = array($t => 1); // liste du nombre de fois que le bien apparrait dans un département
                    }else{
                        $deptBienFav[$dept][$t]++; // increment du nombre dans le tableau
                    }
                }
                arsort($deptBienFav[$dept]); // tri par ordre décroissant les biens
            }
            arsort($catBienFav); // tri par ordre décroissant les catégorie
            asort($deptBienFav); // tri par ordre croissant les département
        }

    return $this->render("stats.html.twig",['catBienFav' => $catBienFav, 'deptBienFav' => $deptBienFav] );
    }
    
}

?>