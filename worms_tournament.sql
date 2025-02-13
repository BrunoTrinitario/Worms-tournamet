CREATE DATABASE worms_tournament;

USE worms_tournament;

CREATE TABLE game (
  id int PRIMARY KEY AUTO_INCREMENT,
  game_date date NOT NULL,
  description varchar(255) DEFAULT NULL
);

CREATE TABLE person (
  id int(11) PRIMARY KEY AUTO_INCREMENT,
  nick varchar(50) NOT NULL
);

CREATE TABLE persongame (
  person_id int(11) NOT NULL,
  game_id int(11) NOT NULL,
  points double DEFAULT NULL,
  mvp_points double DEFAULT NULL,
  damage_points double DEFAULT NULL,
  quantity_points double DEFAULT NULL,
  PRIMARY KEY (person_id, game_id);
  FOREIGN KEY (game_id) REFERENCES game(id) ON DELETE CASCADE,
  FOREIGN KEY (person_id) REFERENCES person(id) ON DELETE CASCADE
);

CREATE TABLE game_data (
  id int(11) PRIMARY KEY AUTO_INCREMENT,
  game_id int(11) NOT NULL,
  description text NOT NULL,
  worms_quantity int(11) NOT NULL CHECK (worms_quantity >= 0),
  worms_hp int(11) NOT NULL CHECK (worms_hp >= 0),
  FOREIGN KEY (game_id) REFERENCES game(id) ON DELETE CASCADE
);

