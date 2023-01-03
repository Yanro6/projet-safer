<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use Proxies\__CG__\App\Entity\Categorie;
use Symfony\Component\Form\ChoiceList\Loader\CallbackChoiceLoader;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class BienController extends AbstractController{
/**
    *@Route("/agence/bien/add", name="form")
    */
    public function add(FormFactoryInterface $factory, CategorieRepository $cr)
    {

        $builder =$factory->createBuilder();
        $builder
            ->setMethod('GET')
            ->setAction('/index')
            ->add('name', TextType::class, ['label' => 'Titre du bien ', 'attr' => ['class' => 'formcontrol', 'placeholder' => 'Tapez un titre pour ce bien']])
            ->add('prix', 	IntegerType::class, ['label' => 'Prix du bien ', 'attr' => ['class' => 'formcontrol', 'placeholder' => 'Tapez un prix pour ce bien']])
            ->add('categorie', ChoiceType::class, ['label' => 'Catégorie du bien ', 
                'choice_loader' => new CallbackChoiceLoader(function () {
                    return Categorie::getCategories();
                })
            ])
            ->add('submit', SubmitType::class, ['label'=>'Créer le bien']);


        $form=$builder->getForm();
        $formView=$form->createView();
        return $this->render('bien/add.html.twig', [ 'formView'=>$formView ]);
        
    }
}
?>