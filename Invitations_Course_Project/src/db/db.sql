DROP DATABASE IF EXISTS invitations;

CREATE DATABASE invitations;

USE invitations;

CREATE TABLE users(
  fn INT PRIMARY KEY,
  email VARCHAR(30) NOT NULL UNIQUE,
  password VARCHAR(500) NOT NULL,
  first_name VARCHAR(50) NOT NULL,
  last_name VARCHAR(50) NOT NULL,
  course INT NOT NULL,
  specialty VARCHAR(50) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE invitations(
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  title VARCHAR(100) NOT NULL UNIQUE,
  place VARCHAR(50) NOT NULL,
  date date NOT NULL, 
  time time NOT NULL,
  end_time time NOT NULL,
  filename VARCHAR(30),
  presenter_fn INT REFERENCES users(fn) ON DELETE SET NULL,
  UNIQUE KEY unique_time(date, time)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE likes(
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  fn INT NOT NULL REFERENCES users(fn) ON DELETE CASCADE,
  invitation_id INT NOT NULL REFERENCES invitations(id) ON DELETE CASCADE,
  CONSTRAINT likes_constraint UNIQUE (fn, invitation_id)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;