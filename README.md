# Markan Performance

Web aplikacija za salon luksuznih automobila.

Administratori upravljaju ponudom automobila i korisnicima. Kupci pregledavaju ponudu i mogu zatražiti kupnju automobila.

## Funkcionalnosti

### 1. Autentikacija korisnika
- Registracija novog korisnika (uloga customer po defaultu) i prijava postojećeg korisnika.
- Lozinke se spremaju isključivo kao hash (password_hash, password_verify, bcrypt algoritam).
- Svi upiti prema bazi idu kroz pripremljene naredbe (mysqli prepare, bind_param), čime se sprječava SQL injekcija.
- Ulazni podaci iz formi filtriraju se pomoću filter_input().

### 2. Kontrola pristupa po ulogama
Aplikacija ima dvije uloge:

- admin - upravlja korisnicima i automobilima, odobrava/odbija zahtjeve za kupnju.
- customer - pregledava ponudu automobila i može zatražiti kupnju.

Pristup stranicama provjerava se u kontrolerima (requireAuth(), requireAuth("admin")).

### 3. CRUD funkcionalnost

Korisnici (users) - Create, Read, Update, Delete

Automobili (cars) - Create, Read, Update, Delete

### 4. Nadzorna ploča
Razlikuje se prema ulozi:
- Admin - statistika salona (broj korisnika, broj automobila po statusu) i zahtjevi za kupnju koji čekaju potvrdu.
- Customer - njegova vozila (na čekanju / kupljena) i broj dostupnih automobila.

### 5. Ostalo
- Relacija jedan-prema-više - jedan korisnik može kupiti više automobila.
- MVC arhitektura - kod je podijeljen na modele, poglede i kontrolere, s jedinstvenom ulaznom točkom i Routerom.

## Upute za pokretanje
### 1. Preuzimanje projekta
Kopiraj mapu markanperformance u htdocs svog poslužitelja:

Windows

- C:\xampp\htdocs\markanperformance

(Arch) Linux

- /opt/lampp/htdocs/markanperformance

### 2. Izrada baze podataka
1. Pokreni Apache i MySQL u XAMPP Control Panelu.
2. Otvori phpMyAdmin (http://localhost/phpmyadmin).
3. Kopiraj i zalijepi sve iz database/schema.sql u SQL karticu ili idi na karticu Import i odradi korak 4.
4. Odaberi datoteku database/schema.sql i pokreni uvoz.

Ova datoteka sama kreira bazu markanperformance, tablice i testne podatke.

### 3. Otvaranje aplikacije

Otvori u pregledniku:

- http://localhost/markanperformance/public/

## Korisnički računi

Admin

- username: admin
- password: admin

Customer

- username: customer
- password: customer

## Tijek kupnje automobila

Available (na prodaju)

- kupac pritisne "Kupi" -> pending (na čekanju)

Pending (čeka potvrdu admina)

- admin pritisne "Potvrdi" -> sold (prodano)
- admin pritisne "Odbij" -> available (vraća se u ponudu)
