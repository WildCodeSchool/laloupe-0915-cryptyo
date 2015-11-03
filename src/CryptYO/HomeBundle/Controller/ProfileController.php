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

use CryptYO\HomeBundle\Entity\Friends;
use FOS\UserBundle\Controller\ProfileController as BaseController;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use CryptYO\HomeBundle\Entity\Message;
use CryptYO\HomeBundle\Form\Type\MessageType;
use CryptYO\HomeBundle\Form\Type\FriendsType;





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


        $friendsForm = $this->createForm(new FriendsType(), new Friends(), array(
            'action' => $this->generateUrl('crypt_yo_add_friends'),
            'method' => 'POST',
        ));

        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }



        // On récupère tous les messages de l'utilisateur connecté
        $userName = $user->getUsername();
        $em = $this->getDoctrine()->getManager();
        $userMessages = $em->getRepository('CryptYOHomeBundle:Message')->findBy(array('destinataire' => $userName));
        $showFriend = $em->getRepository('CryptYOHomeBundle:Friends')->findBy(array('friendOne' => $user));
        $allUsers = $em->getRepository('CryptYOHomeBundle:User')->findAll(array('id'));

        return $this->render('FOSUserBundle:Profile:show.html.twig', array(
            'form' => $form->createView(),
            'decryptForm' => $decryptForm->createView(),
            'friendsForm' => $friendsForm->createView(),
            'user' => $user,
            'messages' => $userMessages,
            'showFriends' => $showFriend,
            'users' => $allUsers
        ));
    }

    public function decryptAction(Request $request)
    {
        $resultForm = $request->request->get('form');
        $resultId = $resultForm['id'];
        $resultSel = $resultForm['sel'];

        $em = $this->getDoctrine()->getManager();
        $message = $em->getRepository('CryptYOHomeBundle:Message')->findOneBy(array('id' => $resultId));
        $cryptedMessage = $message->getMessage();

        $decrypted = $this->decryptMessage($cryptedMessage, $resultSel);

        return $this->render('FOSUserBundle:Profile:decrypted.html.twig', array(
            'decrypted' => $decrypted
        ));
    }

    public function createMessageAction(Request $request)
    {
        $message = new Message();
        $form = $this->createForm(new MessageType(), $message);
        $form->handleRequest($request);

        if ($form->isValid()) {

            // Crypt du message
            $previousMessage = $message->getMessage();
            $encrypted = $this->cryptMessage($previousMessage);
            $encryptedMessage = $encrypted[0];
            $sel = $encrypted[1]; // on recupere le sel
            $message->setMessage($encryptedMessage);

            $this->addFlash(
                'notice',
                'Message bien envoyé !'
            );

            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();

            $this->sendMail($message, $sel);


            return $this->redirect($this->generateUrl('fos_user_profile_show'));
        }
    }

    public function addFriendsAction(Request $request)
    {
        $friend = new Friends();
        $form = $this->createForm(new FriendsType(), $friend);
        $form->handleRequest($request);

        $this->checkMessage($form, $friend);

        return $this->redirect($this->generateUrl('fos_user_profile_show'));
    }

    private function sendMail($message, $sel){

        // On récupere les adresses mail pour le mailing
        $destinataire = $message->getDestinataire();
        $auteur = $message->getAuteur();
        $id = $message->getId();
        $currentMessage = $message->getMessage();
        $userManager = $this->get('fos_user.user_manager');
        $mailDestinataire = $userManager->findUserByUsername($destinataire)->getEmail();
        $mailAuteur = $userManager->findUserByUsername($auteur)->getEmail();
        $to = array($mailAuteur, $mailDestinataire);

        $sendMessage = \Swift_Message::newInstance()
            ->setSubject($auteur.' vous a envoyé un message !!!')
            ->setFrom('CryptYO@gmail.com')
            ->setTo($to)
            ->setBody(
                $this->renderView(
                    'Emails/receivedMessage.html.twig',
                    array(
                        'sel' => $sel,
                        'auteur' => $auteur,
                        'message' => $currentMessage,
                        'id' => $id
                    )
                ),
                'text/html'
            );
        $this->get('mailer')->send($sendMessage);
    }


    private function checkMessage($form, $friend){

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $friendOne = $friend->getFriendOne(); $friendString = $friend->getFriendTwo();
            $friendVerify = $em->getRepository('CryptYOHomeBundle:User')->findOneBy(array('username' => $friendString));
            $userFriends = $em->getRepository('CryptYOHomeBundle:Friends')->findBy(array('friendOne' => $friendOne));

            if ($friendVerify){
                $friendStringToId = $friendVerify->getId();
                $existFriend = 0;
                foreach ($userFriends as $key => $valeur){
                    if ($valeur->getFriendTwo() == $friendStringToId){
                        $existFriend = 1;}
                } if ($existFriend == 1) {
                    $this->addFlash(
                        'noami', 'Vous êtes déjà ami avec '.$friendString);
                } else {
                    $this->addFlash(
                        'addami', 'Ami bien ajouté !');
                    $friend->setFriendTwo($friendStringToId);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($friend);
                    $em->flush();
                }
            } else{
                $this->addFlash(
                    'notexist', 'Utilisateur inexistant');
            }
        } else {
            $this->addFlash(
                'error', 'Champ invalide' );
        }
    }


    private function decryptMessage($cryptedMessage, $sel)
    {
        $data = base64_decode($cryptedMessage);
        $iv = substr($data, 0, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC));

        $decrypted = rtrim(
            mcrypt_decrypt(
                MCRYPT_RIJNDAEL_128,
                hash('sha256', $sel, true),
                substr($data, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC)),
                MCRYPT_MODE_CBC,
                $iv
            ),
            "\0"
        );

        return $decrypted;
    }

    private function cryptMessage($message)
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

        $cryptedMessage = base64_encode(
            $iv .
            mcrypt_encrypt(
                MCRYPT_RIJNDAEL_128,
                hash('sha256', $rand, true),
                $message,
                MCRYPT_MODE_CBC,
                $iv
            )
        );

        return array($cryptedMessage, $rand);

    }

}
