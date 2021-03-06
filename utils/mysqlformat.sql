create database battlePlan;

create table Accounts(
    ID char(10) NOT NULL,
    email varchar(256) NOT NULL,
    fname varchar(80) NOT NULL,
    lname varchar(80) NOT NULL,
    hash varchar(104) NOT NULL,
    salt varchar(32) NOT NULL,
    time int unsigned NOT NULL,
    
    PRIMARY KEY (ID)
);

create table Projects(
    ID char(32) NOT NULL,
    owner char(10) NOT NULL,
    name varchar(80) NOT NULL,
    description varchar(200) NOT NULL,
    deadline char(10) NOT NULL,
    time int unsigned NOT NULL,
    
    PRIMARY KEY (ID),
    FOREIGN KEY (owner) REFERENCES Accounts(ID)
);

create table Tasks(
    ID char(32) NOT NULL,
    parent char(32),
    owner char(10) NOT NULL,
    project char(32) NOT NULL,
    name varchar(80) NOT NULL,
    description varchar(200) NOT NULL,
    deadline char(10) NOT NULL,
    assigned char(10),
    finished int unsigned NOT NULL,
    time int unsigned NOT NULL,
    
    PRIMARY KEY (ID),
    FOREIGN KEY (owner) REFERENCES Accounts(ID),
    FOREIGN KEY (parent) REFERENCES Tasks(ID),
    FOREIGN KEY (project) REFERENCES Projects(ID),
    FOREIGN KEY (assigned) REFERENCES Accounts(ID)
);



    
    
    
    
