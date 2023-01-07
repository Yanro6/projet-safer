<?php

namespace App\Controller;

use App\Entity\Porteur;use App\Repository\PorteurRepository;

use Doctrine\Common\Collections\ArrayCollection;
use PhpParser\Node\Expr\BinaryOp\Equal;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController{

    /**
    *@Route("/", name="index")
    */
    function index(){
        return $this->render("accueil.html.twig");
    }

}

?>