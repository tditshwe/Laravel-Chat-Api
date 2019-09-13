CREATE TABLE IF NOT EXISTS user(
    username VARCHAR(20) PRIMARY KEY NOT NULL,
    display_name VARCHAR(30) NOT NULL,
    password VARCHAR(50) NOT NULL,
    api_token VARCHAR(80),
    status VARCHAR(80) NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    profile_image VARCHAR(30),
    remember_token TINYINT NOT NULL);

CREATE TABLE IF NOT EXISTS chat(
    id int PRIMARY KEY AUTO_INCREMENT NOT NULL,
    last_message int,
    is_group TINYINT NOT NULL,
    sender VARCHAR(20) NOT NULL,
    receiver VARCHAR(20) NOT NULL,
    FOREIGN KEY (sender) REFERENCES user(username),
    FOREIGN KEY (receiver) REFERENCES user(username));

CREATE TABLE IF NOT EXISTS `group`(
    id int PRIMARY KEY AUTO_INCREMENT NOT NULL,
    name VARCHAR(30) NOT NULL,
    creator VARCHAR(20) NOT NULL,
    FOREIGN KEY (creator) REFERENCES user(username));

CREATE TABLE IF NOT EXISTS message(
    id int PRIMARY KEY AUTO_INCREMENT NOT NULL,
    text VARCHAR(150) NOT NULL,
    date_sent DATETIME NOT NULL,
    sender VARCHAR(20) NOT NULL,
    FOREIGN KEY (sender) REFERENCES user(username));

