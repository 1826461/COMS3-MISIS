<?php

namespace Objects;

class Course
{
    public int $courseId;
    public string $courseName;
    public string $unitCode;

    function __construct($courseId, $courseName, $unitCode) {
        $this->courseId = $courseId;
        $this->courseName = $courseName;
        $this->unitCode = $unitCode;
    }

    /**
     * @return int
     */
    public function getCourseId(): int
    {
        return $this->courseId;
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