CREATE DATABASE IF NOT EXISTS markanperformance
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE markanperformance;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin', 'customer') NOT NULL DEFAULT 'customer',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS cars (
  id INT AUTO_INCREMENT PRIMARY KEY,
  brand VARCHAR(50) NOT NULL,
  model VARCHAR(50) NOT NULL,
  year INT NOT NULL,
  price INT NOT NULL,
  description TEXT,
  image VARCHAR(255) DEFAULT NULL,
  status ENUM('available', 'pending', 'sold') NOT NULL DEFAULT 'available',
  owner_id INT DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (owner_id) REFERENCES users(id) ON DELETE SET NULL
);

INSERT INTO users (username, password, role) VALUES
('admin',    '$2y$10$YQgozEOl2fon8/iGHF3SOue4al8jzYLzhGW6jdMCO8f7SEopT/knS', 'admin'),
('customer', '$2y$10$x92E.Ige6ffvcLtHFgXbFuZvIxkXn/tfFVCxzV3MvsATCrF.Tw2OO', 'customer');

INSERT INTO cars (brand, model, year, price, description, image, status, owner_id) VALUES
('Audi',          'R8',              2007, 89900,   'Prva generacija Audijevog supersportskog automobila s 4.2 V8 motorom (420 KS) i quattro pogonom na sve kotače. Audijev prvi pravi suparnik Porscheu 911.',              'audi_r8.jpg',                  'available', NULL),
('Bugatti',       'Veyron',          2005, 1650000, 'Prvi hipersportski automobil s preko 1000 KS - 8.0 W16 motor s četiri turbopunjača i vrhunskom brzinom preko 400 km/h. Jedan od najpoznatijih automobila svih vremena.', 'bugatti_veyron.jpg',           'available', NULL),
('Ferrari',       'F430',            2004, 139900,  'Naslijednik modela 360 Modena s novim 4.3 V8 motorom (490 KS) i F1-tehnologijom poput E-Diff elektroničkog diferencijala.',                                              'ferrari_f430.jpg',             'available', NULL),
('Lamborghini',   'Gallardo',        2003, 119900,  'Prvi pristupačniji Lamborghini i najprodavaniji model marke. Pogon na sve kotače i 5.0 V10 motor s 500 KS.',                                                               'lamborghini_gallardo.jpg',     'available', NULL),
('Mercedes-Benz', 'SLR McLaren',     2003, 329900,  'Zajednički projekt Mercedesa i McLarena - prednji V8 motor s kompresorom (617 KS) u luksuznom GT vozilu razvijenom uz Formulu 1.',                                         'mercedes_benz_slr_mclaren.jpg','available', NULL),
('BMW',           'M5',              2004, 64900,   'Legendarna limuzina s 5.0 V10 motorom (500 KS) razvijenim na temelju Formule 1 - prva M5 generacija s desetcilindričnim motorom.',                                         'bmw_m5.jpg',                   'pending',   2),
('Audi',          'RS4',             2005, 54900,   'Sportska verzija modela A4 s 4.2 V8 motorom (414 KS) i quattro pogonom. Poznata po izvanrednoj ravnoteži i jurećim performansama.',                                        'audi_rs4.jpg',                 'sold',      2),
('Bentley',       'Continental GT',  2003, 169900,  'Prvi moderni Bentley pod Volkswagen Groupom - 6.0 W12 motor s dva turbopunjača (552 KS) u luksuznom GT kupeu s pogonom na sve kotače.',                                    'bentley_continental_gt.jpg',   'pending',   2),
('Rolls-Royce',   'Phantom',         2003, 219900,  'Prvi Rolls-Royce proizveden pod BMW-om - vrhunac luksuza s ručno sastavljenim 6.75 V12 motorom (453 KS) i aluminijskom karoserijom.',                                      'rolls_royce_phantom.jpg',      'sold',      2);
