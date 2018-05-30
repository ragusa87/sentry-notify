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
        $logger = $this->get("default_logger");

        $form = $this->createForm(DefaultForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message = $form->get("message")->getData();
            $logger->log($form->get("level")->getData(), $message);
        }

        return $this->render('default/index.html.twig', ["form" => $form->createView()]);
    }

    /**
     * @Route("/error/{type}",requirements={"type":"deprecated|error|notice|warning"}, defaults={"deprecated"});
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function errorAction($type)
    {
        switch ($type) {
            default:
            case "deprecated":
                $e = E_USER_DEPRECATED;
                break;
            case "error":
                $e = E_USER_ERROR;
                break;
            case "notice":
                $e = E_USER_NOTICE;
                break;
            case "warning":
                $e = E_USER_WARNING;
                break;

        }
        @trigger_error("Test $type", $e);

        return $this->render(
            'default/message.html.twig',
            ["message" => sprintf('Can you see a "%s" message in the debug toolbar ? And in sentry ?',$type)]
        );
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

