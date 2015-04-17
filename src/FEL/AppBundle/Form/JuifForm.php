<?php
namespace FEL\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class JuifForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nom')
            ->add('content')
            ->add('auteur')
        ;
    }
    public function getName()
    {
        return 'article';
    }
}