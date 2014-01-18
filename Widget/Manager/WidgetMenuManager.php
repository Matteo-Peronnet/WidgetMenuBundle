<?php

namespace Victoire\MenuBundle\Widget\Manager;


use Victoire\MenuBundle\Form\WidgetMenuType;
use Victoire\MenuBundle\Entity\WidgetMenu;
use Victoire\PageBundle\Entity\BasePage;
use Victoire\MenuBundle\Entity\MenuItem;
use Victoire\CmsBundle\Entity\Widget;

class WidgetMenuManager
{
protected $container;

    /**
     * constructor
     *
     * @param ServiceContainer $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * create a new WidgetMenu
     * @param Page   $page
     * @param string $slot
     *
     * @return $widget
     */
    public function newWidget($page, $slot)
    {
        $widget = new WidgetMenu();
        $widget->setPage($page);
        $widget->setslot($slot);

        return $widget;
    }
    /**
     * render the WidgetMenu
     * @param Widget $widget
     *
     * @return widget show
     */
    public function render(Widget $widget)
    {
        return $this->container->get('victoire_templating')->render(
            "VictoireMenuBundle::show.html.twig",
            array(
                "widget" => $widget
            )
        );
    }

    /**
     * render WidgetMenu form
     * @param Form           $form
     * @param WidgetMenu     $widget
     * @param BusinessEntity $entity
     * @return form
     */
    public function renderForm($form, $widget, $entity = null)
    {

        return $this->container->get('victoire_templating')->render(
            "VictoireMenuBundle::edit.html.twig",
            array(
                "widget" => $widget,
                'form'   => $form->createView(),
                'id'     => $widget->getId(),
                'entity' => $entity
            )
        );
    }

    /**
     * create a form with given widget
     * @param WidgetMenu $widget
     * @param string     $entityName
     * @param string     $namespace
     * @return $form
     */
    public function buildForm($widget, $entityName = null, $namespace = null)
    {
        $form = $this->container->get('form.factory')->create(new WidgetMenuType($entityName, $namespace), $widget);

        return $form;
    }

    /**
     * create form new for WidgetMenu
     * @param Form       $form
     * @param WidgetMenu $widget
     * @param string     $slot
     * @param Page       $page
     * @param string     $entity
     *
     * @return new form
     */
    public function renderNewForm($form, $widget, $slot, $page, $entity = null)
    {

        return $this->container->get('victoire_templating')->render(
            "VictoireMenuBundle::new.html.twig",
            array(
                "widget"          => $widget,
                'form'            => $form->createView(),
                "slot"            => $slot,
                "entity"          => $entity,
                "renderContainer" => true,
                "page"            => $page
            )
        );
    }


    /**
     * create a widget
     * @param string  $type
     * @param string  $slot
     * @param Page    $page
     * @param string  $entity
     * @param Manager $manager
     * @return template
     */
    public function createWidget($type, $slot, BasePage $page, $entity, $manager)
    {
        $em = $this->container->get('doctrine')->getManager();

        $widget = $this->newWidget($page, $slot);
        $widget->setCurrentPage($page);
        $classes = $this->container->get('victoire_cms.annotation_reader')->getBusinessClassesForWidget($widget);

        if ($entity) {
            $form = $manager->buildForm($this, $widget, $entity, $classes[$entity]);
        } else {
            $form = $manager->buildForm($this, $widget);
        }

        $request = $this->container->get('request');

        if ($request->getMethod() === 'POST') {
            $data = $request->request->get($form->getName());
            $menus = $data['items'];
            unset($data['items']);
            $request->request->set($form->getName(), $data);
            $form->setData($data);

            $form->handleRequest($request);

            if ($form->isValid()) {
                $widget = $form->getData();
                $widget->setBusinessEntityName($entity);

                $menus = $this->parseChildren($menus, $em, $widget);
                $widget->setChildren($menus);

                $em->persist($widget);
                $em->flush();

                $manager->populateChildrenReferences($page, $widget);

                $widgetMap = $page->getWidgetMap();
                $widgetMap[$slot][] = $widget->getId();

                $page->setWidgetMap($widgetMap);

                $em->persist($page);
                $em->flush();

                $em->flush();

                return $manager->render($widget, $page);
            }

        }


        $forms = $this->renderNewWidgetForms($entity, $slot, $page, $widget);

        return $this->container->get('victoire_templating')->render(
            "VictoireCmsBundle:Widget:new.html.twig",
            array(
                'classes' => $classes,
                'forms'   => $forms
            )
        );
    }

    /**
     * edit a widget
     * @param Widget        $widget
     * @param string        $entity
     * @param WidgetManager $manager
     * @return template
     */
    public function edit(Widget $widget, $entity = null, $manager)
    {
        $request = $this->container->get('request');
        $classes = $this->container->get('victoire_cms.annotation_reader')->getBusinessClassesForWidget($widget);

        $form = $manager->buildForm($this, $widget);

        if ($entity) {
            $form = $manager->buildForm($this, $widget, $entity, $classes[$entity]);
        }

        if ($request->getMethod() === 'POST') {
            $legacyChildren = clone $widget->getChildren();
            $data = $request->request->get($form->getName());
            $menus = $data['items'];
            unset($data['items']);
            $request->request->set($form->getName(), $data);
            $form->setData($data);

            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->container->get('doctrine')->getManager();
                $menus = $this->parseChildren($menus, $em, $widget);

                foreach ($legacyChildren as $child) {
                    $em->remove($child);
                }
                $widget->setChildren($menus);

                $em->persist($widget);
                $em->flush();

                return $manager->render($widget);
            }
        }
        $forms = $manager->renderWidgetForms($widget);

        return $this->container->get('victoire_templating')->render(
            "VictoireCmsBundle:Widget:edit.html.twig",
            array(
                'classes' => $classes,
                'forms'   => $forms,
                'widget'  => $widget
            )
        );
    }
    private function parseChildren($data, $em, $widget, $menuItem = null)
    {
        $menus = array();
        if (!empty($data)) {
            foreach ($data as $key => $child) {
                $menu = new MenuItem();
                $menu->setTitle($child['title']);
                $menu->setlinkType($child['linkType']);
                if (!empty($child['page'])) {
                    $page = $em->getRepository('VictoirePageBundle:BasePage')->findOneById($child['page']);
                    $menu->setPage($page);
                }
                $menu->setUrl($child['url']);

                if ($menuItem !== null) {
                    $menuItem->addChild($menu);
                } else {
                    $menu->setWidgetMenu($widget);
                    $menus[] = $menu;
                }
                $em->persist($menu);

                if (isset($child['items'])) {
                    $menus = array_merge($this->parseChildren($child['items'], $em, $widget, $menu), $menus);
                }
            }
        }

        return $menus;
    }

}
