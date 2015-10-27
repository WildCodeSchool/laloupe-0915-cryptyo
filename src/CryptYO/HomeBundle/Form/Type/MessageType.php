<?php
namespace CryptYO\HomeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('destinataire', 'entity', array(
                'class' => 'CryptYOHomeBundle:User', // Utiliser une entitée comme choix multiple.
            ))
            ->add('message', 'textarea')
            ->add('save', 'submit')
        ;
    }

    public function getName()
    {
        return 'message';
    }
}