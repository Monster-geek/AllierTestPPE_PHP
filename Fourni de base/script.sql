DROP DATABASE IF EXISTS QCM;
CREATE DATABASE QCM
DEFAULT CHARACTER SET ascii
COLLATE ascii_general_ci;

USE QCM;

DROP TABLE IF EXISTS Questionnaire;
DROP TABLE IF EXISTS Questions;

CREATE TABLE Questionnaire
(
    cle VARCHAR(12),
    name VARCHAR(80),
    displayName VARCHAR(80),
    description TEXT,
    CONSTRAINT pk_Questionnaire PRIMARY KEY(cle)
);

CREATE TABLE Questions
(
    cle VARCHAR(12),
    rang VARCHAR(6),
    typeQ VARCHAR(10),
    name VARCHAR(80),
    text TEXT,
    reponse1 VARCHAR(80),
    reponse2 VARCHAR(80),
    reponse3 VARCHAR(80),
    reponse4 VARCHAR(80),
    reponse5 VARCHAR(80),
    defaut VARCHAR(1),
    CONSTRAINT pk_Questions PRIMARY KEY(cle, rang)
);

INSERT INTO Questionnaire VALUES('12064011927', "Gouts", "Questionnaire sur les gouts", "vide");
INSERT INTO Questions VALUES('12064011927', 012352, "combo", "Fruits", "Quel fruit est rond et de couleur orange ?", "Banane", "Pomme", "Orange", "Raisin", "Fraise", 1); 

DESC Questionnaire;
DESC Questions;

SELECT * FROM Questionnaire;
SELECT * FROM Questions;




