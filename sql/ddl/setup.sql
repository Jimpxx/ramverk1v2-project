PRAGMA foreign_keys = ON;


--
-- Dropping tables
--

DROP TABLE IF EXISTS TagsPost;
DROP TABLE IF EXISTS Comment;
DROP TABLE IF EXISTS Tags;
DROP TABLE IF EXISTS Post;
DROP TABLE IF EXISTS User;


--
-- Creating tables.
--


--
-- Table User
--
CREATE TABLE User (
    "userId" INTEGER PRIMARY KEY,
    "username" TEXT UNIQUE,
    "email" TEXT UNIQUE,
    "password" TEXT,
    "uCreated" TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    -- "created" TIMESTAMP,
    "uUpdated" DATETIME,
    "uDeleted" DATETIME,
    "uActive" DATETIME
);


--
-- Table Post
--
CREATE TABLE Post (
    "postId" INTEGER PRIMARY KEY,
    "user_id" INTEGER,
    "title" TEXT,
    "text" TEXT,
    "pCreated" TIMESTAMP,
    "pUpdated" DATETIME,
    "pDeleted" DATETIME,
    "pActive" DATETIME,
    FOREIGN KEY("user_id") REFERENCES User("userId")
);


--
-- Table Comment
--
CREATE TABLE Comment (
    "commentId" INTEGER PRIMARY KEY,
    "user_id" INTEGER,
    "post_id" INTEGER,
    "reply_id" INTEGER,
    "text" TEXT,
    "cCreated" TIMESTAMP,
    "cUpdated" DATETIME,
    "cDeleted" DATETIME,
    "cActive" DATETIME,
    FOREIGN KEY("user_id") REFERENCES User("userId"),
    FOREIGN KEY("post_id") REFERENCES Post("postId"),
    FOREIGN KEY("reply_id") REFERENCES Comment("commentId")
);


--
-- Table Tag
--
CREATE TABLE Tags (
    "tagId" INTEGER PRIMARY KEY,
    "tag" TEXT UNIQUE
);


--
-- Table TagsPost
--
CREATE TABLE TagsPost (
    "tag_id" INTEGER,
    "post_id" INTEGER,
    FOREIGN KEY("tag_id") REFERENCES Tags("tagId"),
    FOREIGN KEY("post_id") REFERENCES Post("postId")
);
