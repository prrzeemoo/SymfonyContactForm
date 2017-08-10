<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\ContactFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SupportController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $form = $this->createForm(ContactFormType::class, null, [
            'action' => $this->generateUrl('handle_form_submission'),
        ]);

        return $this->render('support/index.html.twig', [
            'our_form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @Route("/form-submission", name="handle_form_submission")
     * @Method("POST")
     * @throws \LogicException
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function handleFormSubmissionAction(Request $request)
    {
        $form = $this->createForm(ContactFormType::class);

        $form->handleRequest($request);

        if ( ! $form->isSubmitted() || ! $form->isValid()) {
            return $this->redirectToRoute('homepage');
        }

        $data = $form->getData();

        dump($data);

        $message = \Swift_Message::newInstance()
            ->setSubject('Contact Form Submission')
            ->setFrom($data['from'])
            ->setTo('srxoexyq@sharklasers.com')
            ->setBody(
                $form->getData()['message'],
                'text/plain'
            )
        ;

        $this->get('mailer')->send($message);

        $this->addFlash('success', 'Your message was sent!');

        return $this->redirectToRoute('homepage');
    }
}
