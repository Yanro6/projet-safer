<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Entity\Categorie;
use App\Entity\Bien;
use App\Entity\Porteur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
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
    *@Route("/bien/modificationbien", name="modificationbien", methods={"GET", "POST"})
    */
    public function modificationbien(Request $request, EntityManagerInterface $em, FormFactoryInterface $factory){

        $builder=$factory->createBuilder(FormType::class, null, ['data_class' => Bien::class] );
        $builder->setMethod('GET');

        $form=$builder->getForm();
        $form->add('titre', TextType::class, ['required' => false, 'label' => 'Titre du bien *', 'attr' => ['class' => 'formcontrol']]);


        $formView=$form->createView();

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $data = $form->getData();
            $titre = $data->getTitre(); 
            $b = $em->getRepository(Bien::class)->findBy(['titre'=>$titre]);
            if($b == null){
                return $this->render('error.html.twig');
            }
            $id = $b[0]->getId();

            return $this->redirectToRoute('modifbien', ['id'=>$id]);
        }

        return $this->render('bien/modification.html.twig', ['formView'=>$formView]);
    }


    /**
    *@Route("/bien/modif/{id}", name="modifbien", methods={"GET", "POST"})
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
    *@Route("/bien/suppressionbien", name="suppressionbien", methods={"GET", "POST"})
    */
    public function suppressionbien(Request $request, EntityManagerInterface $em, FormFactoryInterface $factory){

        $builder=$factory->createBuilder(FormType::class, null, ['data_class' => Bien::class] );
        $builder->setMethod('GET');

        $form=$builder->getForm();
        $form->add('titre', TextType::class, ['required' => false, 'label' => 'Titre du bien *', 'attr' => ['class' => 'formcontrol']]);


        $formView=$form->createView();

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $data = $form->getData();
            $titre = $data->getTitre();
            $b = $em->getRepository(Bien::class)->findBy(['titre'=>$titre]);
            if($b == null){
                return $this->render('error.html.twig');
            }
            $id = $b[0]->getId();

            return $this->redirectToRoute('supprBien', ['id'=>$id]);
        }

        return $this->render('bien/suppression.html.twig', ['formView'=>$formView]);
    }

    /**
    *@Route("/bien/suppr/{id}", name="supprBien", methods={"GET", "POST"})
    */
    public function suppr($id, EntityManagerInterface $em){
        $b = $em->getRepository(Bien::class)->find($id);
        if($b == null){
            return $this->render('error.html.twig');
        }
        $titreBien = $b->getTitre();
        $em->remove($b);
        $em->flush(); #flush peut être associé à plusieurs persist. Permettant de répercuter plusieurs mises à jour de la BDD en une seule fois.

        return $this->render('bien/suppr.html.twig', [ 'titreBien'=>$titreBien ]);
    }

    /**
    *@Route("/bien/{id}", name="bien", methods={"GET", "POST"})
    */
    public function bien($id, EntityManagerInterface $em){
        $b = $em->getRepository(Bien::class)->find($id);
        if($b == null){
            return $this->render('error.html.twig');
        }
        $titreBien = $b->getTitre();
        $prixbien = $b->getPrix();
        $urlBien = $b->getUrl();
        $cpBien = $b->getCp();
        $catbien = $b->getCategorie();
        $surfaceBien = $b->getSurface();
        $locBien = $b->getLocalisation();
        $descbien = $b->getDescription();
        $id = $b->getId();

        return $this->render('bien/bien.html.twig', [ 't'=>$titreBien, 'p'=>$prixbien, 'u'=>$urlBien , 'cp'=>$cpBien , 'cat'=>$catbien->getNom() , 's'=>$surfaceBien , 'l'=>$locBien , 'd'=>$descbien , 'id'=>$id]);
    }

    
    /**
    *@Route("/favoris/{id}", name="favoris", methods={"GET", "POST"})
    */
    public function favoris($id, SessionInterface $session, EntityManagerInterface $em){
        $idPorteur = $session->get('id');
        $p = $em->getRepository(Porteur::class)->find($idPorteur);
        $b = $em->getRepository(Bien::class)->find($id);
        $p->addBien($b);
        $b->addPorteur($p);
        $em->persist($p);
        $em->persist($b);
        $em->flush();
        return $this->redirectToRoute('categories');
    }

    /**
    *@Route("/biensfavoris", name="biensfavoris", methods={"GET", "POST"})
    */
    public function biensfavoris(SessionInterface $session, EntityManagerInterface $em)
    {
        $idPorteur = $session->get('id');
        $p = $em->getRepository(Porteur::class)->find($idPorteur);
        $favs = $p->getBiens();
        $titres=array();
        $ids=array();
        $descs=array();
        foreach ($favs as $b) {
            $titres[] = $b->getTitre();
            $ids[] = $b->getId();
            $descs[] = $b->getDescription();
        }
    return $this->render('/bien/biens.html.twig', ['titres' => $titres, 'ids' => $ids, 'descs' => $descs, ['favs'=>$favs]]);
    }
    
}
?>