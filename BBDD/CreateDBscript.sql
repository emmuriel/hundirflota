
CREATE DATABASE `hundirlaflota`;
USE `hundirlaflota`;

##CREATE TABLES 

CREATE TABLE IF NOT EXISTS `Usuario` (
`codUsu` int(3) NOT NULL AUTO_INCREMENT COMMENT 'Clave primaria',
`usuario` varchar(35) NOT NULL COMMENT 'nombre usuario',
`email` varchar(50) NOT NULL COMMENT 'email usuario',
`pwd` char(64) NOT NULL COMMENT 'hash sha256',
`victorias` int(4) NOT NULL COMMENT 'partidas ganadas',
`estado` int(1) NOT NULL COMMENT '0=no conectado, 1=conectado sin partida, 2=conectado en partida',
`conexiones` int(3) NOT NULL DEFAULT 0 COMMENT 'total de sesiones iniciadas',
  PRIMARY KEY (`codUsu`),
  UNIQUE KEY `usuario` (`usuario`),
  UNIQUE KEY `email` (`email`)
)ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='tabla de usuarios';


CREATE TABLE IF NOT EXISTS `Partida` ( 
`codPartida` int(5) NOT NULL AUTO_INCREMENT COMMENT 'Clave primaria',
`jug1` int(3) NOT NULL,
`jug2` int(3) NOT NULL,
`turno` int(1) NOT NULL,
	FOREIGN KEY (`jug1`) references `Usuario` (`codUsu`) ON UPDATE NO ACTION ON DELETE CASCADE,
    FOREIGN KEY (`jug2`) references `Usuario` (`codUsu`) ON UPDATE NO ACTION ON DELETE CASCADE,
    PRIMARY KEY (`codPartida`)
)ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='tabla de partidas';

CREATE TABLE IF NOT EXISTS `TableroPartida` (
`codPartida` int(5) NOT NULL,
`idJug` int(1) NOT NULL COMMENT 'Clave primaria',
`tablero` char(100) NOT NULL COMMENT 'cadenas tablero',
  PRIMARY KEY (`codPartida`,`idJug`),
  FOREIGN KEY (`codPartida`) references `Partida` (`codPartida`) ON UPDATE NO ACTION ON DELETE CASCADE

)ENGINE=InnoDB
DEFAULT CHARSET=latin1 COMMENT='cadena de tableros';

CREATE TABLE IF NOT EXISTS `TableroSistema` (
`codTablero` int(3) NOT NULL AUTO_INCREMENT COMMENT 'Clave primaria',
`tablero` char(100) NOT NULL COMMENT 'cadenas tablero',
  PRIMARY KEY (`codTablero`),
  UNIQUE KEY  `tablero`(`tablero`)
)ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='cadena de tableros';


## INSERT TABLES

INSERT INTO `Usuario`(`usuario`,`email`,`pwd`,`victorias`,`estado`,`conexiones`) VALUES   ('$$erver','hundirlaflota@gmail.com','$2y$10$tP8mbOiwc7b.HGVynsyQpOtfaMIYmAgr/aaGOGkT0Vuc40r921Bdm',0,0,1),
																('elisa','emartinm@iespuntadelverde.es','$2y$10$tP8mbOiwc7b.HGVynsyQpOtfaMIYmAgr/aaGOGkT0Vuc40r921Bdm',0,0,0),
																('pakito','emarmur108@g.educaand.es','$2y$10$0JT4hsxl0FcnDU2H6iGuFecsFUvWToDSh74p1vMmJgQDDFWrYX7gK',0,0,0),
																('lokito','lokitojuli@iespuntadelverde.es','$2y$10$tP8mbOiwc7b.HGVynsyQpOtfaMIYmAgr/aaGOGkT0Vuc40r921Bdm',15,0,0),
																('JJ','jj@iespuntadelverde.es','$2y$10$tP8mbOiwc7b.HGVynsyQpOtfaMIYmAgr/aaGOGkT0Vuc40r921Bdm',244,0,0),
																('ercabeza','@iespuntadelverde.es','$2y$10$tP8mbOiwc7b.HGVynsyQpOtfaMIYmAgr/aaGOGkT0Vuc40r921Bdm',185,0,0),
																('purificacion','purigarcia@iespuntadelverde.es','$2y$10$tP8mbOiwc7b.HGVynsyQpOtfaMIYmAgr/aaGOGkT0Vuc40r921Bdm',88,0,0);

																

