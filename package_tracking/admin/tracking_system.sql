CREATE TABLE admin (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL,
  password VARCHAR(255) NOT NULL
);

INSERT INTO admin (username, password)
VALUES ('admin', MD5('12345'));  -- login: admin / password: 12345


CREATE TABLE packages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  tracking_id VARCHAR(50) NOT NULL,
  sender_name VARCHAR(100),
  receiver_name VARCHAR(100),
  status VARCHAR(50),
  last_update DATETIME,
  notes TEXT
);
