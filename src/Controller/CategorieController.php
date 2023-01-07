<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Entity\Categorie;
use App\Entity\Bien;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CategorieController extends AbstractController{

    /**
    *@Route("/categorie/add", name="addCategorie")
    */
    public function add(EntityManagerInterface $em, Request $request, FormFactoryInterface $factory, CategorieRepository $cr): Response
    {
        
        $builder=$factory->createBuilder(FormType::class, null, ['data_class' => Categorie::class] );
        $builder->setMethod('GET');

        $form=$builder->getForm();
        $form->add('nom', TextType::class, ['required' => true, 'label' => 'Nom de la catégorie *']);

        $formView=$form->createView();

        $c = new Categorie();

        $form->handleRequest($request);

        if ($form->isSubmitted()){
            $data = $form->getData();
            $c->setNom($data->getNom());

            $em->persist($c);

            $em->flush(); #flush peut être associé à plusieurs persist. Permettant de répercuter plusieurs mises à jour de la BDD en une seule fois.

        }

        return $this->render('categorie/add.html.twig', [ 'formView'=>$formView ]);
        
    }


    /**
    *@Route("/categorie/modif/{id}", name="modifCategorie", methods={"GET", "POST"})
    */
    public function modify($id, EntityManagerInterface $em, Request $request, FormFactoryInterface $factory, CategorieRepository $cr): Response
    {
        
        $c = $em->getRepository(Categorie::class)->find($id);

        $builder=$factory->createBuilder(FormType::class, null, ['data_class' => Categorie::class] );
        $builder->setMethod('GET');

        $form=$builder->getForm();
        $form->add('nom', TextType::class, ['required' => true, 'label' => 'Nom de la catégorie *', 'attr' => ['class' => 'formcontrol', 'value' => $c->getNom()]]);

        $formView=$form->createView();

        $form->handleRequest($request);

        if ($form->isSubmitted()){
            $data = $form->getData();
            $c->setNom($data->getNom());

            $em->persist($c);

            $em->flush(); #flush peut être associé à plusieurs persist. Permettant de répercuter plusieurs mises à jour de la BDD en une seule fois.

        }

        return $this->render('categorie/modif.html.twig', [ 'formView'=>$formView ]);
        
    }

    /**
    *@Route("/categorie/suppr/{id}", name="supprCategorie", methods={"GET", "POST"})
    */
    public function suppr($id, EntityManagerInterface $em){
        $c = $em->getRepository(Categorie::class)->find($id);
        if($c == null){
            throw new Exception("Bien non présent dans la base");
        }
        $nomCategorie = $c->getNom();
        $em->remove($c);
        $em->flush(); #flush peut être associé à plusieurs persist. Permettant de répercuter plusieurs mises à jour de la BDD en une seule fois.

        return $this->render('categorie/suppr.html.twig', [ 'nomCategorie'=>$nomCategorie ]);
    }

    /**
    *@Route("/categorie/{id}", name="categorie")
    */
    public function categorie($id, EntityManagerInterface $em){
        $c = $em->getRepository(Categorie::class)->find($id);
        
        $titres = array();
        $ids = array();
        $descs = array();
        $listBiens = $c->getBiens();
        foreach($listBiens as $b){
            $titres[] = $b->getTitre();
            $ids[] = $b->getId();
            $descs[] = $b->getDescription();
        }
        $cat = $c->getNom();

        return $this->render('categorie/categorie.html.twig', ['titres' => $titres, 'ids' => $ids, 'descs' => $descs, 'cat' => $cat]);
    }


    /**
    *@Route("/categories", name="categories")
    */
    public function categories(EntityManagerInterface $em){
        $c = $em->getRepository(Categorie::class)->findAll();
        if($c == null){
            throw new Exception("Bien non présent dans la base");
        }

        $cats = array();
        foreach($c as $uneCat){
            $noms[] = $uneCat->getNom();
            $ids[] = $uneCat->getId();
        }
        return $this->render('categorie/categories.html.twig', ['noms' => $noms, 'ids' => $ids, 'c' => $c]);

    }

}
?>