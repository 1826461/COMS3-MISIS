<?php

namespace Objects;

class Enrollment
{
    public int $id;
    public int $studentNo;
    public string $name;
    public string $surname;
    public string $subject;
    public string $unitCode;
    public string $session;
    public string $classSection;
    public string $expiryDate;
    public string $status;
    public int $courseID;

    /**
     * Enrollment constructor.
     * @param $id
     * @param $studentNo
     * @param $name
     * @param $surname
     * @param $subject
     * @param $unitCode
     * @param $session
     * @param $classSection
     * @param $expiryDate
     * @param $status
     */
    function __construct($id, $studentNo, $name, $surname, $subject, $unitCode, $session, $classSection, $expiryDate, $status)
    {
        $this->id = $id;
        $this->studentNo = $studentNo;
        $this->name = $name;
        $this->surname = $surname;
        $this->subject = $subject;
        $this->unitCode = $unitCode;
        $this->session = $session;
        $this->classSection = $classSection;
        $this->expiryDate = $expiryDate;
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getClassSection(): string
    {
        return $this->classSection;
    }

    /**
     * @param string $classSection
     */
    public function setClassSection(string $classSection): void
    {
        $this->classSection = $classSection;
    }

    /**
     * @return string
     */
    public function getExpiryDate(): string
    {
        return $this->expiryDate;
    }

    /**
     * @param string $expiryDate
     */
    public function setExpiryDate(string $expiryDate): void
    {
        $this->expiryDate = $expiryDate;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSession(): string
    {
        return $this->session;
    }

    /**
     * @param string $session
     */
    public function setSession(string $session): void
    {
        $this->session = $session;
    }

    /**
     * @return int
     */
    public function getStudentNo(): int
    {
        return $this->studentNo;
    }

    /**
     * @param int $studentNo
     */
    public function setStudentNo(int $studentNo): void
    {
        $this->studentNo = $studentNo;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

    /**
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     */
    public function setSurname(string $surname): void
    {
        $this->surname = $surname;
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
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
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


}