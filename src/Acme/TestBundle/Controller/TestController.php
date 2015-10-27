<?php

namespace Acme\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TestController extends Controller
{
    public function testAction()
    {
        $name = 'Erwan';
        return $this->render('AcmeTestBundle:Test:Afficher.html.twig', array(
                'name' => $name
            ));    }

}
