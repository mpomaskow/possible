Krótko o projekcie.
Baza danych MySQL InnoDB:
tabela osoby - relacje zapięte na kolumnach osoby.miejscowosc -> miejscowosci.id, osoby.firma -> firmy.id, osoby.oddzial_firmy -> oddzialy_firm.id
tabela oddzialy_firm - relacja zapieta na kolumnie odzialy_firmy.firma -> firma.id
reszta standardowa opis w pliku config/schema.xml
przykladowe dane zrzucone do pliku: data/fixtures/100_all.yml
odtworzenie ich w bazie danych po wprowadzeniu hasla do bazy danych w config/databases.yml all.propel.param.password, utworzeniu tabeli w bazie possible_zadanie
potem z lini komend: symfony propel:insert-sql i propel:data-load

Aplikacja frontend dodany moduł osoby i na niego ustawiony domyslny routing.
Wszystko generowane dynamicznie za pomoca ustawien apps/frontend/modules/osoby/config/generator.yml
To znaczy ustawienie widocznych pól na liście, metoda ktora pobierane sa wpisy osob zmieniona z doSelect na doSelectJoinAll aby za jednym razem zaciagal relacje (miejscowosc, firmy, oddzialy firm) bo i tak to wszystko jest potrzebne, a zmniejsza liczbe zapytań.
Dodatkowo dodane style i js w pliku config.yml: jquery, jquery ui i obsluga javascriptu formularza: inicjalizacja datepicker z jquery ui i ustawianie oddzialów firm w zależności od wybranej firmy.
Wyswietlanie wieku i płci zrealizowane poprzez dodanie dwoch metod w pliku modelu lib/model/Osoby.php

Formularz dodawania/edycji:
konfiguracja w lib/form/OsobyForm.class.php: glownie ustawienie sortowania elementow zaciaganych po relacjach, ustawienie atrybutów elementow html aby js mial do nich dostęp, ustawienia walidatora daty poprzez wyrazenie regularne aby sprawdzal czy zgadza sie z formatem dddd-dd-dd.

JS formularza:
web/js/frontend/OsobyForm.js

klasa OsobyForm ktora zwraca dwie metody publiczne inicjujKalendarz, zmienOddzialy.
Metoda zmienOddzialy nie wykorzystuje ajaxa opiera sie na pobraniu listy wszystkich dostepnych oddzialow z DOM przegladarki, zrobienia z nich tablicy i filtrowania po zadanych parametrach.
W przypadku krótkich list zwiększa to szybkość dziłania formularza, w przypadku bardzo duzej ilości rekordów oddziałów można by się pokusić o zrobienia tego asynchronicznie.