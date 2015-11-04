<?php
/**
 * Created by PhpStorm.
 * User: erwan
 * Date: 07/10/15
 * Time: 09:59
 */

namespace CryptYO\HomeBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class HomeController extends Controller
{
    /**
     * Affiche la page d'accueil
     **/
    public function indexAction()
    {
        return $this->render('CryptYOHomeBundle:Home:index.html.twig');
    }
    
}
