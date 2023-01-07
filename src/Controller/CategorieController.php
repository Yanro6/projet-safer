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
    *@Route("/categories", name="categorie")
    */
    public function categories(EntityManagerInterface $em){
        $c = $em->getRepository(Categorie::class)->findAll();

        $listCat = array();
        foreach($c as $uneCategorie){
            $biensCat = $uneCategorie->getBiens(); // liste des biens favoris
            $nomCat = $uneCategorie->getNom();
            foreach($biensCat as $b){
                # update de la liste par categorie
                $t = $b->getTitre(); // titre du bien
                if(!array_key_exists($nomCat, $listCat)){
                    $biens = array($t => 1); // liste du nombre de fois que le bien apparrait dans un département
                    $listCat[$nomCat] = $biensFav; // ajout du departement dans le tableau
                }else{
                    if (!array_key_exists($t, $deptBienFav[$nomCat])) {
                        $listCat[$nomCat][$t] = 1; // liste du nombre de fois que le bien apparrait dans un département
                    }else{
                        $listCat[$nomCat][$t]++; // increment du nombre dans le tableau
                    }
                }
            }
        }

        return $this->render('categorie/categories.html.twig', ['categories' => $c]);
    }


}
?>