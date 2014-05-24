-- Create all WWC tables, execpt table superuser.

CREATE TABLE worker
(
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(25) NOT NULL,
  author VARCHAR(50) NOT NULL,
  email VARCHAR(50) NOT NULL,
  ts TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE(name)
);

CREATE TABLE chart
(
  player INT NOT NULL,
  points INT NOT NULL,
  wins INT NOT NULL,
  defeats INT NOT NULL,
  FOREIGN KEY (player) REFERENCES worker(id),
  PRIMARY KEY(player)
);

CREATE TABLE game
(
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  player1 INT,
  player2 INT,
  points1 INT NOT NULL,
  points2 INT NOT NULL,
  ts TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (player1) REFERENCES worker(id),
  FOREIGN KEY (player2) REFERENCES worker(id)
);

CREATE TABLE score
(
  player1 INT NOT NULL,
  player2 INT NOT NULL,
  points1 INT NOT NULL,
  points2 INT NOT NULL,
  FOREIGN KEY (player1) REFERENCES worker(id),
  FOREIGN KEY (player2) REFERENCES worker(id),
  PRIMARY KEY(player1, player2)
);

CREATE TABLE winner
(
  daystamp Date NOT NULL,
  player INT,
  FOREIGN KEY (player) REFERENCES worker(id),
  PRIMARY KEY(daystamp)
);

CREATE TABLE challenger
(
  player INT NOT NULL,
  FOREIGN KEY (player) REFERENCES worker(id),
  PRIMARY KEY(player)
);

CREATE TABLE activechallenger
(
  player INT NOT NULL,
  FOREIGN KEY (player) REFERENCES worker(id),
  PRIMARY KEY(player)
);

CREATE TABLE droppedworker
(
  player INT NOT NULL,
  FOREIGN KEY (player) REFERENCES worker(id),
  PRIMARY KEY(player)
)