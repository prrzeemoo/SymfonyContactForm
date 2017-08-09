<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Member;
use AppBundle\Form\Type\MemberType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends Controller
{
    /**
     * @Route("/register", name="registration")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function registerAction()
    {
        $member = new Member();

        $form = $this->createForm(MemberType::class, $member, [

        ]);

        return $this->render('registration/register.html.twig', [
            'registration_form' => $form->createView(),
        ]);
    }
}