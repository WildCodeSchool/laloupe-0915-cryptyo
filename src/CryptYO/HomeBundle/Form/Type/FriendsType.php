<?php
namespace CryptYO\HomeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class FriendsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('friendOne', 'integer')
            ->add('friendTwo', 'integer')
            ->add('save', 'submit')
        ;
    }

    public function getName()
    {
        return 'message';
    }
}