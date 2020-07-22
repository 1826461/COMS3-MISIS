<?php

namespace Objects;

class MoodleCourse
{
    public string $longName;
    public int $id;
    public string $shortName;


    /**
     * Course constructor.
     * @param $id
     * @param $longName
     * @param $shortName
     */
    function __construct($id, $longName, $shortName)
    {
        $this->id = $id;
        $this->longName = $longName;
        $this->shortName = $shortName;

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

}