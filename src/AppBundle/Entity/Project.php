<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use ActivityLogBundle\Entity\Interfaces\StringableInterface;

/**
 * @package AppBundle\Entity
 * @ORM\Entity(repositoryClass="ProjectRepository")
 * @ORM\Table
 * @Gedmo\Loggable(logEntryClass="ActivityLogBundle\Entity\LogEntry")
 */
class Project implements StringableInterface
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=128)
     * @Gedmo\Versioned
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(type="string", length=16)
     * @Gedmo\Versioned
     */
    private $jiraKey;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Set jiraKey
     *
     * @param string $jiraKey
     *
     * @return Project
     */
    public function setJiraKey($jiraKey)
    {
        $this->jiraKey = $jiraKey;

        return $this;
    }

    /**
     * Get jiraKey
     *
     * @return string
     */
    public function getJiraKey()
    {
        return $this->jiraKey;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return (string)$this;
    }
}
