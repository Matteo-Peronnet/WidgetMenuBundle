<?php

namespace Victoire\MenuBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Victoire\CmsBundle\Form\EntityProxyFormType;
use Victoire\CmsBundle\Form\WidgetType;


/**
 * WidgetMenu form type
 */
class WidgetMenuType extends WidgetType
{

    /**
     * define form fields
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array(
                'label'    => 'menu.form.name.label',
                'required' => true,
            ))
            ->add('items', 'collection',
                array(
                    'property_path' => 'children',
                    'type' => 'menu_form',
                    'required'     => false,
                    'allow_add'    => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                    'prototype' => true,
                )
            )
        //
        ;
    }

    /**
     * bind form to WidgetRedactor entity
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'         => 'Victoire\MenuBundle\Entity\WidgetMenu',
            'widget'             => 'menu',
            'translation_domain' => 'victoire'
        ));
    }


    /**
     * get form name
     */
    public function getName()
    {
        return 'appventus_victoirecmsbundle_widgetmenutype';
    }
}
