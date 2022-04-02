CREATE TABLE Users
(
  user_id SERIAL,
  username VARCHAR(40) NOT NULL,
  user_password VARCHAR(64) NOT NULL,
  xp INT DEFAULT 0,
  user_level INT DEFAULT 1,
  PRIMARY KEY (user_id)
);