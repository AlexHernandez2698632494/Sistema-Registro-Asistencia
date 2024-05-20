CREATE database sistemaasistencia;
use sistemaasistencia;

CREATE TABLE Persona(
idPersona INT PRIMARY KEY AUTO_INCREMENT,
nombre VARCHAR(255) NOT NULL,
apellido VARCHAR(255) NOT NULL,
dui VARCHAR(10) NOT NULL,
telefono VARCHAR(10) NOT NULL,
correo TEXT DEFAULT NULL,
direccion TEXT DEFAULT NULL,
estadoEliminacion INT NOT NULL DEFAULT 1 );

CREATE TABLE Administrador(
idAdministrador INT PRIMARY KEY AUTO_INCREMENT,
idPersona INT NOT NULL,
cargo TEXT DEFAULT NULL,
estadoEliminacion INT NOT NULL DEFAULT 1,
FOREIGN KEY (idPersona) REFERENCES Persona(idPersona));

CREATE TABLE Estudiante(
idEstudiante INT PRIMARY KEY AUTO_INCREMENT,
idPersona INT NOT NULL,
carrera TEXT DEFAULT NULL,
estadoEliminacion INT NOT NULL DEFAULT 1,
FOREIGN KEY (idPersona) REFERENCES Persona(idPersona)
);

CREATE TABLE InvitadoInstitucion(
idInvitadoInstitucion INT PRIMARY KEY AUTO_INCREMENT,
idPersona INT NOT NULL,
nombreInstitucion TEXT DEFAULT NULL,
estadoEliminacion INT NOT NULL DEFAULT 1,
FOREIGN KEY (idPersona) REFERENCES Persona(idPersona)
);

CREATE TABLE Invitado(
idInvitado INT PRIMARY KEY AUTO_INCREMENT,
idPersona INT NOT NULL,
estadoEliminacion INT NOT NULL DEFAULT 1,
FOREIGN KEY (idPersona) REFERENCES Persona(idPersona)
);

CREATE TABLE Eventos(
idEvento int primary key auto_increment,
NombreEvento varchar(255) not null,
lugar text default  null,
fecha DATE NOT NULL,
hora TIME NOT NULL ,
descripcion text default null,
precio varchar(8) not null,
imagen varchar(255) not null ,
estadoEliminacion int not null default 1 ); 

CREATE TABLE `Usuario`
(
  `idUsuario` varchar(10) PRIMARY KEY,
  `usuario` varchar(500) NOT NULL,
  `password` text NOT NULL,
  `nivel` int
);

CREATE TABLE RESERVAGRUPO(
idGrupo int primary key auto_increment,
nombreInstitucion text default null,
telefono varchar(10) not null,
descripcion text default null,
logo varchar(255) not null,
ninos int not null,
ninas int not null,
acompanantes int not null ); 

CREATE TABLE Reserva (
idReserva INT PRIMARY KEY AUTO_INCREMENT,
idEvento INT NOT NULL,
estacionamiento VARCHAR(5),
estado INT NOT NULL DEFAULT 1,
FOREIGN KEY (idEvento) REFERENCES Eventos(idEvento)
);
