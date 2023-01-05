<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Entity\Categorie;
use App\Entity\Bien;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\Form\FormType;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\choiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class BienController extends AbstractController{


    /**
    *@Route("/agence/bien/test", name="test")
    */
    public function test(){
        dump('oui');
        return $this->render('index.html.twig');
    }

    /**
    *@Route("/agence/bien/add", name="add")
    */
    public function add(Request $request, FormFactoryInterface $factory, CategorieRepository $cr): Response
    {
        /* DEPRECATED
        $categorie = array();
        foreach($cr->findAll() as $c){
            $categorie[] = $c->getNom();
        }
        */
        
        $builder=$factory->createBuilder();
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

        if ($form->isSubmitted()){
            $data = $form->getData();
            dump($data);
            $b->setTitre($data['titre']);
            $b->setPrix($data['prix']);
            $b->setCp($data['cp']);
            $b->setCategorie($data['categorie']);
            $b->setSurface($data['surface']);
            $b->setUrl($data['url']);
            $b->setLocalisation($data['localisation']);
            $b->setDescription($data['description']);

            dump($b);
        }else{
            dump("pas envoyé");
        }

        return $this->render('bien/add.html.twig', [ 'formView'=>$formView ]);
        
    }

}
?>