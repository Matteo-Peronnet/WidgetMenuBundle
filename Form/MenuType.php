<?php

namespace Victoire\Widget\MenuBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvents;

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
                )
            ))
            ->add('page', 'entity', array(
                'label'       => 'menu.form.page.label',
                'required'    => false,
                'empty_value' => 'menu.form.page.blank',
                'class'       => 'VictoirePageBundle:Page',
                'property'    => 'name',
                'attr'        => array('class' => 'page-type'),
            ))
            ->add('url', 'text', array(
                'label'       => 'menu.form.page.url',
                'required'    => false,
                'attr'        => array('class' => 'url-type'),
            ));

        /*
         * When we are editing a menu, we must add the sub menus if there are some children in the entity
         */
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function ($event) {
                $entity = $event->getData();

                if ($entity !== null) {
                    $nbChildren = count($entity->getChildren());

                    if ($nbChildren > 0) {
                        $form = $event->getForm();
                        $this->addChildrenField($form);
                    }
                }
            }
        );

        /*
         * we use the PRE_SUBMIT event to avoid having a circular reference
         *
         * This is done when a widget is created in js in the view
         */
        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function ($event) {
                $rawData = $event->getData();

                if (isset($rawData['items'])) {
                    $addChildren = true;
                } else {
                    $addChildren = false;
                }

                //did some children was added in the form
                if ($addChildren) {
                    $form = $event->getForm();
                    $this->addChildrenField($form);
                }
            }
        );
    }

    /**
     * Add the items field to the form
     *
     * @param Form $form
     */
    protected function addChildrenField($form)
    {
        $form->add('items', 'collection',
            array(
                'property_path' => 'children',
                'type' => 'victoire_form_menu',
                'required'     => false,
                'allow_add'    => true,
                'allow_delete' => true,
                'by_reference' => false
            )
        );
    }
    /**
     * bind form to WidgetRedactor entity
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'         => 'Victoire\Widget\MenuBundle\Entity\MenuItem',
            'cascade_validation' => true,
            'translation_domain' => 'victoire'
        ));
    }

    /**
     * get form name
     *
     * @return string The name of the form
     */
    public function getName()
    {
        return 'victoire_form_menu';
    }
}
