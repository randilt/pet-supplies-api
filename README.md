# Pawsome - Pet Supplies eCommerce Store

## Overview

Pawsome is an application for a pet supplies eCommerce store built with php, tailwind css, javascript, and dockerized to be easily pulled and run on any machine with Docker installed. This project aims to provide an online platform for pet product sales and management.

## Prerequisites

To run the application, ensure that Docker is installed on your system. You can download Docker from [here](https://www.docker.com/get-started).

## Running the Application

### 1. Pull the Docker Image

Start by pulling the pre-built Docker image from Docker Hub with the following command:

```bash
docker pull randiltharusha/pawsome
```

### 2. Run the Docker Container

Run the Docker container with the following command:

```bash
docker run -d -p 8080:80 randiltharusha/pawsome
```

### 3. Access the Application

Open your browser and navigate to `http://localhost:8080` to access the application.

## Features

- User authentication
- Product management
- Shopping cart
- Order management
- User profile management
- Admin dashboard
- Responsive design

## You can access the PhpMyAdmin using the following credentials:

- **URL:** `http://localhost:8081
- **Server:** `mysql`
- **Username:** `root`
- **Password:** `rootpassword`
