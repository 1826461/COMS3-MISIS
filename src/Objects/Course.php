<?php

namespace Objects;

class Course
{
    public string $unitCode;
    public int $courseID;
    public string $courseName;


    function __construct($unitCode, $courseID) {
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
     * @return string
     */
    public function getCourseName(): string
    {
        return $this->courseName;
    }

    /**
     * @return string
     */
    public function getUnitCode(): string
    {
        return $this->unitCode;
    }


    /**
     * @param int $courseID
     */
    public function setCourseID(int $courseID): void
    {
        $this->courseID = $courseID;
    }

    /**
     * @param string $courseName
     */
    public function setCourseName(string $courseName): void
    {
        $this->courseName = $courseName;
    }

    /**
     * @param string $unitCode
     */
    public function setUnitCode(string $unitCode): void
    {
        $this->unitCode = $unitCode;
    }

}