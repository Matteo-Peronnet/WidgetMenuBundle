<?php

namespace Victoire\Widget\MenuBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Victoire\Bundle\WidgetBundle\Entity\Widget;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * WidgetMenu
 *
 * @ORM\Table("vic_widget_menu")
 * @ORM\Entity
 */
class WidgetMenu extends Widget
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"name"}, separator="-", updatable=false)
     * @ORM\Column(name="slug", type="string", length=255)
     */
    protected $slug;

    /**
     * @ORM\OneToMany(targetEntity="MenuItem", mappedBy="widgetMenu", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    protected $children;

    /**
     * @var string
     *
     * @ORM\Column(name="children_layout", type="string", length=255)
     */
    protected $childrenLayout = "dropdown";

    /**
     * To String function
     * Used in render choices type (Especially VictoireWidgetRenderBundle)
     *
     * @return String
     */
    public function __toString()
    {
        return '#'.$this->getId().' - '.$this->getName();
    }

    /**
     * Add child
     * @param string $child
     *
     * @return MenuItem
     */
    public function addChild(MenuItem $child)
    {
        $child->setWidgetMenu($this);
        $this->children[] = $child;

        return $this;
    }

    /**
     * Remove child
     * @param string $child
     *
     * @return MenuItem
     */
    public function removeChild($child)
    {
        $this->children->removeElement($child);

        return $this;
    }

    /**
     * Set children
     * @param string $children
     *
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
     * @param string $name
     *
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

    /**
     * Set slug
     * @param string $slug
     *
     * @return MenuItem
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Get childrenLayout
     *
     * @return string
     */
    public function getChildrenLayout()
    {
        return $this->childrenLayout;
    }

    /**
     * Set childrenLayout
     * @param string $childrenLayout
     *
     * @return $this
     */
    public function setChildrenLayout($childrenLayout)
    {
        $this->childrenLayout = $childrenLayout;

        return $this;
    }
}
