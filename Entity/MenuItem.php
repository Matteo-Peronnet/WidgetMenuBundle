<?php
namespace Victoire\MenuBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Victoire\CmsBundle\Entity\Widget;
use Victoire\CmsBundle\Entity\BasePage;
use Gedmo\Mapping\Annotation as Gedmo;
use Knp\Menu\NodeInterface;
use Victoire\CmsBundle\Annotations as VIC;

/**
 * MenuItem
 *
 * @ORM\Table("cms_widget_menu_item")
 * @ORM\Entity(repositoryClass="Gedmo\Tree\Entity\Repository\NestedTreeRepository")
 * @Gedmo\Tree(type="nested")
 */
class MenuItem  implements NodeInterface
{

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
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="link_type", type="string", length=255)
     */
    private $linkType;

    /**
     * @var string
     *
     * @ORM\Column(name="route", type="string", length=255, nullable=true)
     */
    private $route;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @ORM\ManyToOne(targetEntity="WidgetMenu", inversedBy="children", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="menu_id", referencedColumnName="id", onDelete="cascade")
     */
    private $widgetMenu;

    /**
     * @ORM\ManyToOne(targetEntity="Victoire\CmsBundle\Entity\BasePage")
     * @ORM\JoinColumn(name="attached_page_id", referencedColumnName="id", onDelete="cascade", nullable=true)
     */
    private $page;

    /**
     * @Gedmo\TreeLeft
     * @ORM\Column(name="lft", type="integer")
     */
    private $lft;

    /**
     * @Gedmo\TreeLevel
     * @ORM\Column(name="lvl", type="integer")
     */
    private $lvl;

    /**
     * @Gedmo\TreeRight
     * @ORM\Column(name="rgt", type="integer")
     */
    private $rgt;

    /**
     * @Gedmo\TreeRoot
     * @ORM\Column(name="root", type="integer", nullable=true)
     */
    private $root;

    /**
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="MenuItem", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="MenuItem", mappedBy="parent", cascade={"persist"})
     * @ORM\OrderBy({"lft" = "ASC"})
     */
    private $children;

    /**
     * @var boolean
     *
     * @ORM\ManyToOne(targetEntity="Victoire\CmsBundle\Entity\BasePage")
     * @ORM\JoinColumn(name="root_hierarchy_page", referencedColumnName="id", onDelete="cascade", nullable=true)
     */
    private $rootHierarchyPage;

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
     *
     * @param string $title
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
     * Set linkType
     *
     * @param string $linkType
     * @return MenuItem
     */
    public function setlinkType($linkType)
    {
        $this->linkType = $linkType;

        return $this;
    }

    /**
     * Get linkType
     *
     * @return string
     */
    public function getlinkType()
    {
        return $this->linkType;
    }

    /**
     * Set route
     *
     * @param string $route
     * @return MenuItem
     */
    public function setRoute($route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * Get route
     *
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return MenuItem
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
    /**
     * Set menu
     *
     * @param string $menu
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
     *
     * @param integer $lft
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
     *
     * @param integer $lvl
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
     *
     * @param integer $rgt
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
     *
     * @param integer $root
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
     * Set page
     *
     * @param BasePage $page
     * @return Menu
     */
    public function setPage(BasePage $page = null)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Get page
     *
     * @return BasePage
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Set attachedPage
     *
     * @param BaseattachedPage $attachedPage
     * @return Menu
     */
    public function setAttachedPage(BasePage $attachedPage = null)
    {
        $this->attachedPage = $attachedPage;

        return $this;
    }

    /**
     * Get attachedPage
     *
     * @return BaseattachedPage
     */
    public function getAttachedPage()
    {
        return $this->attachedPage;
    }


    /**
     * Set parent
     *
     * @param Menu $parent
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
     *
     * @param Menu $child
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


    public function getName()
    {
        return "menu";
    }

    public function getOptions()
    {
        return array();
    }
    /**
     * Set rot page for hierarchy behavior
     *
     * @param integer $rootHierarchyPage
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
     *
     * @param integer $menuType
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
     *
     * @param integer $widgetMenu
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
}
