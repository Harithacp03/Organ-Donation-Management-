# Organ-Donation-Management-
Modular PHP-MySQL  based Organ Donation Management with donor and recipient forms , Administrators to match and manage organ details.
 Organ & Blood Donation Management System

🚀 A Smart Web-Based Platform for Efficient Donor–Recipient Matching

The Organ & Blood Donation Management System is a secure and centralized web application developed using PHP and MySQL.

It manages organ donors, blood donors, and recipients through structured digital forms while providing administrators with monitoring, matching, and visualization capabilities for efficient healthcare management.

This system replaces manual record-keeping with a data-driven, organized, and secure digital solution.

🌟 Key Features

✔️ Organ Donor Registration

✔️ Blood Donor Registration

✔️ Recipient Request Management

✔️ Secure Login & Signup System

✔️ Admin Matching & Approval System

✔️ Real-Time Data Visualization Dashboard

✔️ Organized & Structured Database


🔐 Authentication Module

Secure Signup & Login

Session-Based Authentication

Role-Based Access Control

Protected Admin Pages


🧾 Donor Module

Organ Donor Registration Form

Blood Donor Registration Form

Organ Selection (Kidney, Liver, etc.)

Personal & Medical Detail Storage

Data Update & Management


🏥 Recipient Module

Organ Request Form

Required Organ Selection

Request Tracking

Status Monitoring


👨‍💼 Admin Module

The Admin Panel acts as the central control system of the application.

Admin Capabilities:

View All Organ Donors

View Blood Donor List

View All Recipients

Match Donors with Recipients

Approve / Reject Requests

Monitor System Records

Access Data Visualization Dashboard


📊 Data Visualization (Admin Dashboard)

The system includes graphical analysis through visual.php:

📈 Total Registered Donors
🩸 Blood Group Distribution
🫀 Organ Availability Statistics
📊 Recipient Request Overview
📉 Summary Reports for Quick Decision-Making

Visualization improves emergency response efficiency and administrative accuracy.


🛠️ Technology Stack

Layer	Technology

Frontend	HTML, CSS, JavaScript
Backend	PHP
Database	MySQL
Server	XAMPP (Apache)


📁 Project Architecture

organ-blood-donation-management

│

├── 📂 admin/

│   ├── Admin.php
│   ├── visual.php
│   ├── bloodlist.php
│
├── 📂 auth/
│   ├── login.php
│   ├── signup.php
│
├── 📂 donor/
│   ├── donor.php
│   ├── donarform.php
│   ├── kidney.php
│   ├── liver.php
│
├── 📂 recipient/
│   ├── recipient.php
│   ├── recipientform.php
│
├── 📂 blood/
│   ├── blood.php
│
├── 📂 config/
│   ├── db.php
│
└── index.php


⚙️ Installation Guide

1️⃣ Move Project to XAMPP

C:\xampp\htdocs\project-odm

2️⃣ Start Server

Start Apache

Start MySQL


3️⃣ Setup Database

Open: http://localhost/phpmyadmin

Create database: organdonationn

Import your SQL file


4️⃣ Run the Application

http://localhost/project-odm


🎯 Project Objective

To develop a centralized web-based system that:

Digitizes organ and blood donation records

Improves donor–recipient matching efficiency

Reduces manual paperwork

Enhances healthcare data management

Supports faster emergency decision-making using visualization


🚀 Future Enhancements

Email Notifications

SMS Alerts

Advanced Filtering System

Hospital API Integration

Cloud Deployment

Enhanced Analytics Dashboard

👨‍💻 Developed By

Haritha CP
Final Year Web Development Project
Built Using PHP & MySQL
