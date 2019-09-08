/* TODO: create tables */
CREATE TABLE users (
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  first_name TEXT NOT NULL,
  last_name TEXT NOT NULL,
  email TEXT NOT NULL UNIQUE,
  password TEXT NOT NULL,
  session TEXT UNIQUE
);

CREATE TABLE photo_database (
  file_id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  folder TEXT,
  file_name TEXT NOT NULL UNIQUE,
  file_extension TEXT NOT NULL,
  file_size NUMBER NOT NULL,
  uploader INTEGER NOT NULL,
  FOREIGN KEY (uploader) REFERENCES users(id)
);

CREATE TABLE tags (
  tag_id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  tag_name TEXT NOT NULL UNIQUE
);

CREATE TABLE photo_tags (
  tag INTEGER NOT NULL,
  photo INTEGER NOT NULL,
  FOREIGN KEY (tag) REFERENCES tags(tag_id),
  FOREIGN KEY (photo) REFERENCES photo_database(file_id)
);

/* TODO: initial seed data */
/* USERS */
INSERT INTO users (id, first_name, last_name, email, password) VALUES (0, 'Constantin', 'Miranda', 'cym8@cornell.edu', '$2y$10$KCx5x73RLmUSUNR5YbUqluyAtCvFKHAM21Gu2Hp0KlpVCoM1mNdhu');
INSERT INTO users (first_name, last_name, email, password) VALUES ('Info2300', 'Instructor', 'user2@gmail.com', '$2y$10$QOPBWxfFQE68.rlFPSlCxe3Mc1qKzBzqlndlYeB2icz7Pkn2ANOj.');

/* PHOTO DATABASE */
INSERT INTO photo_database (file_id, folder, file_name, file_extension, file_size, uploader) VALUES (1, 'seed', 'photo1', 'jpg', 275000, 0);
INSERT INTO photo_database (folder, file_name, file_extension, file_size, uploader) VALUES ('seed', 'photo2', 'jpg', 309000, 0);
INSERT INTO photo_database (folder, file_name, file_extension, file_size, uploader) VALUES ('seed', 'photo3', 'jpg', 310000, 0);
INSERT INTO photo_database (folder, file_name, file_extension, file_size, uploader) VALUES ('seed', 'photo4', 'jpg', 791000, 0);
INSERT INTO photo_database (folder, file_name, file_extension, file_size, uploader) VALUES ('seed', 'photo5', 'jpg', 668000, 0);
INSERT INTO photo_database (folder, file_name, file_extension, file_size, uploader) VALUES ('seed', 'photo6', 'jpg', 673000, 1);
INSERT INTO photo_database (folder, file_name, file_extension, file_size, uploader) VALUES ('seed', 'photo7', 'jpg', 421000, 1);
INSERT INTO photo_database (folder, file_name, file_extension, file_size, uploader) VALUES ('seed', 'photo8', 'jpg', 465000, 1);
INSERT INTO photo_database (folder, file_name, file_extension, file_size, uploader) VALUES ('seed', 'photo9', 'jpg', 251000, 1);
INSERT INTO photo_database (folder, file_name, file_extension, file_size, uploader) VALUES ('seed', 'photo10', 'jpg', 287000, 1);

/* TAGS */
  INSERT INTO tags (tag_id, tag_name) VALUES (1, 'FLAGS');
  INSERT INTO tags (tag_name) VALUES ('BLUE');
  INSERT INTO tags (tag_name) VALUES ('RUSSIA');
  INSERT INTO tags (tag_name) VALUES ('DOG');
  INSERT INTO tags (tag_name) VALUES ('OUTDOORS');
  INSERT INTO tags (tag_name) VALUES ('FIRE');
  INSERT INTO tags (tag_name) VALUES ('ORANGE');
  INSERT INTO tags (tag_name) VALUES ('HOME');
  INSERT INTO tags (tag_name) VALUES ('GRAYSCALE');
  INSERT INTO tags (tag_name) VALUES ('SKI');
  INSERT INTO tags (tag_name) VALUES ('IDAHO');
  INSERT INTO tags (tag_name) VALUES ('HIKE');
  INSERT INTO tags (tag_name) VALUES ('CAR');

/* PHOTO_TAGS */
  INSERT INTO photo_tags (tag, photo) VALUES (1, 1);

  INSERT INTO photo_tags (tag, photo) VALUES (2, 1);
  INSERT INTO photo_tags (tag, photo) VALUES (2, 2);
  INSERT INTO photo_tags (tag, photo) VALUES (2, 9);

  INSERT INTO photo_tags (tag, photo) VALUES (3, 1);
  INSERT INTO photo_tags (tag, photo) VALUES (3, 10);

  INSERT INTO photo_tags (tag, photo) VALUES (4, 2);

  INSERT INTO photo_tags (tag, photo) VALUES (5, 2);

  INSERT INTO photo_tags (tag, photo) VALUES (6, 3);
  INSERT INTO photo_tags (tag, photo) VALUES (6, 7);
  INSERT INTO photo_tags (tag, photo) VALUES (6, 8);

  INSERT INTO photo_tags (tag, photo) VALUES (7, 3);
  INSERT INTO photo_tags (tag, photo) VALUES (7, 7);
  INSERT INTO photo_tags (tag, photo) VALUES (7, 8);
  INSERT INTO photo_tags (tag, photo) VALUES (7, 10);

  INSERT INTO photo_tags (tag, photo) VALUES (8, 3);
  INSERT INTO photo_tags (tag, photo) VALUES (8, 7);
  INSERT INTO photo_tags (tag, photo) VALUES (8, 8);

  INSERT INTO photo_tags (tag, photo) VALUES (9, 4);
  INSERT INTO photo_tags (tag, photo) VALUES (9, 5);
  INSERT INTO photo_tags (tag, photo) VALUES (9, 6);

  INSERT INTO photo_tags (tag, photo) VALUES (10, 4);

  INSERT INTO photo_tags (tag, photo) VALUES (11, 4);
  INSERT INTO photo_tags (tag, photo) VALUES (11, 5);
  INSERT INTO photo_tags (tag, photo) VALUES (11, 6);

  INSERT INTO photo_tags (tag, photo) VALUES (12, 5);
  INSERT INTO photo_tags (tag, photo) VALUES (12, 6);

  INSERT INTO photo_tags (tag, photo) VALUES (13, 9);
