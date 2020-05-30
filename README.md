# COMS3-MISIS [![Build Status](https://travis-ci.org/1826461/COMS3-MISIS.svg?branch=master)](https://travis-ci.org/1826461/COMS3-MISIS) [![codecov.io](https://codecov.io/gh/1826461/COMS3-MISIS/coverage.svg?branch=master)](https://codecov.io/gh/1826461/COMS3-MISIS)
Wits Moodle Integration with Student Information System written in PHP and JavaScript with JQuery and Bootstrap designed to provide a front-end interface to the external enrollment Moodle plug-in. 

**Features**:
  - Secure password protected interface
  - Different user models for controlled access
  - Automatically add users to Moodle courses from Virtus system
  - Manually add, edit or remove users from Moodle
  - Create new Moodle courses automatically
  - Track number of users currently enrolled in each course
  - Filter enrollments by course code
  - Search enrollment table by name, surname or student number

**Requirements**:
  - PHP 7.4
  - MySQL 8.0.20
  
 **Dependancies**
  - Doctrine
  - Deep Copy
  - phar-io
  - PHPUnit
  - Symfony
  - Webmozart
  
 **Installation Instructions**
  - Create MySQL tables using scripts provided
  - Copy src directory contents to hosting root directory
  - Edit database credentials and path in src/Helpers/DatabaseHelper.php
  - Enable Moodle external database enrollment plug-in and configure using the MySQL tables
  
  **How it works**
  - When a new course is created, the COMS3-MISIS system uses the Wits Virtus API to obtain all students registered for that specific course and adds them to the enrollments table. When a user logs into Moodle, he/she is automatically enrolled in each of the courses with entries in the enrollments database based on their enrollment status and expiry date. 
