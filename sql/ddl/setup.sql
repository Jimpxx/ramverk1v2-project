PRAGMA foreign_keys = ON;


--
-- Dropping tables
--

DROP TABLE IF EXISTS TagsPost;
DROP TABLE IF EXISTS Comment;
DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS Post;
DROP TABLE IF EXISTS Tags;


--
-- Creating tables.
--


--
-- Table User
--
CREATE TABLE User (
    "id" INTEGER PRIMARY KEY,
    "username" TEXT UNIQUE,
    "email" TEXT UNIQUE,
    "password" TEXT,
    "created" TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    -- "created" TIMESTAMP,
    "updated" DATETIME,
    "deleted" DATETIME,
    "active" DATETIME
);


--
-- Table Post
--
CREATE TABLE Post (
    "id" INTEGER PRIMARY KEY,
    "user_id" INTEGER,
    "title" TEXT,
    "text" TEXT,
    "created" TIMESTAMP,
    "updated" DATETIME,
    "deleted" DATETIME,
    "active" DATETIME,
    FOREIGN KEY("user_id") REFERENCES User("id")
);

-- --
-- -- Table User
-- --
-- DROP TABLE IF EXISTS User;
-- CREATE TABLE User (
--     "id" INTEGER PRIMARY KEY NOT NULL,
--     "username" TEXT UNIQUE NOT NULL,
--     "email" TEXT UNIQUE NOT NULL,
--     "password" TEXT,
--     "created" TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
--     -- "created" TIMESTAMP,
--     "updated" DATETIME,
--     "deleted" DATETIME,
--     "active" DATETIME
-- );


-- --
-- -- Table Post
-- --
-- DROP TABLE IF EXISTS Post;
-- CREATE TABLE Post (
--     "id" INTEGER PRIMARY KEY NOT NULL,
--     "user_id" INTEGER NOT NULL,
--     "title" TEXT,
--     "text" TEXT,
--     "created" TIMESTAMP,
--     "updated" DATETIME,
--     "deleted" DATETIME,
--     "active" DATETIME,
--     FOREIGN KEY("user_id") REFERENCES User("id")
-- );


--
-- Table Comment
--
CREATE TABLE Comment (
    "id" INTEGER PRIMARY KEY,
    "user_id" INTEGER,
    "post_id" INTEGER,
    "comment_id" INTEGER,
    "text" TEXT,
    "created" TIMESTAMP,
    "updated" DATETIME,
    "deleted" DATETIME,
    "active" DATETIME,
    FOREIGN KEY("user_id") REFERENCES User("id"),
    FOREIGN KEY("post_id") REFERENCES Post("id"),
    FOREIGN KEY("comment_id") REFERENCES Comment("id")
);


--
-- Table Tag
--
CREATE TABLE Tags (
    "id" INTEGER PRIMARY KEY,
    "tag" TEXT UNIQUE
);


--
-- Table TagsPost
--
CREATE TABLE TagsPost (
    "tag_id" INTEGER,
    "post_id" INTEGER,
    FOREIGN KEY("tag_id") REFERENCES Tags("id"),
    FOREIGN KEY("post_id") REFERENCES Post("id")
);
