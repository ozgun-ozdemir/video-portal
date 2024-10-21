# Video Portal Management System

## Features
**User Authentication**: Admin users can log in to manage the video portal.
**Video Management**: Admin can add, update, and delete videos.
**Responsive Design**: The interface is designed to be user-friendly and responsive.

## Requirements
- PHP
- MySQL
- A web server

## Installation
**Create the Database**:
- Open your MySQL client and run the following SQL commands to create the database and necessary tables.
  
CREATE DATABASE video_portal;

USE video_portal;

CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(50) NOT NULL
);

CREATE TABLE video (
    id INT AUTO_INCREMENT PRIMARY KEY,
    link VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_deleted TINYINT(1) DEFAULT 0
);

## File Descriptions
- **page1.php**: Login page for admin users.
- **page2.php**: Main page for video management, displaying a list of videos.
- **page3.php**: Page to add a new video.
- **page4.php**: Page to update an existing video.
