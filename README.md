# carpool-WEBAPP

## Introduction

The purpose of this project is to develop an application that aims to overcome the hassle of traveling. The Car Pooling System is a web application designed to create an environmentally friendly and cost-effective way of commuting. This platform connects drivers traveling alone to work with fellow passengers, and those who use public transport can find drivers heading to the same destination. The project enables users to access mobility assets owned by others when they need them, showing available cars for pickup based on the interest of car owners, including time and capacity.

## Problem Statement: Carpool Website

The inspiration behind our project stems from a deep understanding of the challenges faced by modern commuters. Traditional transportation systems often contribute to traffic gridlock, pollution, and increased stress levels. Our carpool website addresses the following key problems:

1. **Traffic Congestion**: Reducing the number of individual vehicles on the road to optimize transportation resources and alleviate urban traffic congestion.
2. **Environmental Impact**: Promoting carpooling to significantly decrease air pollution and carbon emissions.
3. **Economic Strain**: Sharing travel expenses to make commuting more economical for participants.
4. **Social Isolation**: Fostering a sense of community by encouraging social interactions during commutes.

## Technologies Used

### Front-End
- **HTML**
- **CSS**
- **JavaScript**

### Back-End
- **XAMPP Stack**
  - **Apache**: Web server
  - **MySQL**: Relational database management system
  - **PHP**: Server-side scripting language

## Potential Users

1. **Daily Commuters**: Regular commuters seeking a cost-effective, eco-friendly alternative.
2. **Students**: University and college students looking to share rides.
3. **Professionals**: Working professionals interested in reducing fuel and parking expenses.
4. **Environmental Enthusiasts**: Individuals committed to reducing their carbon footprint.
5. **Social Connectors**: People looking to build social connections during commutes.
6. **Event Attendees**: Individuals coordinating transportation for events or gatherings.
7. **Eco-Conscious Travelers**: Travelers seeking eco-friendly options to reach transport terminals.

## Instructions to Run the Project

### Prerequisites

1. **XAMPP**: Download and install XAMPP from [Apache Friends](https://www.apachefriends.org/index.html).
2. **MySQL**: Included in the XAMPP package.

### Setup

1. **Clone the Repository**: Clone the project repository from GitHub to your local machine.
    ```bash
    git clone https://github.com/your-username/carpooldb.git
    ```

2. **XAMPP Installation**: Ensure XAMPP is installed and running on your machine.

3. **Database Setup**:
    - Start the Apache and MySQL services from the XAMPP control panel.
    - Open phpMyAdmin by navigating to `http://localhost/phpmyadmin/` in your web browser.
    - Create a new database named `carpooldb`.
    - Import the `carpooldb.sql` file provided in the project repository into the `carpooldb` database.

4. **Project Files**:
    - Copy the project files into the `htdocs` directory of your XAMPP installation (typically located at `C:\xampp\htdocs\` on Windows or `/Applications/XAMPP/htdocs/` on macOS).
    - Ensure the main project folder is named `carpooldb`.

5. **Configuration**:
    - Open the `config.php` file in the project directory and update the database connection settings if necessary.
    ```php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "carpooldb";
    ```

### Running the Project

1. Open your web browser and navigate to `http://localhost/carpooldb/`.
2. You should see the homepage of the Car Pooling System web application.

### Notes

- Ensure the `carpooldb` folder and all its files are correctly placed in the `htdocs` directory.
- Make sure Apache and MySQL services are running before accessing the web application.
- For any issues or further customization, refer to the project documentation and code comments.

## Conclusion

This Car Pooling System project demonstrates practical applications of web technologies and data structures to create an efficient and user-friendly carpooling platform. By leveraging HTML, CSS, JavaScript, PHP, and MySQL, we aim to provide a sustainable solution for daily commuting challenges.
