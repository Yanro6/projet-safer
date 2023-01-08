<?php

namespace App\Controller;

use App\Entity\Administrateur;
use App\Entity\Bien;
use App\Entity\Porteur;
use App\Repository\BienRepository;
use App\Repository\PorteurRepository;
use Proxies\__CG__\App\Entity\Categorie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Form\Forms;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class InitBddController extends AbstractController{


    /**
    *@Route("/init", name="init")
    */
    public function init(EntityManagerInterface $em)
    {
        # créer entité
        $badmin = new Administrateur();
        $badmin->setEmail("admin@gmail.com");
        $badmin->setLogin("admin");
        $badmin->setMotDePasse("admin");
        $badmin->setNom("admin");
        $badmin->setPrenom("admin");

        $em->persist($badmin);

        $em->flush(); #flush peut être associé à plusieurs persist. Permettant de répercuter plusieurs mises à jour de la BDD en une seule fois.

    }
}

?>