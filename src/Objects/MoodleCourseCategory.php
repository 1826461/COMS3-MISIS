<?php

namespace Objects;

class MoodleCourseCategory
{
    public string $name;
    public int $id;
    public int $courseCount;


    /**
     * Course constructor.
     * @param $id
     * @param $name
     * @param int $courseCount
     */
    function __construct($id, $name, $courseCount = 0)
    {
        $this->id = $id;
        $this->courseCount = $courseCount;
        $this->name = $name;

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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getCourseCount(): int
    {
        return $this->courseCount;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param int $courseCount
     */
    public function setCourseCount(int $courseCount): void
    {
        $this->courseCount = $courseCount;
    }

}