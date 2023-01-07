<?php

namespace App\Controller;

use App\Entity\Porteur;
use App\Repository\AdministrateurRepository;
use App\Repository\PorteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Exception;
use SessionIdInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;


class SessionController extends AbstractController
{

    /**
     *@Route("/test", name="test")
     */
    public function test(SessionInterface $session): Response
    {

        // Sauvegarder un attribue dans une session
        $session->set('nom-attribue', 'valeur-attribue');

        // récupérer une valeur d'un attribue
        $my_attribute = $session->get('nom-attribue');

        /*Le Deuxiéme argument est la valeur par défaut de l'attribue
        de la session si elle n'existe pas */
        $my_attribute = $session->get('nom-attribue', 'valeur-pa-defaut');

        // Retourne la valeur de notre attribue de session avant de le supprimer
        $my_value = $session->remove('nom-attribue');

        // Supprime tous les attribus de la session
        $session->clear();

        // Retourne la valeur de notre attribue de session avant de le supprimer
        $my_value = $session->remove('nom-attribue');


        return $this->render('bien/add.html.twig');

    }

    /**
     *@Route("/signup", name="signup")
     */
    public function signup(EntityManagerInterface $em, Request $request, FormFactoryInterface $factory, SessionInterface $session): Response
    {
        
        $builder=$factory->createBuilder(FormType::class, null, ['data_class' => Porteur::class] );
        $builder->setMethod('GET');

        $form=$builder->getForm();
        $form->add('nom', TextType::class, ['required' => true, 'label' => 'Nom du porteur de projet *', 'attr' => ['class' => 'formcontrol', 'placeholder' => 'Tapez un nom pour ce porteur']])
            ->add('prenom', TextType::class, ['required' => true, 'label' => 'Prenom du porteur de projet *', 'attr' => ['class' => 'formcontrol', 'placeholder' => 'Tapez un prenom pour ce porteur']])
            ->add('email', TextType::class, ['required' => true, 'label' => 'Email du porteur de projet *', 'attr' => ['class' => 'formcontrol', 'placeholder' => 'Tapez un email pour ce porteur']])
            ->add('mot_de_passe', PasswordType::class, ['required' => true, 'label' => 'Mot de passe du porteur de projet *', 'attr' => ['class' => 'formcontrol', 'placeholder' => 'Tapez un mot de passe pour ce porteur']])
            ;

        $formView=$form->createView();

        $p = new Porteur();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            $p->setNom($data->getNom());
            $p->setPrenom($data->getPrenom());
            $p->setEmail($data->getEmail());
            $p->setMotDePasse($data->getMotDePasse());

            $em->persist($p);

            $em->flush(); #flush peut être associé à plusieurs persist. Permettant de répercuter plusieurs mises à jour de la BDD en une seule fois.
            
            $session->set('nom', $p->getNom());
            $session->set('prenom', $p->getPrenom());

            return $this->render('session/home.html.twig', ['nom' => $session->get('nom'), 'prenom' => $session->get('prenom')]);

        }

        return $this->render('session/signup.html.twig', ['formView' => $formView]);
        
    }

    /**
     *@Route("/signin", name="signin")
     */
    public function signin(AdministrateurRepository $ar, PorteurRepository $pr, Request $request, FormFactoryInterface $factory, SessionInterface $session): Response
    {
        
        $builder=$factory->createBuilder(FormType::class, null );
        $builder->setMethod('GET');

        $form=$builder->getForm();
        $form->add('login', TextType::class, ['required' => true, 'label' => 'Email ou login *', 'attr' => ['class' => 'formcontrol', 'placeholder' => 'Tapez un email pour s\'identifier']])
            ->add('mot_de_passe', PasswordType::class, ['required' => true, 'label' => 'Mot de passe *', 'attr' => ['class' => 'formcontrol', 'placeholder' => 'Tapez un email pour s\'identifier']])            ;

        $formView=$form->createView();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $admins = $ar->findAll();
            foreach ($admins as $a) {
                if ($data['login'] == $a->getLogin() && $data['mot_de_passe'] == $a->getMotDePasse()) {
                    $session->set('nom', $a->getNom());
                    $session->set('prenom', $a->getPrenom());
                    return $this->render('session/adminhome.html.twig', ['nom' => $session->get('nom'), 'prenom' => $session->get('prenom')]);
                }
            }
            $porteurs = $pr->findAll();
            foreach ($porteurs as $p) {
                if ($data['login'] == $p->getEmail() && $data['mot_de_passe'] == $p->getMotDePasse()) {
                    $session->set('nom', $p->getNom());
                    $session->set('prenom', $p->getPrenom());
                    return $this->render('session/home.html.twig', ['nom' => $session->get('nom'), 'prenom' => $session->get('prenom')]);
                }
            }
            $session->getFlashBag()->add('error', 'Le login ou l\'email, ou le mot de passe n\'est pas valide');
        }
        return $this->render('session/signin.html.twig', ['formView' => $formView]);
        
    }

    
    /**
     *@Route("/logout", name="logout")
     */
    public function logout(SessionInterface $session){
        $session->clear();
        return $this->redirectToRoute('signin');    
    }

    /**
     *@Route("/resetmdp", name="resetmdp")
     */
    public function resetmdp(PorteurRepository $pr,Request $request, SessionInterface $session,  FormFactoryInterface $factory){

        $builder=$factory->createBuilder(FormType::class, null , ['data_class' => Porteur::class]);
        $builder->setMethod('GET');

        $form=$builder->getForm();
        $form->add('email', TextType::class, ['required' => true, 'label' => 'Email *', 'attr' => ['class' => 'formcontrol', 'placeholder' => 'Tapez un email pour réinitialiser le mot de passe']]);

        $formView=$form->createView();

        $form->handleRequest($request);

        if ($form->isSubmitted()){
            $data = $form->getData();
            $email = $data->getEmail();
            $p = $pr->findBy(['email' => $email]);
            if($p == null){
                throw new Exception("Email non présent dans la base");
            }
            $id = $p[0]->getId();
            return $this->redirectToRoute("reset", ['id' => $id]);
        }

        return $this->render('session/resetmdp.html.twig', ['formView' => $formView]);
    }

        /**
     *@Route("/reset/{id}", name="reset", methods={"GET", "POST"})
     */
    public function reset($id, EntityManagerInterface $em, Request $request, SessionInterface $session, FormFactoryInterface $factory)
    {

        $p = $em->getRepository(Porteur::class)->find($id);

        $builder = $factory->createBuilder(FormType::class, null, ['data_class' => Porteur::class]);
        $builder->setMethod('GET');

        $form = $builder->getForm();
        $form->add('mot_de_passe', PasswordType::class, ['required' => true, 'label' => 'Mot de passe *', 'attr' => ['class' => 'formcontrol', 'placeholder' => 'Tapez un nouveau mot de passe']]);

        $formView = $form->createView();

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $data = $form->getData();

            $p->setMotDePasse($data->getMotDePasse());
            ;

            $em->persist($p);

            $em->flush(); #flush peut être associé à plusieurs persist. Permettant de répercuter plusieurs mises à jour de la BDD en une seule fois.
            return $this->redirectToRoute('signin');
        }

        return $this->render('session/reset.html.twig', ['formView' => $formView]);

    }

}
?>