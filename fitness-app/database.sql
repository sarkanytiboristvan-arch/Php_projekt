-- Fitness Tracker Database Schema
-- Created for Web Programming Course 2025-2026

-- Drop and recreate database for clean install
DROP DATABASE IF EXISTS fitness_tracker;
CREATE DATABASE fitness_tracker CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Use the database
USE fitness_tracker;

-- Users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    age INT DEFAULT NULL,
    gender ENUM('male', 'female', 'other') DEFAULT NULL,
    height DECIMAL(5,2) DEFAULT NULL COMMENT 'Height in cm',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Workouts table
CREATE TABLE workouts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(100) NOT NULL,
    type VARCHAR(50) NOT NULL,
    duration INT NOT NULL COMMENT 'Duration in minutes',
    calories_burned INT NOT NULL,
    notes TEXT,
    workout_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_date (user_id, workout_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Nutrition table
CREATE TABLE nutrition (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    meal_type VARCHAR(50) NOT NULL,
    food_name VARCHAR(100) NOT NULL,
    calories INT NOT NULL,
    protein DECIMAL(6,2) DEFAULT 0,
    carbs DECIMAL(6,2) DEFAULT 0,
    fats DECIMAL(6,2) DEFAULT 0,
    meal_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_date (user_id, meal_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Progress table (body measurements)
CREATE TABLE progress (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    weight DECIMAL(5,2) NOT NULL COMMENT 'Weight in kg',
    body_fat DECIMAL(4,2) DEFAULT NULL COMMENT 'Body fat percentage',
    chest DECIMAL(5,2) DEFAULT NULL COMMENT 'Chest measurement in cm',
    waist DECIMAL(5,2) DEFAULT NULL COMMENT 'Waist measurement in cm',
    hips DECIMAL(5,2) DEFAULT NULL COMMENT 'Hips measurement in cm',
    notes TEXT,
    measurement_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_date (user_id, measurement_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Workout Plans table
CREATE TABLE workout_plans (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    duration_weeks INT NOT NULL,
    difficulty ENUM('Kezdő', 'Haladó', 'Professzionális') NOT NULL,
    goals TEXT,
    is_template BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user (user_id),
    INDEX idx_template (is_template)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert a demo user (password is "password123")
-- Password hash created with: password_hash('password123', PASSWORD_DEFAULT)
INSERT INTO users (name, email, password, age, gender, height, created_at) VALUES
('Demo Felhasználó', 'demo@fitness.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 30, 'male', 180.00, NOW());

-- Get the demo user ID for subsequent inserts
SET @demo_user_id = LAST_INSERT_ID();

-- Insert sample workout plan templates
INSERT INTO workout_plans (user_id, name, description, duration_weeks, difficulty, goals, is_template, created_at) VALUES
(@demo_user_id, 'Kezdő Cardio Program', 'Alapvető kardió edzésterv kezdőknek. Fokozatosan növekvő intenzitással, hetente 3-4 alkalommal.', 8, 'Kezdő', 'Állóképesség fejlesztése, alapvető kondíció kialakítása, zsírégetés', TRUE, NOW()),
(@demo_user_id, 'Erősítő Program', 'Teljes test erősítő program súlyzókkal és gépekkel. Hetente 4-5 alkalommal, split edzésterv.', 12, 'Haladó', 'Izomtömeg növelés, erő fejlesztés, testformálás', TRUE, NOW()),
(@demo_user_id, 'Fogyókúra Terv', 'Intenzív zsírégető program, kombinálva cardióval és erősítéssel. Napi edzéssel, kalóriadeficittel.', 10, 'Haladó', 'Fogyás, testzsír csökkentés, fitt megjelenés', TRUE, NOW());

-- Insert some sample workouts for the demo user
INSERT INTO workouts (user_id, title, type, duration, calories_burned, notes, workout_date, created_at) VALUES
(@demo_user_id, 'Reggeli futás', 'Futás', 30, 300, 'Könnyű tempó, park körül', CURDATE() - INTERVAL 2 DAY, NOW()),
(@demo_user_id, 'Mellkas és tricepsz', 'Erőnléti', 60, 250, 'Nyomógyakorlatok', CURDATE() - INTERVAL 1 DAY, NOW()),
(@demo_user_id, 'HIIT edzés', 'Kardió', 25, 350, 'Intenzív intervallum tréning', CURDATE(), NOW());

-- Insert some sample nutrition entries
INSERT INTO nutrition (user_id, meal_type, food_name, calories, protein, carbs, fats, meal_date, created_at) VALUES
(@demo_user_id, 'Reggeli', 'Zabkása gyümölccsel', 350, 12.0, 55.0, 8.0, CURDATE(), NOW()),
(@demo_user_id, 'Ebéd', 'Csirkemell rizzsel és zöldséggel', 520, 45.0, 60.0, 10.0, CURDATE(), NOW()),
(@demo_user_id, 'Vacsora', 'Lazac spenóttal', 420, 38.0, 15.0, 25.0, CURDATE(), NOW());

-- Insert a sample progress entry
INSERT INTO progress (user_id, weight, body_fat, chest, waist, hips, notes, measurement_date, created_at) VALUES
(@demo_user_id, 82.5, 15.5, 100.0, 85.0, 95.0, 'Kezdő mérés', CURDATE(), NOW());

-- Success message
SELECT 'Adatbazis sikeresen letrehozva!' AS Uzenet;
SELECT 'Demo felhasznalo: demo@fitness.com / password123' AS Info;
