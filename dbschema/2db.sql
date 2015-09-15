

CREATE TABLE admin (
	id SERIAL PRIMARY KEY,
	login VARCHAR(20) NOT NULL,
	haslo VARCHAR(32) NOT NULL,
	created_at TIMESTAMP, 
	updated_at TIMESTAMP, 
	UNIQUE(login)
) DEFAULT CHARSET=utf8;

insert into admin (login, haslo, created_at, updated_at) values ('rekrutacja', md5('zamek'), '2009-07-07 13:30', '2009-07-07 13:30');