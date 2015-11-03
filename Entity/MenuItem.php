<?php

namespace Victoire\Widget\MenuBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Victoire\Bundle\PageBundle\Entity\Page;
use Victoire\Bundle\WidgetBundle\Entity\Widget;
use Victoire\Widget\ListingBundle\Entity\WidgetListingItem;

/**
 * MenuItem.
 *
 * @ORM\Table("vic_widget_menu_item")
 * @ORM\Entity()
 */
class MenuItem extends WidgetListingItem
{
    use \Victoire\Bundle\WidgetBundle\Entity\Traits\LinkTrait;

    const MENU_HIERARCHICAL = 1;
    const MENU_MANUAL = 2;
    const MENU_INHERITED = 3;
    const MENU_NO = 4;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    protected $title;

    /**
     * @ORM\ManyToOne(targetEntity="WidgetMenu", inversedBy="children")
     * @ORM\JoinColumn(name="menu_id", referencedColumnName="id", onDelete="cascade")
     */
    protected $widgetMenu;

    /**
     * @ORM\ManyToOne(targetEntity="MenuItem", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="cascade")
     */
    protected $parent;

    /**
     * @ORM\OneToMany(targetEntity="MenuItem", mappedBy="parent", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"position" = "ASC"})
     */
    protected $children;

    /**
     * @var bool
     *
     * @ORM\ManyToOne(targetEntity="Victoire\Bundle\PageBundle\Entity\Page")
     * @ORM\JoinColumn(name="root_hierarchy_page", referencedColumnName="id", onDelete="cascade", nullable=true)
     */
    protected $rootHierarchyPage;

    /**
     * @var bool
     *
     * @ORM\Column(name="menu_type", type="integer")
     */
    protected $menuType;

    /**
     * construct.
     **/
    public function __construct()
    {
        $this->menuType = self::MENU_MANUAL;
        $this->children = [];
    }

    /**
     * Set id.
     *
     * @param int
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return MenuItem
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set menu.
     *
     * @param string $menu
     *
     * @return Menu
     */
    public function setMenu(WidgetMenu $menu)
    {
        $this->menu = $menu;

        return $this;
    }

    /**
     * Get menu.
     *
     * @return string
     */
    public function getMenu()
    {
        return $this->menu;
    }

    /**
     * Set parent.
     *
     * @param Menu $parent
     *
     * @return Menu
     */
    public function setParent(MenuItem $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent.
     *
     * @return Menu
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add child.
     *
     * @param Menu $child
     *
     * @return Menu
     */
    public function addChild(MenuItem $child)
    {
        $child->setParent($this);
        $this->children[] = $child;

        return $this;
    }

    /**
     * Remove children.
     *
     * @param Menu $child
     */
    public function removeChild(MenuItem $child)
    {
        $this->children->removeElement($child);
    }

    /**
     * Remove children.
     *
     * @param Menu $child
     */
    public function removeChildren(MenuItem $child)
    {
        $this->children->removeElement($child);
    }

    /**
     * Set children.
     *
     * @param array $children
     *
     * @return \Victoire\Widget\MenuBundle\Entity\MenuItem
     */
    public function setChildren($children)
    {
        $this->children = $children;

        return $this;
    }

    /**
     * Get children.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Get the name.
     *
     * @return string
     */
    public function getName()
    {
        return 'menu';
    }

    /**
     * Get the options.
     *
     * @return array
     */
    public function getOptions()
    {
        return [];
    }

    /**
     * Set root page for hierarchy behavior.
     *
     * @param int $rootHierarchyPage
     *
     * @return Menu
     */
    public function setRootHierarchyPage($rootHierarchyPage)
    {
        $this->rootHierarchyPage = $rootHierarchyPage;

        return $this;
    }

    /**
     * Get menu menu rootHierarchyPage.
     *
     * @return int
     */
    public function getRootHierarchyPage()
    {
        return $this->rootHierarchyPage;
    }

    /**
     * Set menu type.
     *
     * @param int $menuType
     *
     * @return Menu
     */
    public function setMenuType($menuType)
    {
        $this->menuType = $menuType;

        return $this;
    }

    /**
     * Get with menu.
     *
     * @return int
     */
    public function getMenuType()
    {
        return $this->menuType;
    }

    /**
     * Set widget menu.
     *
     * @param int $widgetMenu
     *
     * @return Menu
     */
    public function setWidgetMenu($widgetMenu)
    {
        $this->widgetMenu = $widgetMenu;

        return $this;
    }

    /**
     * Get with menu.
     *
     * @return int
     */
    public function getWidgetMenu()
    {
        return $this->widgetMenu;
    }

    /**
     * The to string method.
     *
     * @return string
     */
    public function __toString()
    {
        return '#MenuItem'.$this->getId();
    }
}
