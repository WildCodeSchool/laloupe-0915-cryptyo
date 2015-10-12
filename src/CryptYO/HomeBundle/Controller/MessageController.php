<?php

namespace CryptYO\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MessageController extends Controller
{
    public function sendAction()
    {
        return $this->render('CryptYOHomeBundle:Home:send_message.html.twig');

    }
}
