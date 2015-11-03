<?php
namespace CryptYO\HomeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('auteur', 'text')
            ->add('destinataire') // Utiliser une entité comme choix multiple.
            ->add('message', 'textarea')
            ->add('save', 'submit')
        ;
    }

    public function getName()
    {
        return 'message';
    }
}