<?php

namespace Victoire\Widget\MenuBundle\Widget\Manager;


use Victoire\Bundle\CoreBundle\Widget\Managers\BaseWidgetManager;
use Victoire\Bundle\CoreBundle\Entity\Widget;
use Victoire\Bundle\CoreBundle\Widget\Managers\WidgetManagerInterface;

/**
 * CRUD operations on WidgetRedactor Widget
 *
 * The widget view has two parameters: widget and content
 *
 * widget: The widget to display, use the widget as you wish to render the view
 * content: This variable is computed in this WidgetManager, you can set whatever you want in it and display it in the show view
 *
 * The content variable depends of the mode: static/businessEntity/entity/query
 *
 * The content is given depending of the mode by the methods:
 *  getWidgetStaticContent
 *  getWidgetBusinessEntityContent
 *  getWidgetEntityContent
 *  getWidgetQueryContent
 *
 * So, you can use the widget or the content in the show.html.twig view.
 * If you want to do some computation, use the content and do it the 4 previous methods.
 *
 * If you just want to use the widget and not the content, remove the method that throws the exceptions.
 *
 * By default, the methods throws Exception to notice the developer that he should implements it owns logic for the widget
 *
 */
class WidgetMenuManager extends BaseWidgetManager implements WidgetManagerInterface
{
    /**
     * The name of the widget
     *
     * @return string
     */
    public function getWidgetName()
    {
        return 'Menu';
    }

//     /**
//      * create a widget
//      * @param string  $type
//      * @param string  $slot
//      * @param Page    $page
//      * @param string  $entity
//      * @param Manager $manager
//      * @return template
//      */
//     public function createWidget($type, $slot, BasePage $page, $entity, $manager)
//     {
//         $em = $this->container->get('doctrine')->getManager();

//         $widget = $this->newWidget($page, $slot);
//         $widget->setCurrentPage($page);
//         $classes = $this->container->get('victoire_core.annotation_reader')->getBusinessClassesForWidget($widget);

//         if ($entity) {
//             $form = $manager->buildForm($this, $widget, $entity, $classes[$entity]);
//         } else {
//             $form = $manager->buildForm($this, $widget);
//         }

//         $request = $this->container->get('request');

//         if ($request->getMethod() === 'POST') {
//             $data = $request->request->get($form->getName());
//             $menus = $data['items'];
//             unset($data['items']);
//             $request->request->set($form->getName(), $data);
//             $form->setData($data);

//             $form->handleRequest($request);

//             if ($form->isValid()) {
//                 $widget = $form->getData();
//                 $widget->setBusinessEntityName($entity);

//                 $menus = $this->parseChildren($menus, $em, $widget);
//                 $widget->setChildren($menus);

//                 $em->persist($widget);
//                 $em->flush();

//                 $manager->populateChildrenReferences($page, $widget);

//                 $widgetMap = $page->getWidgetMap();
//                 $widgetMap[$slot][] = $widget->getId();

//                 $page->setWidgetMap($widgetMap);

//                 $em->persist($page);
//                 $em->flush();

//                 $em->flush();

//                 return json_encode(array(
//                     "success" => true,
//                     "html"    => $this->render($widget, $page)
//                 ));
//             }

//         }


//         $forms = $this->renderNewWidgetForms($entity, $slot, $page, $widget);

//         return json_encode(array(
//             "success" => false,
//             "html"    => $this->container->get('victoire_templating')->render(
//                 "VictoireCoreBundle:Widget:Form/new.html.twig",
//                 array(
//                     'classes' => $classes,
//                     'forms'   => $forms
//                 )
//             )
//         ));
//     }

//     /**
//      * edit a widget
//      * @param Widget        $widget
//      * @param string        $entity
//      * @param WidgetManager $manager
//      * @return template
//      */
//     public function edit(Widget $widget, $entity = null, $manager)
//     {
//         $request = $this->container->get('request');
//         $classes = $this->container->get('victoire_core.annotation_reader')->getBusinessClassesForWidget($widget);

//         $form = $manager->buildForm($this, $widget);

//         if ($entity) {
//             $form = $manager->buildForm($this, $widget, $entity, $classes[$entity]);
//         }

//         if ($request->getMethod() === 'POST') {
//             $legacyChildren = clone $widget->getChildren();
//             $data = $request->request->get($form->getName());
//             $menus = $data['items'];
//             unset($data['items']);
//             $request->request->set($form->getName(), $data);
//             $form->setData($data);

//             $form->handleRequest($request);

//             if ($form->isValid()) {
//                 $em = $this->container->get('doctrine')->getManager();
//                 $menus = $this->parseChildren($menus, $em, $widget);

//                 foreach ($legacyChildren as $child) {
//                     $em->remove($child);
//                 }
//                 $widget->setChildren($menus);

//                 $em->persist($widget);
//                 $em->flush();

//                 return array(
//                     "success"  => true,
//                     "html"     => $this->render($widget),
//                     "widgetId" => "vic-widget-".$widget->getId()."-container"
//                 );
//             }
//         }
//         $forms = $manager->renderWidgetForms($widget);

//         return array(
//             "success"  => false,
//             "html"     => $this->container->get('victoire_templating')->render(
//                 "VictoireCoreBundle:Widget:Form/edit.html.twig",
//                 array(
//                     'classes' => $classes,
//                     'forms'   => $forms,
//                     'widget'  => $widget
//                 )
//             )
//         );
//     }

//     private function parseChildren($data, $em, $widget, $menuItem = null)
//     {
//         $menus = array();
//         if (!empty($data)) {
//             foreach ($data as $key => $child) {
//                 $menu = new MenuItem();
//                 $menu->setTitle($child['title']);
//                 $menu->setlinkType($child['linkType']);
//                 if (!empty($child['page'])) {
//                     $page = $em->getRepository('VictoirePageBundle:BasePage')->findOneById($child['page']);
//                     $menu->setPage($page);
//                 }
//                 $menu->setUrl($child['url']);

//                 if ($menuItem !== null) {
//                     $menuItem->addChild($menu);
//                 } else {
//                     $menu->setWidgetMenu($widget);
//                     $menus[] = $menu;
//                 }
//                 $em->persist($menu);

//                 if (isset($child['items'])) {
//                     $menus = array_merge($this->parseChildren($child['items'], $em, $widget, $menu), $menus);
//                 }
//             }
//         }

//         return $menus;
//     }

}
