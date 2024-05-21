CREATE DATABASE sistemaasistencia;
use sistemaasistencia;

CREATE TABLE invitado(
idInvitado INT AUTO_INCREMENT PRIMARY KEY,
nombreInvitado VARCHAR(256) NOT NULL,
apellidosInvitado VARCHAR(256) NOT NULL,
sexoInvitado VARCHAR(10) NOT NULL,
duiInvitado VARCHAR(10) NOT NULL,
correoInvitado TEXT NOT NULL,
telefonoInvitado VARCHAR(10) NOT NULL,
departamentoInvitado TEXT NOT NULL,
municipioInvitado TEXT NOT NULL,
estadoEliminacion INT NOT NULL DEFAULT 1
); 

CREATE TABLE estudianteUDB(
    idUDB INT AUTO_INCREMENT PRIMARY KEY,
    nombreUDB VARCHAR(256) NOT NULL,
    apellidosUDB VARCHAR(256) NOT NULL,
    sexoUDB VARCHAR(10) NOT NULL,
    carnetUDB VARCHAR(9) NOT NULL,
    carreraUDB TEXT NOT NULL,
    correoUDB TEXT NOT NULL,
    telefonoUDB VARCHAR(10) NOT NULL,
    departamentoUDB TEXT NOT NULL,
    municipioUDB TEXT NOT NULL,
    estadoEliminacion INT NOT NULL DEFAULT 1
); 

CREATE TABLE estudianteInstitucion(
    idInstitucion INT AUTO_INCREMENT PRIMARY KEY,
    nombreInstitucion VARCHAR(256) NOT NULL,
    apellidosInstitucion VARCHAR(256) NOT NULL,
    sexoInstitucion VARCHAR(10) NOT NULL,
    correoInstitucion TEXT NOT NULL,
    telefonoInstitucion VARCHAR(10) NOT NULL,
    nivelEducativo TEXT NOT NULL,
    institucion TEXT NOT NULL,
    carnetinstitucion TEXT NOT NULL,
    departamentoInstitucion TEXT NOT NULL,
    municipioInstitucion TEXT NOT NULL,
    estadoEliminacion INT NOT NULL DEFAULT 1
); 

CREATE TABLE administrador(
    idAdmin INT AUTO_INCREMENT PRIMARY KEY,
    nombreAdmin VARCHAR(256) NOT NULL,
    apellidosAdmin VARCHAR(256) NOT NULL,
    sexoAdmin VARCHAR(10) NOT NULL,
    carnetAdmin VARCHAR(6) NOT NULL,
    cargoAdmin TEXT NOT NULL,
    correoAdmin TEXT NOT NULL,
    telefonoAdmin VARCHAR(10) NOT NULL,
    estadoEliminacion INT NOT NULL DEFAULT 1
); 

CREATE TABLE `Usuario`(
  `idUsuario` varchar(10) PRIMARY KEY,
  `usuario` varchar(500) NOT NULL,
  `password` text NOT NULL,
  `nivel` int
);

CREATE TABLE areaFormativaEntretenimiento(
    idAreaFormativaEntretenimiento INT PRIMARY KEY AUTO_INCREMENT,
    nombreArea text not null,
    nivel int not null,
    estadoEliminacion INT NOT NULL DEFAULT 1
);

CREATE TABLE Areas(
    idAreas INT PRIMARY KEY AUTO_INCREMENT,
    nombre text,
    idAreaFormativaEntretenimiento int,
    estadoEliminacion INT NOT NULL DEFAULT 1,
    FOREIGN KEY(`idAreaFormativaEntretenimiento`) REFERENCES `areaFormativaEntretenimiento`(`idAreaFormativaEntretenimiento`)
);

CREATE TABLE Eventos(
    idEvento INT PRIMARY KEY AUTO_INCREMENT,
    NombreEvento VARCHAR(255) NOT NULL,
    lugar TEXT DEFAULT NULL,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    descripcion TEXT DEFAULT NULL,
    precio VARCHAR(8) ,
    imagen VARCHAR(255) NOT NULL,
    estadoEliminacion INT NOT NULL DEFAULT 1
);

CREATE TABLE areaFormativaEntretenimientoEvento(
`idDetalle` int PRIMARY KEY AUTO_INCREMENT,
  `idEvento` int NOT NULL,
  `idAreas` int NOT NULL,
  FOREIGN KEY(`idEvento`) REFERENCES `Eventos`(`idEvento`),
  FOREIGN KEY(`idAreas`) REFERENCES `Areas`(`idAreas`)
);

CREATE TABLE adquirirEntrada(
    idAdquirirEntrada INT PRIMARY KEY AUTO_INCREMENT,
    nombres VARCHAR(256) NOT NULL,
    sexo VARCHAR(10) NOT NULL,
    nivelEducativo TEXT NOT NULL,
    institucion TEXT NOT NULL,
    qr TEXT NOT NULL,
    estado BOOLEAN DEFAULT FALSE,
    estadoEliminacion INT NOT NULL DEFAULT 1
);


