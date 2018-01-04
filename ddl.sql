create sequence druzyna_id_seq
;

create sequence zawodnik_id_seq
;

create sequence mecz_id_seq
;

create sequence sklad_id_seq
;

create sequence set_id_seq
;

create table druzyna
(
  id serial not null
    constraint druzyna_pkey
    primary key,
  nazwa varchar(50) not null
)
;

create unique index druzyna_id_uindex
  on druzyna (id)
;

create unique index druzyna_nazwa_uindex
  on druzyna (nazwa)
;

create table zawodnik
(
  id serial not null
    constraint zawodnik_pkey
    primary key,
  imie varchar(50),
  nazwisko varchar(50),
  druzyna integer
    constraint zawodnik_druzyna__fk
    references druzyna
)
;

create unique index zawodnik_id_uindex
  on zawodnik (id)
;

create table mecz
(
  id serial not null
    constraint mecz_pkey
    primary key,
  sklad_1 integer not null,
  sklad_2 integer not null,
  zwyciezca integer not null
)
;

create unique index mecz_id_uindex
  on mecz (id)
;

create table sklad
(
  id serial not null
    constraint sklad_pkey
    primary key,
  druzyna integer not null
    constraint sklad_druzyna_id_fk
    references druzyna
)
;

create unique index sklad_id_uindex
  on sklad (id)
;

alter table mecz
  add constraint mecz_sklad_id_fk
foreign key (sklad_1) references sklad
;

alter table mecz
  add constraint mecz_sklad_id_fk3
foreign key (sklad_2) references sklad
;

create table set
(
  id serial not null
    constraint set_pkey
    primary key,
  wynik1 integer not null,
  wynik2 integer not null,
  mecz integer not null
    constraint set_mecz_id_fk
    references mecz
)
;

create unique index set_id_uindex
  on set (id)
;

create table zawodnik_sklad
(
  id_zawodnik integer not null
    constraint zawodnik_sklad_zawodnik_id_fk
    references zawodnik,
  id_sklad integer not null
    constraint zawodnik_sklad_sklad_id_fk
    references sklad,
  constraint zawodnik_sklad_id_zawodnik_id_sklad_pk
  primary key (id_zawodnik, id_sklad)
)
;

create table dostepnosczgloszen
(
  dostepne boolean default true not null
    constraint dostepnosczgloszen_pkey
    primary key
)
;

create unique index dostepnosczgloszen_dostepne_uindex
  on dostepnosczgloszen (dostepne)
;

create function addmatch() returns void
language plpgsql
as $$
DECLARE
  idSklad1 INTEGER;
  idSklad2 INTEGER;
  idDruzyna1 INTEGER;
  idDruzyna2 INTEGER;
BEGIN
  idSklad1 := (SELECT nextval('sklad_id_seq1'::regclass) FROM sklad_id_seq1);
  idSklad2 := (SELECT nextval('sklad_id_seq1'::regclass) FROM sklad_id_seq1);
  idDruzyna1 := (SELECT druzyna.id FROM druzyna WHERE druzyna.nazwa = 'A');
  idDruzyna2 := (SELECT druzyna.id FROM druzyna WHERE druzyna.nazwa = 'B');
  INSERT INTO sklad
  VALUES(idSklad1,idDruzyna1);
  INSERT INTO sklad
  VALUES(idSklad2,idDruzyna2);
  INSERT INTO mecz
  VALUES(nextval('mecz_id_seq1'::regclass),idSklad1,idSklad2,0);
END;
$$
;

-- Jezeli zostane wrzucone do bazy danych sety,
-- i na ich podstawie mozna wywnioskowac kto jest zwyciezca meczu
-- to ustawia zwyciezce w tabeli mecz.
CREATE OR REPLACE FUNCTION updateZwyciezca()
  RETURNS TRIGGER AS $$
DECLARE
  wygrane1 INTEGER;
  wygrane2 INTEGER;
BEGIN

  SELECT COUNT(*)
  INTO wygrane1
  FROM set
  WHERE set.mecz = NEW.mecz AND set.wynik1 > set.wynik2;

  SELECT COUNT(*)
  INTO wygrane2
  FROM set
  WHERE set.mecz = NEW.mecz AND set.wynik1 < set.wynik2;

  RAISE WARNING 'wygrane1 wygrane2 % %', wygrane1, wygrane2;

  IF wygrane1 > wygrane2 AND wygrane1 = 3
  THEN
    RAISE WARNING 'wygrane 1 wiekszy niz wygrane 2';
    UPDATE mecz
    SET zwyciezca =
    (
      SELECT sklad.druzyna
      FROM mecz
        JOIN sklad ON mecz.sklad_1 = sklad.id
      WHERE mecz.id = NEW.mecz
    )
    WHERE mecz.id = NEW.mecz;
  END IF;

  IF wygrane2 > wygrane1 AND wygrane2 = 3
  THEN
    RAISE WARNING 'wygrane 2 wiekszy niz wygrane 1';
    UPDATE mecz
    SET zwyciezca =
    (
      SELECT sklad.druzyna
      FROM mecz
        JOIN sklad ON mecz.sklad_2 = sklad.id
      WHERE mecz.id = NEW.mecz
    )
    WHERE mecz.id = NEW.mecz;
  END IF;

  RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER updateZwyciezcaTrigger
  AFTER INSERT ON set
  FOR EACH ROW EXECUTE PROCEDURE updateZwyciezca();


INSERT INTO druzyna
VALUES (0, 'Mecz nierozegrany')

