-- Table: admin
CREATE TABLE IF NOT EXISTS admin (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    image VARCHAR(255)
);

-- Table: region
CREATE TABLE IF NOT EXISTS region (
    region_id INT AUTO_INCREMENT PRIMARY KEY,
    region_name VARCHAR(50) NOT NULL UNIQUE
);

-- Table: zone
CREATE TABLE IF NOT EXISTS zone (
    zone_id INT AUTO_INCREMENT PRIMARY KEY,
    zone_name VARCHAR(50) NOT NULL,
    region_id INT,
    FOREIGN KEY (region_id) REFERENCES region(region_id) ON DELETE CASCADE
);

-- Table: woreda
CREATE TABLE IF NOT EXISTS woreda (
    woreda_id INT AUTO_INCREMENT PRIMARY KEY,
    woreda_name VARCHAR(50) NOT NULL,
    zone_id INT,
    FOREIGN KEY (zone_id) REFERENCES zone(zone_id) ON DELETE CASCADE
);

-- Table: city
CREATE TABLE IF NOT EXISTS city (
    city_id INT AUTO_INCREMENT PRIMARY KEY,
    city_name VARCHAR(50) NOT NULL UNIQUE,
    woreda_id INT,
    FOREIGN KEY (woreda_id) REFERENCES woreda(woreda_id) ON DELETE CASCADE
);

-- Table: kebele
CREATE TABLE IF NOT EXISTS kebele (
    kebele_id INT AUTO_INCREMENT PRIMARY KEY,
    kebele_name VARCHAR(50) NOT NULL,
    city_id INT,
    FOREIGN KEY (city_id) REFERENCES city(city_id) ON DELETE CASCADE
);

-- Table: moderator
CREATE TABLE IF NOT EXISTS moderator (
    moderator_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    image VARCHAR(255),
    city_id INT,
    status ENUM('active', 'inactive') DEFAULT 'active',
    FOREIGN KEY (city_id) REFERENCES city(city_id) ON DELETE CASCADE
);


-- Table: kebeleModerator
CREATE TABLE IF NOT EXISTS kebeleModerator (
    kebeleModerator_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    image VARCHAR(255),
    moderator_id INT,
    kebele_id INT,
    status ENUM('active', 'inactive') DEFAULT 'active',
    FOREIGN KEY (moderator_id) REFERENCES moderator(moderator_id) ON DELETE CASCADE,
    FOREIGN KEY (kebele_id) REFERENCES kebele(kebele_id) ON DELETE CASCADE
);

-- Table: residents
CREATE TABLE IF NOT EXISTS residents (
    resident_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    image VARCHAR(255),
    national_id VARCHAR(255) NOT NULL UNIQUE,
    gender ENUM('male', 'female') NOT NULL,
    date_of_birth DATE NOT NULL,
    expiration_date DATE,
    phone_number VARCHAR(20),
    email VARCHAR(100) UNIQUE,
    marital_status ENUM('single', 'married', 'divorced', 'widowed'),
    number_of_dependents INT,
    emergency_contact_name VARCHAR(100),
    emergency_contact_phone VARCHAR(20),
    blood_type ENUM('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    region_id INT,
    zone_id INT,
    woreda_id INT,
    city_id INT,
    kebele_id INT,
    status ENUM('pending', 'approved','requested', 'disapproved') DEFAULT 'pending',
    FOREIGN KEY (region_id) REFERENCES region(region_id) ON DELETE CASCADE,
    FOREIGN KEY (zone_id) REFERENCES zone(zone_id) ON DELETE CASCADE,
    FOREIGN KEY (woreda_id) REFERENCES woreda(woreda_id) ON DELETE CASCADE,
    FOREIGN KEY (city_id) REFERENCES city(city_id) ON DELETE CASCADE,
    FOREIGN KEY (kebele_id) REFERENCES kebele(kebele_id) ON DELETE CASCADE
);
CREATE TABLE IF NOT EXISTS notices (
    notice_id INT AUTO_INCREMENT PRIMARY KEY,
    notice_title VARCHAR(255) NOT NULL,
    notice_content TEXT,
    notice_images TEXT,
    notice_posted_by VARCHAR(100),
    notice_posted_role VARCHAR(100),
    notice_posted_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS comments (
    comment_id INT AUTO_INCREMENT PRIMARY KEY,
    notice_id INT,
    resident_id INT,
    comment_content TEXT,
    comment_posted_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (notice_id) REFERENCES notices(notice_id),
    FOREIGN KEY (resident_id) REFERENCES student(resident_id)
);