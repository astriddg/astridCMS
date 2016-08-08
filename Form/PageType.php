<?php

namespace OC\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use OC\CoreBundle\Form\CategoryType;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;


class PageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',     TextType::class)
            ->add('content',     CKEditorType::class)
            ->add('save',      SubmitType::class)
            ->add('category', EntityType::class, array(
                'placeholder' => 'Choose an option',
                'class' => 'OCCoreBundle:Category',
                'required' => TRUE,
                ))
            ->add('roleaccess', ChoiceType::class, array(
                'choices'  => array(
                    'Anonymous' => 'Anonymous',
                    'Admin' => 'ROLE_ADMIN',
                    'User' => 'ROLE_USER',
                    '' => '',
                    
                )));
    


    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'OC\CoreBundle\Entity\Page'
        ));
    }
}
