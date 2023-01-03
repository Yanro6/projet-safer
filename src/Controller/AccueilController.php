<?php

namespace App\Controller;

use App\Entity\Bien;
use App\Entity\Porteur;
use App\Repository\BienRepository;
use App\Repository\PorteurRepository;
use Proxies\__CG__\App\Entity\Categorie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Forms;
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

        # créer entité
        $bien = new Bien();
        $bien->setTitre("bien_2")
            ->setCp(35000)
            ->setPrix(6600);
        $em->persist($bien);
        $em->flush(); #flush peut être associé à plusieurs persist. Permettant de répercuter plusieurs mises à jour de la BDD en une seule fois.
        $titre = $bien->getTitre();
        echo("entity $titre created,\n");

        # récupérer entité
        $br=$em->getRepository(Bien::class);
        $br->find(2);
        echo ("id 2 got,\n");

        # modifier entité
        $bm = $em->getRepository(Bien::class)->findBy(['titre'=>'bien_2'])[0];
        $bm->setCp(72000);
        $em->flush(); #flush peut être associé à plusieurs persist. Permettant de répercuter plusieurs mises à jour de la BDD en une seule fois.
        echo("entity $titre modified,\n");

        # supprimer entité
        $br = $em->getRepository(Bien::class)->findBy(['titre'=>'bien_2'])[0];
        $em->remove($br);
        $em->flush(); #flush peut être associé à plusieurs persist. Permettant de répercuter plusieurs mises à jour de la BDD en une seule fois.
        echo("entity $titre removed\n");

        return $this->render('home.html.twig');
    }
    

    /**
    *@Route("/init", name="initbddtest")
    */
    public function initbddtest(EntityManagerInterface $em)
    {
        # créer entité
        $bien1 = new Bien();
        $bien2 = new Bien();
        $bien3 = new Bien();
        $cat1 = new Categorie();
        $cat2 = new Categorie();
        $cat3 = new Categorie();
        $cat4 = new Categorie();
        $cat5 = new Categorie();

        $cat1->setNom("terrain agricole");
        $cat2->setNom("prairie");
        $cat3->setNom("bois");
        $cat4->setNom("batiments");
        $cat5->setNom("exploitations");

        $em->persist($cat1);
        $em->persist($cat2);
        $em->persist($cat3);
        $em->persist($cat4);
        $em->persist($cat5);

        $em->flush(); #flush peut être associé à plusieurs persist. Permettant de répercuter plusieurs mises à jour de la BDD en une seule fois.
        
        $n1 = $cat1->getNom();
        $n2 = $cat2->getNom();
        $n3 = $cat3->getNom();
        $n4 = $cat4->getNom();
        $n5 = $cat5->getNom();
        echo("entity categorie $n1, $n2, $n3, $n4, $n5 created,\n");

        
        $bien1->setTitre("bien1")
            ->setCp(35000)
            ->setPrix(6600)
            ->setCategorie($cat1);

        $bien2->setTitre("bien2")
            ->setCp(35000)
            ->setPrix(1000)
            ->setCategorie($cat2);

        $bien3->setTitre("bien3")
        ->setCp(44000)
        ->setPrix(100000)
        ->setCategorie($cat1);
        
        $em->persist($bien1);
        $em->persist($bien2);
        $em->persist($bien3);
    
        $em->flush(); #flush peut être associé à plusieurs persist. Permettant de répercuter plusieurs mises à jour de la BDD en une seule fois.
        
        $cat1 = $em->getRepository(Categorie::class)->findBy(['nom'=>'terrain agricole'])[0];
        $cat2 = $em->getRepository(Categorie::class)->findBy(['nom'=>'prairie'])[0];

        $cat2->addBien($bien2);
        $cat1->addBien($bien1);
        $cat1->addBien($bien3);
        
        $em->persist($cat1);
        $em->persist($cat2);

        $t1 = $bien1->getTitre();
        $t2 = $bien2->getTitre();
        $t3 = $bien3->getTitre();
        echo("entity bien $t1, $t2, $t3 created,\n");

        $p1 = new Porteur();
        $p2 = new Porteur();
        $p3 = new Porteur();

        $p1->addBien($bien1);
        $p1->addBien($bien2);
        $p2->addBien($bien1);
        $p2->addBien($bien3);
        $p3->addBien($bien1);
        $p3->addBien($bien3);

        $em->persist($p1);
        $em->persist($p2);
        $em->persist($p3);
        $em->flush(); #flush peut être associé à plusieurs persist. Permettant de répercuter plusieurs mises à jour de la BDD en une seule fois.


        $bien1 = $em->getRepository(Bien::class)->findBy(['titre'=>'bien1'])[0];
        $bien2 = $em->getRepository(Bien::class)->findBy(['titre'=>'bien2'])[0];
        $bien3 = $em->getRepository(Bien::class)->findBy(['titre'=>'bien3'])[0];
        $bien1->addPorteur($p1);
        $bien1->addPorteur($p2);
        $bien1->addPorteur($p3);
        $bien2->addPorteur($p1);
        $bien3->addPorteur($p2);
        $bien3->addPorteur($p3);

        $em->persist($bien1);
        $em->persist($bien2);
        $em->persist($bien3);


        $em->flush(); #flush peut être associé à plusieurs persist. Permettant de répercuter plusieurs mises à jour de la BDD en une seule fois.

        echo("entity porteur created, and biens added to porter's favorite\n");
        
        return $this->render('home.html.twig');
    }
}

?>