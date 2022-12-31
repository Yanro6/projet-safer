<?php

namespace App\Controller;

use App\Entity\Bien;
use App\Repository\BienRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class AccueilController extends AbstractController{
    /**
    *@Route("/accueil", name="accueil")
    */
    public function accueil(BienRepository $bienRepository){
        var_dump($bienRepository->count([]));
        var_dump($bienRepository->find(2)->getTitre());
        var_dump($bienRepository->find(2)->getPrix());
        var_dump($bienRepository->findBy(['cp'=>35000]));
        var_dump($bienRepository->createQueryBuilder('q')
            ->Where('q.cp = 35000')
            ->andWhere('q.prix < 50000')
            ->getQuery()
            ->getResult()
    );

        return $this->render('home.html.twig');
    }

    /**
    *@Route("/accueil2", name="accueil")
    */
    public function accueil2(EntityManagerInterface $em){
        $bien=new Bien();
        $bien->setTitre("bien_2")
            ->setCp(35000)
            ->setPrix(6600);
        $em->persist($bien);
        $em->flush();
        dd("done");
        return $this->render('home.html.twig');
    }
    
}

    ?>