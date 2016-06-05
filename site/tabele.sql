

CREATE TABLE Formulare
  (
    id_formular   INTEGER NOT NULL primary key,
    nume          VARCHAR(50) NOT NULL,
    descriere     VARCHAR(256),
    domeniu       VARCHAR(20),
    data_creare   DATE,
    nr_completari INTEGER
  );

insert into Formulare values('111','Cheltuielile studentilor','Buna ziua! In cadrul acestei cercetari as dori sa aflu cati bani si in ce scopuri cheltuiesc studentii.','Educatie','17/02/2005', 0);



CREATE TABLE Campuri
  (
    id_field   INTEGER NOT NULL primary key,
    nume_field VARCHAR(100) NOT NULL,
    tip_field  INTEGER NOT NULL
  );
CREATE TABLE Asociere
  (
    id_formular INTEGER NOT NULL,
    id_field    INTEGER NOT NULL
  );
CREATE TABLE Optiuni
  (
    id_field  INTEGER NOT NULL,
    optiune   VARCHAR(50),
    nr_voturi INTEGER
  );


