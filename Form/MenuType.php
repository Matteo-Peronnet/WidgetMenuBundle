<?php

namespace Victoire\MenuBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Victoire\CmsBundle\Form\EntityProxyFormType;
use Victoire\CmsBundle\Form\WidgetType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;


/**
 * Menu form type
 */
class MenuType extends AbstractType
{

    /**
     * define form fields
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('title', 'text', array(
                'label'    => 'menu.form.title.label',
                'required' => true,
            ))
            ->add('linkType', 'choice', array(
                'label'       => 'menu.form.link_type.label',
                'required'    => true,
                'choices'     => array(
                    'page'  => 'menu.form.link_type.page',
                    'url'   => 'menu.form.link_type.url'
                    ),
                'attr'        => array(
                    'class' => 'item-type',
                    'onchange' => 'trackChange(this);'
                    ),
            ))
            ->add('page', 'entity', array(
                'label'       => 'menu.form.page.label',
                'required'    => false,
                'empty_value' => 'menu.form.page.blank',
                'class'       => 'VictoireCmsBundle:Page',
                'property'    => 'title',
                'attr'        => array('class' => 'page-type'),
            ))
            ->add('url', 'text', array(
                'label'       => 'menu.form.page.url',
                'required'    => false,
                'attr'        => array('class' => 'url-type'),
            ));


        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function(FormEvent $event) {
                if ($event->getData() && count($event->getData()->getChildren()) > 0 ) {
                    $event->getForm()->add('items', 'collection',
                        array(
                            'property_path' => 'children',
                            'type' => 'menu_form',
                            'required'     => false,
                            'allow_add'    => true,
                            'allow_delete' => true,
                            'by_reference' => false,
                        )
                    );
                }
            }
        );


    }


    /**
     * bind form to WidgetRedactor entity
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Victoire\MenuBundle\Entity\MenuItem',
            'cascade_validation' => true
        ));
    }


    /**
     * get form name
     */
    public function getName()
    {
        return 'menu_form';
    }
}
