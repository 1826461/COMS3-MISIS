<?php

namespace Objects;

class Course
{
    public string $unitCode;
    public int $courseID;
    public string $courseName;
    public string $updateFrequency;
    public int $deleteActive;


    /**
     * Course constructor.
     * @param $unitCode
     * @param $courseID
     * @param int $updateFrequency
     */
    function __construct($unitCode, $courseID, $updateFrequency = 0, $deleteActive = 0)
    {
        $this->unitCode = $unitCode;
        $this->courseID = $courseID;
        $this->courseName = $this->unitCode;
        $this->updateFrequency = $updateFrequency;
        $this->deleteActive = $deleteActive;

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

    /**
     * @return string
     */
    public function getUpdateFrequency(): string
    {
        return $this->updateFrequency;
    }

    /**
     * @param string $updateFrequency
     */
    public function setUpdateFrequency(string $updateFrequency): void
    {
        $this->updateFrequency = $updateFrequency;
    }

    /**
     * @return int|mixed
     */
    public function getDeleteActive()
    {
        return $this->deleteActive;
    }

    /**
     * @param int|mixed $deleteActive
     */
    public function setDeleteActive(int $deleteActive): void
    {
        $this->deleteActive = $deleteActive;
    }
}