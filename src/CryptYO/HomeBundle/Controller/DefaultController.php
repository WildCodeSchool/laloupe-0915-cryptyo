<?php

namespace CryptYO\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('CryptYOHomeBundle:Default:index.html.twig', array('name' => $name));
    }
}
