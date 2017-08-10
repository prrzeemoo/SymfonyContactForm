<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Member;
use AppBundle\Form\Type\MemberType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends Controller
{
    /**
     * @Route("/register", name="registration")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \LogicException
     */
    public function registerAction(Request $request)
    {
        $member = new Member();

        $form = $this->createForm(MemberType::class, $member, [

        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $this
                ->get('security.password_encoder')
                ->encodePassword(
                    $member,
                    $member->getPlainPassword()
                );

            $member->setPassword($password);

            $en = $this->getDoctrine()->getManager();

            $en->persist($member);
            $en->flush();

            $this->addFlash('success', 'Twoje Konto Zostało Zarejestrowane');

            return $this->redirectToRoute('homepage');
        }

        return $this->render('registration/register.html.twig', [
            'registration_form' => $form->createView(),
        ]);
    }
}