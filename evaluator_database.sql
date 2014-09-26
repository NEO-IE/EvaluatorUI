create table SentenceMatcher(
      ID int AUTO_INCREMENT PRIMARY KEY,
      SENTID varchar(20) not null,
      Country varchar(100) not null,
      st_offset int not null,
      end_offset int not null,
      value double not null,
      Relation varchar(100) not null, 
      Sentence varchar(40000) not null,
      Heuristic1 ENUM('true', 'false'),
      Heuristic2 ENUM('true','false'),
      Heuristic3 ENUM('true','false'),
      Heuristic4 ENUM('true','false'),
      UNIQUE (SENTID, Country, st_offset, end_offset, value, Relation)
);
