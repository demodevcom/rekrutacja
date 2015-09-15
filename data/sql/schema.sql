CREATE TABLE kandydat (id SERIAL, imiona VARCHAR(80) NOT NULL, nazwisko VARCHAR(80) NOT NULL, plec BOOLEAN NOT NULL, kierunek VARCHAR(30) NOT NULL, stacjonarne BOOLEAN DEFAULT 'true', mgr BOOLEAN DEFAULT 'false', urodzenie_miejsce VARCHAR(40) NOT NULL, matka_imie VARCHAR(40) NOT NULL, ojciec_imie VARCHAR(40) NOT NULL, narodowosc VARCHAR(40) NOT NULL, obywatelstwo VARCHAR(40) NOT NULL, pesel VARCHAR(11) NOT NULL, nip VARCHAR(20) NOT NULL, zameldowanie_ulica VARCHAR(45), zameldowanie_dom_nr VARCHAR(6) NOT NULL, zameldowanie_kod VARCHAR(6) NOT NULL, stosunek_do_sluzby_wojskowej VARCHAR(20) NOT NULL, niepelnosprawny BOOLEAN DEFAULT 'false', login VARCHAR(20) NOT NULL, haslo VARCHAR(32) NOT NULL, specjalnosc VARCHAR(30), jezyk VARCHAR(20), jezyk2 VARCHAR(20), zameldowanie_mieszkanie_nr VARCHAR(6), korespondencja_ulica VARCHAR(45), korespondencja_dom_nr VARCHAR(6), korespondencja_mieszkanie_nr VARCHAR(6), korespondencja_kod VARCHAR(6), ksiazeczka_wojskowa_nr VARCHAR(20), szkola_srednia_rok_ukonczenia VARCHAR(4), inne_studia VARCHAR(255), plywanie_grupa VARCHAR(20), skad_wiem VARCHAR(40), skonczone_studia VARCHAR(80), skonczone_studia_rok_ukonczenia VARCHAR(4), zdjecie VARCHAR(255), created_at TIMESTAMP without time zone, updated_at TIMESTAMP without time zone, PRIMARY KEY(id));
CREATE TABLE admin (
	id SERIAL PRIMARY KEY,
	login VARCHAR(20) NOT NULL,
	haslo VARCHAR(32) NOT NULL,
	created_at TIMESTAMP without time zone, 
	updated_at TIMESTAMP without time zone,
	UNIQUE(login)
);