INSERT INTO `TableroSistema` (`tablero`) VALUES  ('W111E000000000000000WE0000000000000000000000000000N00000000020000N000020N00S00N02020000020S0S00000S0'),
										('000000000000N000000000200W1E00002000000000S0W111E000000000000W1E0000N000000000S000000000000WE0000000'),
										('00000000N0000WE0002000000000S00WE00000000000N00000000020W11EW1E020000000002000000000S000000000000000'),
										('00000000000000W1E00000000000000000W11E0000N000000N00S0000002000000000S00000000000N0W111E000S00000000'),
										('000000000N000W1E0002000000000200000000020000WE000S0000000000N000000000200WE000002000000W1ES000000000'),
										('00000WE000000000000000000000000000000000W111E00000000000000000000W11E0N0N000000020S0000000S0000W1E00'),
										('0000000000000000000000N0N000000020S00000002000WE00020N0000000S0200W1E0000S00000000000W11E00000000000'),
										('00000000N000N000002000200WE020N0200000S02020000000S0S0000000000000000000W1E00000N000000000S000000000'),
										('000WE0W1E0000000000000000000000000WE0000N000000N00200000020020000N0200S00002020000000S0S000000000000'),
										('0WE00000N0000000002000W111E0S00000000000000W11E0000000000000000000000000N000000000200WE00000S0000000'),										('000000000N000W1E00020000000002000000000200000WE00S00000000000N00N000N00S0020002000002000S00000S00000'),
										('0000000000000000N00000000020000WE0N0200000002020000N0020S0000200S000000S00000WE0000W1E00000000000000'),
										('000W111E000N000000000S0W1E0000000000000000000000N00N000000200S0000002000000000S00000W1E0000000000000'),
										('0N00000N000200000200020WE00S000200000000000N0000N00N020000200S0S000020000000002000000000S00000000000'),
										('0W1E0000000000000000000W111E000000000000000N0000N00N0S0000200S000000S0000000000000000000000000W11E00'),
								        ('0W1E00W11E000000000000000W1E000000000000000N000000000S0000000000000000000000000N000000000S00W111E000'),
										('0N0W1E00000S00000000000W11E0000N0000000N02000000020S000000020000000002000000000S0N000000000S00000000'),
										('0N00000N000S0000020000000002000W111E0S0000000000000000000N0000000002000N00000S0N0S00000002000000000S'),
										('00000000000WE00000000000W11E00N0000000002000000WE020000000002000000000S0W1E00000000000000000W1E00000');		

#CREATE PROCEDURES
DELIMITER $$
CREATE PROCEDURE regPartida2(IN jugador1 INT, IN jugador2 INT,IN tablero1 char(100),IN tablero2 char(100))
COMMENT 'Crea una partida y sus tablero asociados'
BEGIN	
	   START TRANSACTION;
    -- Insert nueva partida
	INSERT INTO  partida(`jug1`,`jug2`,`turno`) 
	VALUES (jugador1,jugador2,turno);
    
    SET @codP = 0;
    SELECT @codP :=codPartida FROM partida WHERE jug1=jugador1 AND jug2 = jugador2;
    
    -- insert tableros para la partida
    IF @codP > 0 THEN
	INSERT INTO tableropartida(codPartida,idJug , tablero )
    VALUES(@codP,1,tablero1);

	INSERT INTO tableropartida(codPartida,idJug, tablero)
	VALUES(@codP,2,tablero2);

        -- commit
        COMMIT;
	ELSE
	ROLLBACK;

    END IF;

	
END$$
---------------------------------------------------------------

DELIMITER $$
CREATE PROCEDURE regPartida(IN jugador1 INT, IN jugador2 INT,IN tablero1 char(100),IN tablero2 char(100),IN turnoini INT)
COMMENT 'Crea una partida y sus tablero asociados'
BEGIN	
	   START TRANSACTION;
    -- Insert nueva partida
	INSERT INTO  partida(`jug1`,`jug2`,`turno`) 
	VALUES (jugador1,jugador2,turnoini);
    
    SET @codP = 0;
    SELECT @codP :=codPartida FROM partida WHERE jug1=jugador1 AND jug2 = jugador2;
    
    -- insert tableros para la partida
    IF @codP > 0 THEN
	INSERT INTO tableropartida(codPartida,idJug , tablero )
    VALUES(@codP,1,tablero1);

	INSERT INTO tableropartida(codPartida,idJug, tablero)
	VALUES(@codP,2,tablero2);
        -- commit
        COMMIT;
	ELSE
	ROLLBACK;

    END IF;
END$$



DELIMITER $$
CREATE PROCEDURE updtPartida(IN codPart INT,IN tablero1 char(100),IN tablero2 char(100), IN nuevoturno INT)
COMMENT 'Actualiza los campos de la tabla Partida y la tabla tablero'
BEGIN
 
	START TRANSACTION;
    -- update turno partida
	UPDATE partida SET turno = nuevoturno WHERE codPartida = codPart;

    
    -- update tableros
   
		UPDATE tableropartida SET tablero = tablero1 WHERE codPartida = codPart AND idJug = 1;
		UPDATE tableropartida SET tablero = tablero2 WHERE codPartida = codPart AND idJug = 2;
        -- commit
        COMMIT;
	ROLLBACK;
  
	
	
END $$
