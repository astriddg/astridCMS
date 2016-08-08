<?php

namespace OC\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Version
 *
 * @ORM\Table(name="version")
 * @ORM\Entity(repositoryClass="OC\CoreBundle\Repository\VersionRepository")
 */
class Version
{
	/**
     * @var int
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
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="OC\CoreBundle\Entity\Page", cascade={"persist"})
     * @Assert\Valid()
     */
	private $page;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var OC\CoreBundle\Entity\Category
     * @ORM\ManyToOne(targetEntity="OC\CoreBundle\Entity\Category", cascade={"persist"})
     * @Assert\Valid()
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(name="roleaccess", type="string", length=255, unique=false, nullable=true)
     */
    private $roleaccess;

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Version
     */
    
     public function __construct()
  {
    $this->date = new \Datetime();
  }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Version
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
     * Set slug
     *
     * @param string $slug
     *
     * @return Version
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
     * Set content
     *
     * @param string $content
     *
     * @return Version
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }
    
    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set page
     *
     * @param \OC\CoreBundle\Entity\Page $page
     *
     * @return Version
     */
    public function setPage(\OC\CoreBundle\Entity\Page $page = null)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Get page
     *
     * @return \OC\CoreBundle\Entity\Page
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Version
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Set category
     *
     * @param \OC\CoreBundle\Entity\Category $category
     */
    public function setCategory(\OC\CoreBundle\Entity\Category $category)
    {
        $this->category = $category;


        return $this;
    }

    /**
     * Get category
     *
     * @return \OC\CoreBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set roleaccess
     *
     * @param string $roleaccess
     *
     * @return Version
     */
    public function setRoleaccess($roleaccess)
    {
        $this->roleaccess = $roleaccess;

        return $this;
    }

    /**
     * Get roleaccess
     *
     * @return string
     */
    public function getRoleaccess()
    {
        return $this->roleaccess;
    }
}
