<?php

namespace Victoire\Widget\MenuBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Victoire\Bundle\CoreBundle\Form\WidgetType;

/**
 * WidgetMenu form type.
 */
class WidgetMenuType extends WidgetType
{
    /**
     * define form fields.
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                    'label'                  => 'menu.form.name.label',
                    'required'               => true,
                    'vic_help_label_tooltip' => ['menu.form.name.help_label_tooltip'],
                ]
            )
            ->add('items', CollectionType::class, [
                    'property_path' => 'children',
                    'entry_type'    => MenuType::class,
                    'required'      => false,
                    'allow_add'     => true,
                    'allow_delete'  => true,
                    'by_reference'  => false,
                    'prototype'     => true,
                    'options'       => [
                        'namespace'        => null,
                        'businessEntityId' => null,
                        'mode'             => 'static',
                    ],
                ]
            );

        parent::buildForm($builder, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'data_class'         => 'Victoire\Widget\MenuBundle\Entity\WidgetMenu',
            'widget'             => 'menu',
            'translation_domain' => 'victoire',
        ]);
    }
}
