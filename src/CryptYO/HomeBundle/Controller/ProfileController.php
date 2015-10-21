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
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\Request;
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
            'method' => 'POST',
        ));

        $data = array();
        $decryptForm = $this->createFormBuilder($data)
            ->setAction($this->generateUrl('crypt_yo_home_decrypt_message'))
            ->setMethod('POST')
            ->add('id', 'integer')
            ->add('sel', 'text')
            ->add('save', 'submit')
            ->getForm();

        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $userName = $user->getUsername();

        $em = $this->getDoctrine()->getManager();
        $messages = $em->getRepository('CryptYOHomeBundle:Message')->findBy(array('destinataire' => $userName));

        return $this->render('FOSUserBundle:Profile:show.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
            'decryptForm' => $decryptForm->createView(),
            'messages' => $messages
        ));
    }

    public function decryptAction(Request $request)
    {
        $result = $request->request->get('form');
        $resultId = $result['id'];
        $resultSel = $result['sel'];

        $em = $this->getDoctrine()->getManager();
        $message = $em->getRepository('CryptYOHomeBundle:Message')->findOneBy(array('id' => $resultId));
        $crytedMessage = $message->getMessage();
        $auteurMessage = $message->getAuteur();

        $data = base64_decode($crytedMessage);
        $iv = substr($data, 0, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC));

        $decrypted = rtrim(
            mcrypt_decrypt(
                MCRYPT_RIJNDAEL_128,
                hash('sha256', $resultSel, true),
                substr($data, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC)),
                MCRYPT_MODE_CBC,
                $iv
            ),
            "\0"
        );

        return $this->render('FOSUserBundle:Profile:decrypted.html.twig', array(
            'decrypted' => $decrypted
        ));
    }

    public function createMessageAction(Request $request)
    {
        $seed = str_split('abcdefghijklmnopqrstuvwxyz'
            .'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
            .'0123456789!@#$%^&*()');
        shuffle($seed);
        $rand = '';
        foreach (array_rand($seed, 10) as $k) $rand .= $seed[$k];

        $iv = mcrypt_create_iv(
            mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC),
            MCRYPT_DEV_URANDOM
        );

        $message = new Message();
        $form = $this->createForm(new MessageType(), $message);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $previousMessage = $message->getMessage();
            $encrypted = base64_encode(
                $iv .
                mcrypt_encrypt(
                    MCRYPT_RIJNDAEL_128,
                    hash('sha256', $rand, true),
                    $previousMessage,
                    MCRYPT_MODE_CBC,
                    $iv
                )
            );
            $message->setMessage($encrypted);

            $this->addFlash(
                'notice',
                'Message bien envoyé !'
            );

            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();

            $destinataire = $message->getDestinataire();
            $auteur = $message->getAuteur();
            $userManager = $this->get('fos_user.user_manager');
            $mailDestinataire = $userManager->findUserByUsername($destinataire)->getEmail();
            $mailAuteur = $userManager->findUserByUsername($auteur)->getEmail();
            $to = array($mailAuteur, $mailDestinataire);

            $sendMessage = \Swift_Message::newInstance()
                ->setSubject($auteur.' vous a envoyé un message !!!')
                ->setFrom('CryptYO@gmail.com')
                ->setTo($to)
                ->setBody('Voici votre sel : '.$rand)
            ;
            $this->get('mailer')->send($sendMessage);


            return $this->redirect($this->generateUrl('fos_user_profile_show'));
        }
    }
}