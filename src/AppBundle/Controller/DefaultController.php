<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\DefaultForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @throws \ReflectionException
     */
    public function indexAction(Request $request)
    {
        $logger = $this->get("logger");

        $form = $this->createForm(DefaultForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message = $form->get("message")->getData();
            $logger->log($form->get("level")->getData(), $message);
        }

        return $this->render('default/index.html.twig', ["form" => $form->createView()]);
    }

    /**
     * @Route("/deprecated");
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deprecatedAction()
    {
        @trigger_error("Test deprecated warning 1 ", E_USER_DEPRECATED);

        return $this->render('default/deprecated.html.twig');
    }

    /**
     * @Route("/memory")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function memoryExceptionAction()
    {
        $concat = str_repeat("asdf", 10000);
        $str = $concat;
        do {
            $str .= $concat;
        } while (true);

        // Crash before rendering
        return $this->render('default/deprecated.html.twig');

    }

    /**
     * @Route("/exception")
     */
    public function exceptionAction()
    {
        throw new \RuntimeException("Throwed exception !");
    }
}

