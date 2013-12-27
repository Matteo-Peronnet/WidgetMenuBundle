<?php
namespace Victoire\MenuBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Victoire\CmsBundle\Entity\Widget;

/**
 * WidgetMenu
 *
 * @ORM\Table("cms_widget_menu")
 * @ORM\Entity
 */
class WidgetMenu extends Widget
{
    use \Victoire\CmsBundle\Entity\Traits\WidgetTrait;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="MenuItem", mappedBy="widgetMenu")
     */
    private $children;

    /**
     * Add child
     *
     * @param string $child
     * @return MenuItem
     */
    public function addChild($child)
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * Remove child
     *
     * @param string $child
     * @return MenuItem
     */
    public function removeChild($child)
    {
        $this->children->removeElement($child);

        return $this;
    }

    /**
     * Set children
     *
     * @param string $children
     * @return MenuItem
     */
    public function setChildren($children)
    {
        foreach ($children as $child) {
            $child->setWidgetMenu($this);
        }
        $this->children = $children;

        return $this;
    }

    /**
     * Get children
     *
     * @return string
     */
    public function getChildren()
    {
        return $this->children;
    }
    /**
     * Set name
     *
     * @param string $name
     * @return MenuItem
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
