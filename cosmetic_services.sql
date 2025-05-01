CREATE TABLE IF NOT EXISTS cosmetic_services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    category VARCHAR(255),
    time_length INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    rating TINYINT
);



INSERT INTO cosmetic_services (name, category, description, time_length, price, rating) 
VALUES 
('Подстригване на жени', 'Коса', 'Коса', 45 , 25.00, 5),
('Боядисване на коса', 'Коса', 'Коса', 90 , 60.00, 4),
('Маникюр с гел лак', 'Нокти', 'Нокти', 60 , 35.00, 5),
('Педикюр', 'Нокти', 'Нокти', 50 , 30.00, 4),
('Почистване на лице', 'Лице', 'Лице', 70, 45.00, 4),
('Релаксиращ масаж', 'Масажи', 'Масажи', 60, 50.00, 5),
('Терапия с арганово масло', 'Коса', 'Коса', 30, 20.00, 4),
('Оформяне на брада', 'Коса', 'Коса', 30, 15.00, 4),
('Изправяне с преса', 'Коса', 'Коса', 40, 20.00, 4),
('Удължаване на нокти', 'Нокти', 'Нокти', 90, 60.00, 5),
('Декорация на нокти', 'Нокти', 'Нокти', 30, 15.00, 4),
('Хидратираща маска за лице', 'Лице', 'Лице', 40, 25.00, 4),
('Анти-акне терапия', 'Лице', 'Лице', 60, 40.00, 5),
('Антицелулитен масаж', 'Масажи', 'Масажи', 50, 45.00, 4),
('Ароматерапевтичен масаж', 'Масажи', 'Масажи', 75, 55.00, 5);

UPDATE cosmetic_services 
SET time_length = 45, rating = 5 
WHERE id = 1;

UPDATE cosmetic_services 
SET time_length = 90, rating = 4 
WHERE id = 2;

UPDATE cosmetic_services 
SET time_length = 60, rating = 5 
WHERE id = 3;

UPDATE cosmetic_services 
SET time_length = 50, rating = 4 
WHERE id = 4;


SELECT * FROM cosmetic_services WHERE description IS NOT NULL;
