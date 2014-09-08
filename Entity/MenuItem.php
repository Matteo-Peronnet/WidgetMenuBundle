<?php
namespace Victoire\Widget\MenuBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Knp\Menu\NodeInterface;
use Victoire\Bundle\PageBundle\Entity\Page;
use Victoire\Bundle\WidgetBundle\Entity\Widget;
use Victoire\Widget\ListingBundle\Entity\WidgetListingItem;

/**
 * MenuItem
 *
 * @ORM\Table("vic_widget_menu_item")
 * @ORM\Entity(repositoryClass="Gedmo\Tree\Entity\Repository\NestedTreeRepository")
 * @Gedmo\Tree(type="nested")
 */
class MenuItem extends WidgetListingItem implements NodeInterface
{
    use \Victoire\Bundle\WidgetBundle\Entity\Traits\LinkTrait;

    const MENU_HIERARCHICAL = 1;
    const MENU_MANUAL = 2;
    const MENU_INHERITED = 3;
    const MENU_NO = 4;

    /**
     * @var integer
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
     * @Gedmo\TreeLeft
     * @ORM\Column(name="lft", type="integer")
     */
    protected $lft;

    /**
     * @Gedmo\TreeLevel
     * @ORM\Column(name="lvl", type="integer")
     */
    protected $lvl;

    /**
     * @Gedmo\TreeRight
     * @ORM\Column(name="rgt", type="integer")
     */
    protected $rgt;

    /**
     * @Gedmo\TreeRoot
     * @ORM\Column(name="root", type="integer", nullable=true)
     */
    protected $root;

    /**
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="MenuItem", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    protected $parent;

    /**
     * @ORM\OneToMany(targetEntity="MenuItem", mappedBy="parent", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"lft" = "ASC"})
     */
    protected $children;

    /**
     * @var boolean
     *
     * @ORM\ManyToOne(targetEntity="Victoire\Bundle\PageBundle\Entity\Page")
     * @ORM\JoinColumn(name="root_hierarchy_page", referencedColumnName="id", onDelete="cascade", nullable=true)
     */
    protected $rootHierarchyPage;

    /**
     * @var boolean
     *
     * @ORM\Column(name="menu_type", type="integer")
     */
    protected $menuType;

    /**
     * construct
     **/
    public function __construct()
    {
        $this->menuType = self::MENU_MANUAL;
        $this->children = array();
    }

    /**
     * Set id
     *
     * @param integer
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
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
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set menu
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
     * Get menu
     *
     * @return string
     */
    public function getMenu()
    {
        return $this->menu;
    }

    /**
     * Set lft
     * @param integer $lft
     *
     * @return Menu
     */
    public function setLft($lft)
    {
        $this->lft = $lft;

        return $this;
    }

    /**
     * Get lft
     *
     * @return integer
     */
    public function getLft()
    {
        return $this->lft;
    }

    /**
     * Set lvl
     * @param integer $lvl
     *
     * @return Menu
     */
    public function setLvl($lvl)
    {
        $this->lvl = $lvl;

        return $this;
    }

    /**
     * Get lvl
     *
     * @return integer
     */
    public function getLvl()
    {
        return $this->lvl;
    }

    /**
     * Set rgt
     * @param integer $rgt
     *
     * @return Menu
     */
    public function setRgt($rgt)
    {
        $this->rgt = $rgt;

        return $this;
    }

    /**
     * Get rgt
     *
     * @return integer
     */
    public function getRgt()
    {
        return $this->rgt;
    }

    /**
     * Set root
     * @param integer $root
     *
     * @return Menu
     */
    public function setRoot($root)
    {
        $this->root = $root;

        return $this;
    }

    /**
     * Get root
     *
     * @return integer
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * Set parent
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
     * Get parent
     *
     * @return Menu
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add child
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
     * Remove children
     *
     * @param Menu $child
     */
    public function removeChild(MenuItem $child)
    {
        $this->children->removeElement($child);
    }

    /**
     * Remove children
     *
     * @param Menu $child
     */
    public function removeChildren(MenuItem $child)
    {
        $this->children->removeElement($child);
    }
    /**
     * Set children
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
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Get the name
     *
     * @return string
     */
    public function getName()
    {
        return "menu";
    }

    /**
     * Get the options
     *
     * @return array
     */
    public function getOptions()
    {
        return array();
    }

    /**
     * Set rot page for hierarchy behavior
     * @param integer $rootHierarchyPage
     *
     * @return Menu
     */
    public function setRootHierarchyPage($rootHierarchyPage)
    {
        $this->rootHierarchyPage = $rootHierarchyPage;

        return $this;
    }

    /**
     * Get menu menu rootHierarchyPage
     *
     * @return integer
     */
    public function getRootHierarchyPage()
    {
        return $this->rootHierarchyPage;
    }

    /**
     * Set menu type
     * @param integer $menuType
     *
     * @return Menu
     */
    public function setMenuType($menuType)
    {
        $this->menuType = $menuType;

        return $this;
    }

    /**
     * Get with menu
     *
     * @return integer
     */
    public function getMenuType()
    {
        return $this->menuType;
    }

    /**
     * Set widget menu
     * @param integer $widgetMenu
     *
     * @return Menu
     */
    public function setWidgetMenu($widgetMenu)
    {
        $this->widgetMenu = $widgetMenu;

        return $this;
    }

    /**
     * Get with menu
     *
     * @return integer
     */
    public function getWidgetMenu()
    {
        return $this->widgetMenu;
    }

    /**
     * The to string method
     *
     * @return string
     */
    public function __toString()
    {
        return '#MenuItem'.$this->getId();
    }
}
