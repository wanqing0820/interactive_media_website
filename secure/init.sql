-- TODO: Put ALL SQL in between `BEGIN TRANSACTION` and `COMMIT`
BEGIN TRANSACTION;

-- TODO: create tables

-- CREATE TABLE `examples` (
-- 	`id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
-- 	`name`	TEXT NOT NULL
-- );


CREATE TABLE images (
	id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	file_name TEXT NOT NULL,
	file_ext TEXT NOT NULL,
	description TEXT NOT NULL
);

CREATE TABLE tags (
    id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
    name TEXT NOT NULL UNIQUE
);

CREATE TABLE image_tag (
	id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	image_id INTEGER,
	tag_id INTEGER
);

-- TODO: initial seed data

-- INSERT INTO `examples` (id,name) VALUES (1, 'example-1');
-- INSERT INTO `examples` (id,name) VALUES (2, 'example-2');

INSERT INTO images (id, file_name, file_ext, description) VALUES (1, 'mon.jpg', 'jpg', 'casual');
INSERT INTO images (id, file_name, file_ext, description) VALUES (2, 'tue.jpg', 'jpg','her pick');
INSERT INTO images (id, file_name, file_ext, description) VALUES (3, 'wed.jpg', 'jpg','casual');
INSERT INTO images (id, file_name, file_ext, description) VALUES (4, 'thu.jpg', 'jpg','casual');
INSERT INTO images (id, file_name, file_ext, description) VALUES (5, 'fri.jpg', 'jpg','casual');
INSERT INTO images (id, file_name, file_ext, description) VALUES (6, 'sat.jpg', 'jpg','casual');
INSERT INTO images (id, file_name, file_ext, description) VALUES (7, 'sun.jpg', 'jpg','casual');
INSERT INTO images (id, file_name, file_ext, description) VALUES (8, 'mon2.jpg', 'jpg','casual');
INSERT INTO images (id, file_name, file_ext, description) VALUES (9, 'tue2.jpg', 'jpg','casual');
INSERT INTO images (id, file_name, file_ext, description) VALUES (10, 'wed2.jpg', 'jpg','casual');


INSERT INTO tags (id, name) VALUES (1, 'yellow');
INSERT INTO tags (id, name) VALUES (2, 'pink');
INSERT INTO tags (id, name) VALUES (3, 'blue');
INSERT INTO tags (id, name) VALUES (4, 'black');
INSERT INTO tags (id, name) VALUES (5, 'white');
INSERT INTO tags (id, name) VALUES (6, 'vintage');
INSERT INTO tags (id, name) VALUES (7, 'InstaFashion');
INSERT INTO tags (id, name) VALUES (8, 'OOTD');
INSERT INTO tags (id, name) VALUES (9, 'all');


INSERT INTO image_tag (id, image_id, tag_id) VALUES (1, 1, 2);
INSERT INTO image_tag (id, image_id, tag_id) VALUES (2, 1, 7);
INSERT INTO image_tag (id, image_id, tag_id) VALUES (3, 1, 8);
INSERT INTO image_tag (id, image_id, tag_id) VALUES (4, 2, 5);
INSERT INTO image_tag (id, image_id, tag_id) VALUES (5, 3, 2);
INSERT INTO image_tag (id, image_id, tag_id) VALUES (6, 4, 8);
INSERT INTO image_tag (id, image_id, tag_id) VALUES (7, 5, 8);
INSERT INTO image_tag (id, image_id, tag_id) VALUES (8, 6, 8);
INSERT INTO image_tag (id, image_id, tag_id) VALUES (9, 7, 8);
INSERT INTO image_tag (id, image_id, tag_id) VALUES (10, 8, 8);
INSERT INTO image_tag (id, image_id, tag_id) VALUES (11, 9, 8);
INSERT INTO image_tag (id, image_id, tag_id) VALUES (12, 10, 8);
INSERT INTO image_tag (id, image_id, tag_id) VALUES (13, 10, 2);
INSERT INTO image_tag (id, image_id, tag_id) VALUES (14, 9, 2);

COMMIT;
