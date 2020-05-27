<?php

namespace Objects;

class Course
{
    public int $courseID;
    public string $courseName;
    public string $unitCode;

    function __construct($courseID, $courseName, $unitCode) {
        $this->courseID = $courseID;
        $this->courseName = $courseName;
        $this->unitCode = $unitCode;
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
     * @param int $unitCode
     */
    public function setCourseId(int $courseId): void
    {
        $this->courseId = $courseId;
    }

    /**
     * @param string $surname
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