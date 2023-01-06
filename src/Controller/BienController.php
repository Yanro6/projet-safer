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

class BienController extends AbstractController{

    /**
    *@Route("/bien/add", name="addBien")
    */
    public function add(EntityManagerInterface $em, Request $request, FormFactoryInterface $factory, CategorieRepository $cr): Response
    {
        
        $builder=$factory->createBuilder(FormType::class, null, ['data_class' => Bien::class] );
        $builder->setMethod('GET');

        $form=$builder->getForm();
        $form->add('titre', TextType::class, ['required' => true, 'label' => 'Titre du bien *', 'attr' => ['class' => 'formcontrol', 'placeholder' => 'Tapez un titre pour ce bien']])
            ->add('prix', IntegerType::class, ['required' => true, 'label' => 'Prix du bien en euro (€) *', 'attr' => ['class' => 'formcontrol', 'placeholder' => 'Tapez un prix pour ce bien']])
            ->add('cp', IntegerType::class, ['required' => true, 'label' => 'Code postal du bien *', 'attr' => ['class' => 'formcontrol', 'placeholder' => 'Tapez un code postal pour ce bien']])
            ->add('categorie', EntityType::class, ['required' => true, 'label' => 'Catégorie du bien *', 'class' => Categorie::class, 'choice_label' => 'nom'])
            ->add('surface', IntegerType::class, ['required' => false, 'label' => 'Surface en km² du bien ', 'attr' => ['class' => 'formcontrol', 'placeholder' => 'Tapez une surface en km² pour ce bien']])
            ->add('url', TextType::class, ['required' => false, 'label' => 'Url du bien ', 'attr' => ['class' => 'formcontrol', 'placeholder' => 'Tapez une url pour ce bien']])
            ->add('localisation', TextAreaType::class, ['required' => false, 'label' => 'Localisation du bien ', 'attr' => ['class' => 'formcontrol', 'placeholder' => 'Tapez une localisation pour ce bien']])
            ->add('description', TextAreaType::class, ['required' => false, 'label' => 'Description du bien ', 'attr' => ['class' => 'formcontrol', 'placeholder' => 'Tapez une description pour ce bien']])
            ;

        $formView=$form->createView();

        $b = new Bien();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            $b->setTitre($data->getTitre());
            $b->setPrix($data->getPrix());
            $b->setCp($data->getCp());
            $b->setCategorie($data->getCategorie());
            $b->setSurface($data->getSurface());
            $b->setUrl($data->getUrl());
            $b->setLocalisation($data->getLocalisation());
            $b->setDescription($data->getDescription());

            $em->persist($b);

            $em->flush(); #flush peut être associé à plusieurs persist. Permettant de répercuter plusieurs mises à jour de la BDD en une seule fois.

        }

        return $this->render('bien/add.html.twig', [ 'formView'=>$formView ]);
        
    }


    /**
    *@Route("/bien/modif/{id}", name="modifBien", methods={"GET", "POST"})
    */
    public function modif($id, EntityManagerInterface $em, Request $request, FormFactoryInterface $factory, CategorieRepository $cr): Response
    {
        
        $b = $em->getRepository(Bien::class)->find($id);

        $builder=$factory->createBuilder(FormType::class, null, ['data_class' => Bien::class] );
        $builder->setMethod('GET');

        $form=$builder->getForm();
        $form->add('titre', TextType::class, ['required' => true, 'label' => 'Titre du bien *', 'attr' => ['class' => 'formcontrol', 'value' => $b->getTitre()]])
            ->add('prix', IntegerType::class, ['required' => true, 'label' => 'Prix du bien en euro (€) *', 'attr' => ['class' => 'formcontrol', 'value' => $b->getPrix()]])
            ->add('cp', IntegerType::class, ['required' => true, 'label' => 'Code postal du bien *', 'attr' => ['class' => 'formcontrol', 'value' => $b->getCp()]])
            ->add('categorie', EntityType::class, ['required' => true, 'label' => 'Catégorie du bien *', 'class' => Categorie::class, 'choice_label' => 'nom', 'data' => $b->getCategorie() ])
            ->add('surface', IntegerType::class, ['required' => false, 'label' => 'Surface en km² du bien ', 'attr' => ['class' => 'formcontrol', 'value' => $b->getSurface()]])
            ->add('url', TextType::class, ['required' => false, 'label' => 'Url du bien ', 'attr' => ['class' => 'formcontrol', 'value' => $b->getUrl()]])
            ->add('localisation', TextAreaType::class, ['required' => false, 'label' => 'Localisation du bien ', 'attr' => ['class' => 'formcontrol', 'value' => $b->getLocalisation()]])
            ->add('description', TextAreaType::class, ['required' => false, 'label' => 'Description du bien ', 'attr' => ['class' => 'formcontrol', 'value' => $b->getDescription()]])
            ;

        $formView=$form->createView();

        $form->handleRequest($request);

        if ($form->isSubmitted()){
            $data = $form->getData();

            $b->setTitre($data->getTitre());
            $b->setPrix($data->getPrix());
            $b->setCp($data->getCp());
            $b->setCategorie($data->getCategorie());
            $b->setSurface($data->getSurface());
            $b->setUrl($data->getUrl());
            $b->setLocalisation($data->getLocalisation());
            $b->setDescription($data->getDescription());
            ;

            $em->persist($b);

            $em->flush(); #flush peut être associé à plusieurs persist. Permettant de répercuter plusieurs mises à jour de la BDD en une seule fois.

        }

        return $this->render('bien/modif.html.twig', [ 'formView'=>$formView ]);
        
    }

    /**
    *@Route("/bien/suppr/{id}", name="supprBien", methods={"GET", "POST"})
    */
    public function suppr($id, EntityManagerInterface $em){
        $b = $em->getRepository(Bien::class)->find($id);
        if($b == null){
            throw new Exception("Bien non présent dans la base");
        }
        $titreBien = $b->getTitre();
        $em->remove($b);
        $em->flush(); #flush peut être associé à plusieurs persist. Permettant de répercuter plusieurs mises à jour de la BDD en une seule fois.

        return $this->render('bien/suppr.html.twig', [ 'titreBien'=>$titreBien ]);
    }

}
?>