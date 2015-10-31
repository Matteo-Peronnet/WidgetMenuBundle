<?php

namespace Victoire\Widget\MenuBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Victoire\Widget\ListingBundle\Form\WidgetListingItemType;

/**
 * Menu form type.
 */
class MenuType extends WidgetListingItemType
{
    /**
     * define form fields.
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('title', 'text', [
                'label'    => 'menu.form.category.placeholder',
                'attr'     => [
                    'novalidate' => 'novalidate',
                ],
                'required' => true,
                ]
            )
            ->add('link', 'victoire_link', [
                'horizontal' => true,
            ])
            ->remove('removeButton');

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
                    $form = $event->getForm();
                    $this->addChildrenField($form);
                }
            }
        );
    }

    /**
     * Add the items field to the form.
     *
     * @param Form $form
     */
    protected function addChildrenField($form)
    {
        $form->add('items', 'collection',
            [
                'property_path' => 'children',
                'type'          => 'victoire_form_menu',
                'required'      => false,
                'allow_add'     => true,
                'allow_delete'  => true,
                'by_reference'  => false,
            ]
        );
    }

    /**
     * bind form to WidgetRedactor entity.
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setDefaults([
            'data_class'         => 'Victoire\Widget\MenuBundle\Entity\MenuItem',
            'cascade_validation' => true,
            'translation_domain' => 'victoire',
            'namespace'          => null,
            'businessEntityId'   => null,
        ]);
    }

    /**
     * get form name.
     *
     * @return string The name of the form
     */
    public function getName()
    {
        return 'victoire_form_menu';
    }
}
