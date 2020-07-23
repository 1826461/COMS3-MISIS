<?php

namespace Objects;

class MoodleCourse
{
    public string $longName;
    public int $id;
    public string $shortName;
    public int $category;


    /**
     * Course constructor.
     * @param $id
     * @param $longName
     * @param $shortName
     * @param $category
     */
    function __construct($id, $longName, $shortName, $category)
    {
        $this->id = $id;
        $this->longName = $longName;
        $this->shortName = $shortName;
        $this->category = $category;

    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLongName(): string
    {
        return $this->longName;
    }

    /**
     * @return string
     */
    public function getShortName(): string
    {
        return $this->shortName;
    }

    /**
     * @return int
     */
    public function getCategory(): int
    {
        return $this->category;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string $longName
     */
    public function setLongName(string $longName): void
    {
        $this->longName = $longName;
    }

    /**
     * @param string $shortName
     */
    public function setShortName(string $shortName): void
    {
        $this->shortName = $shortName;
    }

    /**
     * @param int $category
     */
    public function setCategory(int $category): void
    {
        $this->category = $category;
    }
}