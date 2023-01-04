<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use Proxies\__CG__\App\Entity\Categorie;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class BienController extends AbstractController{



    /**
    *@Route("/agence/bien/add", name="add")
    */
    public function add(Request $request, FormFactoryInterface $factory, CategorieRepository $cr)
    {
        $categorie = array();
        foreach($cr as $c){
            $categorie = $c->getNom();
        }

        $builder = $factory->createBuilder();
        $builder
            ->setAction('/agence/bien/add')
            ->setMethod('GET')
            ->add('nom',    TextType::class, ['label' => 'Titre du bien *', 'attr' => ['class' => 'formcontrol', 'placeholder' => 'Tapez un titre pour ce bien']])
            ->add('prix', 	IntegerType::class, ['label' => 'Prix du bien en euro (€) *', 'attr' => ['class' => 'formcontrol', 'placeholder' => 'Tapez un prix pour ce bien']])
            ->add('url', 	TextType::class, ['required' => false,'label' => 'Url du bien ', 'attr' => ['class' => 'formcontrol', 'placeholder' => 'Tapez une url pour ce bien']])
            ->add('cp', 	IntegerType::class, ['label' => 'Code postal du bien *', 'attr' => ['class' => 'formcontrol', 'placeholder' => 'Tapez un code postal pour ce bien']])
            ->add('categorie', EntityType::class, ['label' => 'Catégorie du bien *', 'class' => Categorie::Class, 'choice_label' => 'nom'])
            ->add('surface', 	IntegerType::class, ['required' => false,'label' => 'Surface en km² du bien ', 'attr' => ['class' => 'formcontrol', 'placeholder' => 'Tapez une surface en km² pour ce bien']])
            ->add('localisation', 	TextAreaType::class, ['required' => false, 'label' => 'Localisation du bien ', 'attr' => ['class' => 'formcontrol', 'placeholder' => 'Tapez une localisation pour ce bien']])
            ->add('description',	TextAreaType::class, ['required' => false, 'label' => 'Description du bien ', 'attr' => ['class' => 'formcontrol', 'placeholder' => 'Tapez une description pour ce bien']])
            ->add('submit', SubmitType::class, ['label'=>'Créer le bien'])
            ;

        $form=$builder->getForm();
        $formView=$form->createView();

        $form->handleRequest($request);
        if ($form->isSubmitted()){
            
        }

        return $this->render('bien/add.html.twig', [ 'formView'=>$formView ]);
        
    }

}
?>