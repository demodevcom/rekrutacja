-- mysql
alter table kandydat change nip nip varchar(20);
alter table kandydat add zameldowanie_miasto VARCHAR(30) NOT NULL;
alter table kandydat add korespondencja_miasto VARCHAR(30);
alter table kandydat add zameldowanie_wojewodztwo VARCHAR(30) NOT NULL;
alter table kandydat add korespondencja_wojewodztwo VARCHAR(30);

alter table kandydat add email VARCHAR(255) NOT NULL;
alter table kandydat add telefon_nr VARCHAR(12) NOT NULL;
alter table kandydat add mobile_nr VARCHAR(12);
alter table kandydat add wku_miasto VARCHAR(30);
alter table kandydat add dowod_osobisty_nr VARCHAR(10) not null;

--13.07
alter table kandydat change wku_miasto wku_miasto VARCHAR(60);
alter table kandydat add szkola_komentarz VARCHAR(255);
alter table kandydat add przelew_zaksiegowany boolean default false;
alter table kandydat add dokumenty_dotarly boolean default false;

alter table kandydat change mgr studia_typ VARCHAR(15) not null;
alter table kandydat add szkola_srednia VARCHAR(255) not null;

alter table kandydat add pytanie_haslo VARCHAR(80) not null default '';
alter table kandydat add odpowiedz_haslo VARCHAR(25) not null default '';


--pgsql
alter table kandydat alter column nip drop not null;
alter table kandydat add zameldowanie_miasto VARCHAR(30) NOT NULL default 'Krakow';
alter table kandydat add korespondencja_miasto VARCHAR(30);
alter table kandydat add zameldowanie_wojewodztwo VARCHAR(30) NOT NULL default 'Małopolskie';
alter table kandydat add korespondencja_wojewodztwo VARCHAR(30);

alter table kandydat add email VARCHAR(255) NOT NULL default 'test@onet.eu';
alter table kandydat add telefon_nr VARCHAR(12) NOT NULL default '48600100200';
alter table kandydat add mobile_nr VARCHAR(12);
alter table kandydat add wku_miasto VARCHAR(30);
alter table kandydat add dowod_osobisty_nr VARCHAR(10) not null default 'AAA111111';

--13.07
ALTER TABLE kandydat ALTER COLUMN wku_miasto TYPE VARCHAR(60);
alter table kandydat add szkola_komentarz VARCHAR(255);
alter table kandydat add przelew_zaksiegowany boolean default false;
alter table kandydat add dokumenty_dotarly boolean default false;

ALTER TABLE kandydat ALTER COLUMN studia_typ TYPE VARCHAR(15);
alter table kandydat add szkola_srednia VARCHAR(255) not null default '';

