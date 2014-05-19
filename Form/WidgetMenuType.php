<?php

namespace Victoire\MenuBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Victoire\Bundle\CoreBundle\Form\EntityProxyFormType;
use Victoire\Bundle\CoreBundle\Form\WidgetType;

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
            ->add(
                'name',
                null,
                array(
                    'label'     => 'menu.form.name.label',
                    'required'  => true,
                    'help_label_tooltip' => array('menu.form.name.help_label_tooltip')
                )
            )
            ->add(
                'childrenLayout',
                'choice',
                array(
                    'label'     => 'menu.form.childrenLayout.label',
                    'choices'   => array(
                        'rollover' => 'menu.form.childrenLayout.choices.rollover.label',
                        'panel'    => 'menu.form.childrenLayout.choices.panel.label'
                    ),
                    'required'  => true,
                    'help_label_tooltip' => array('menu.form.childrenLayout.help_label_tooltip')
                )
            )
            ->add(
                'items',
                'collection',
                array(
                    'property_path' => 'children',
                    'type'          => 'menu_form',
                    'required'      => false,
                    'allow_add'     => true,
                    'allow_delete'  => true,
                    'by_reference'  => false,
                    'prototype'     => true,
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
        $resolver->setDefaults(
            array(
                'data_class'         => 'Victoire\MenuBundle\Entity\WidgetMenu',
                'widget'             => 'menu',
                'translation_domain' => 'victoire'
            )
        );
    }


    /**
     * get form name
     */
    public function getName()
    {
        return 'appventus_victoirecorebundle_widgetmenutype';
    }
}
