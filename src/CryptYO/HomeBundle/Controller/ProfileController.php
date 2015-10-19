<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CryptYO\HomeBundle\Controller;

use FOS\UserBundle\Controller\ProfileController as BaseController;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use CryptYO\HomeBundle\Entity\Message;
use CryptYO\HomeBundle\Form\Type\MessageType;

/**
 * Controller managing the user profile
 *
 * @author Christophe Coevoet <stof@notk.org>
 */
class ProfileController extends BaseController
{
    public function showAction()
    {
        $form = $this->createForm(new MessageType(), new Message(), array(
            'action' => $this->generateUrl('crypt_yo_home_send_message'),
            'method' => 'POST'
        ));

        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        return $this->render('FOSUserBundle:Profile:show.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    public function createMessageAction(Request $request)
    {
        $message = new Message();
        $form = $this->createForm(new MessageType(), $message);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();

        }
        return $this->redirect($this->generateUrl('fos_user_profile_show'));
    }



}
