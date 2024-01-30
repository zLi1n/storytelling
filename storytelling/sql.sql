CREATE DATABASE Storytelling;
USE Storytelling;

CREATE TABLE User (
    Email VARCHAR(255) PRIMARY KEY,
    Username VARCHAR(50),
    Name VARCHAR(100),
    DOB DATE,
    Password VARCHAR(255),
    Avatar VARCHAR(255),
    RegistrationDate DATE,
    BackgroundTheme VARCHAR(50),
    Type VARCHAR(1),
    SecurityQuestion VARCHAR(255),
    SecurityQuestionAns VARCHAR(255)
);

CREATE TABLE Genre (
    GenreID INT PRIMARY KEY,
    GenreDetail VARCHAR(255)
);

CREATE TABLE Theme (
    ThemeID INT PRIMARY KEY,
    ThemeDetail VARCHAR(255)
);

CREATE TABLE Story (
    StoryID INT PRIMARY KEY,
    Title VARCHAR(255),
    GenreID INT,
    WordLimit INT,
    Access VARCHAR(3),
    Email VARCHAR(255),
    CoverPage VARCHAR(255),
    Status VARCHAR(1),
    DateTime DATETIME,
    ThemeID INT,
    FOREIGN KEY (GenreID) REFERENCES Genre(GenreID),
    FOREIGN KEY (Email) REFERENCES User(Email),
    FOREIGN KEY (ThemeID) REFERENCES Theme(ThemeID)
);

CREATE TABLE Invitation (
    InvitationID INT PRIMARY KEY,
    SenderEmail VARCHAR(255),
    ReceiverEmail VARCHAR(255),
    StoryID INT,
    FOREIGN KEY (SenderEmail) REFERENCES User(Email),
    FOREIGN KEY (ReceiverEmail) REFERENCES User(Email),
    FOREIGN KEY (StoryID) REFERENCES Story(StoryID)
);

CREATE TABLE Chapter (
    ChapterID INT PRIMARY KEY,
    StoryID INT,
    Content TEXT,
    WordCount INT,
    ChapBeforeID INT,
    Status VARCHAR(1),
    DateTime DATETIME,
    FOREIGN KEY (StoryID) REFERENCES Story(StoryID),
    FOREIGN KEY (ChapBeforeID) REFERENCES Chapter(ChapterID)
);

CREATE TABLE Contribution (
    ContributionID INT PRIMARY KEY,
    ChapterID INT,
    Email VARCHAR(255),
    FOREIGN KEY (ChapterID) REFERENCES Chapter(ChapterID),
    FOREIGN KEY (Email) REFERENCES User(Email)
);

CREATE TABLE Vote (
    VoteID INT PRIMARY KEY,
    ChapterID INT,
    Email VARCHAR(255),
    DateTime DATETIME,
    FOREIGN KEY (ChapterID) REFERENCES Chapter(ChapterID),
    FOREIGN KEY (Email) REFERENCES User(Email)
);

CREATE TABLE Comment (
    CommentID INT PRIMARY KEY,
    ChapterID INT,
    Email VARCHAR(255),
    CommentText TEXT,
    DateTime DATETIME,
    FOREIGN KEY (ChapterID) REFERENCES Chapter(ChapterID),
    FOREIGN KEY (Email) REFERENCES User(Email)
);

CREATE TABLE ReportedContent (
    ReportID INT PRIMARY KEY,
    ContentID INT,
    Email VARCHAR(255),
    ReportDetails TEXT,
    FOREIGN KEY (ContentID) REFERENCES Chapter(ChapterID),
    FOREIGN KEY (Email) REFERENCES User(Email)
);
