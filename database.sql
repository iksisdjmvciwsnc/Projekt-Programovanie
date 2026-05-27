CREATE DATABASE film_app;
USE film_app;

-- 1. tabuľka (filmy / knihy)
CREATE TABLE media (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    type VARCHAR(50),
    year INT,
    rating INT
);

-- 2. tabuľka (napr. používatelia)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(100)
);

-- test dáta
INSERT INTO media (title, type, year, rating) VALUES
('Inception', 'film', 2010, 9),
('Harry Potter', 'kniha', 1997, 10);

INSERT INTO users (username, email) VALUES
('admin', 'admin@test.com'),
('jano', 'jano@test.com');