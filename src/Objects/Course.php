<?php

namespace Objects;

class Course
{
    public string $unitCode;
    public int $courseID;
    public string $courseName;


    function __construct($unitCode, $courseID)
    {
        $this->unitCode = $unitCode;
        $this->courseID = $courseID;
        $this->courseName = $this->unitCode;

    }

    /**
     * @return int
     */
    public function getCourseID(): int
    {
        return $this->courseID;
    }

    /**
     * @param int $courseID
     */
    public function setCourseID(int $courseID): void
    {
        $this->courseID = $courseID;
    }

    /**
     * @return string
     */
    public function getCourseName(): string
    {
        return $this->courseName;
    }

    /**
     * @param string $courseName
     */
    public function setCourseName(string $courseName): void
    {
        $this->courseName = $courseName;
    }

    /**
     * @return string
     */
    public function getUnitCode(): string
    {
        return $this->unitCode;
    }

    /**
     * @param string $unitCode
     */
    public function setUnitCode(string $unitCode): void
    {
        $this->unitCode = $unitCode;
    }

}