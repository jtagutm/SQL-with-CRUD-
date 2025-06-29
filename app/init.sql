CREATE TABLE IF NOT EXISTS actores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    nacionalidad VARCHAR(100),
    nacimiento YEAR,
    genero ENUM('M', 'F', 'Otro'),
    premio VARCHAR(255),
    activo BOOLEAN
);

CREATE TABLE IF NOT EXISTS directores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    nacionalidad VARCHAR(100),
    nacimiento YEAR,
    genero ENUM('M', 'F', 'Otro'),
    peliculas_dirigidas INT DEFAULT 0
);

CREATE TABLE IF NOT EXISTS peliculas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    anio YEAR,
    actor_id INT,
    director_id INT,
    FOREIGN KEY (actor_id) REFERENCES actores(id) ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY (director_id) REFERENCES directores(id) ON DELETE SET NULL ON UPDATE CASCADE
);
