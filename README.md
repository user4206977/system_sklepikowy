# 🏫 Zegowska Szama – System Zamówień Sklepiku Szkolnego

## 📌 Opis projektu

**Zegowska Szama** to nowoczesna aplikacja webowa stworzona z myślą o społeczności szkolnej. Umożliwia uczniom oraz nauczycielom wygodne przeglądanie oferty szkolnego sklepiku oraz składanie zamówień online z odbiorem osobistym. System wyposażony jest również w zaawansowany panel administracyjny dla obsługi sklepiku, pozwalający na zarządzanie asortymentem, promocjami i zamówieniami w czasie rzeczywistym.

* **Czas realizacji:** 25.03.2026 - 31.05.2026
* **Adres wersji produkcyjnej:** [https://zegowskaszama.page.gd](https://zegowskaszama.page.gd)

---

## 👥 Zespół projektowy

* **Wojciech Złonkiewicz** – Leader projektu
* **Maciej Strzelec** – Główny wykonawca
* **Wojciech Strzezik** – Wsparcie techniczne

---

## 🛠️ Architektura i Technologie

### Wykorzystane technologie

* **Backend:** PHP (wersja >= 7.4) – model proceduralny z podziałem na moduły logiczne
* **Frontend:** JavaScript + Bootstrap (pełna responsywność) + HTML5/CSS3
* **Baza danych:** MySQL / MariaDB

### Struktura architektury (zbliżona do MVC)

* **Model:** Plik `includes/db.php` (połączenie z bazą) oraz struktura zaszyta w pliku `zegowska_szama.sql`.
* **Widok (View):** Pliki `.php` w katalogu głównym (np. `index.php`) budujące interfejs z wykorzystaniem reużywalnych komponentów z folderu `includes/` (`header.php`, `footer.php`).
* **Kontroler (Logika):** Skrypty procesujące dane, takie jak `login.php`, `register.php` oraz `admin/orders.php`.

---

## 📋 Wymagania i Funkcjonalności Systemu

### Wymagania Funkcjonalne (User Stories)

| Rola | Cel | Kryteria akceptacji |
| --- | --- | --- |
| **Uczeń / Nauczyciel** | Rejestracja i logowanie | Formularz z walidacją, haszowanie haseł w PHP, utrzymanie sesji, widoki zastrzeżone dla zalogowanych. |
| **Uczeń / Nauczyciel** | Przeglądanie produktów | Dynamiczna lista z MySQL, wyszukiwanie i filtrowanie (JS), widoczna nazwa, cena i status dostępności. |
| **Zalogowany użytkownik** | Dostęp do promocji | Osobna sekcja „Promocje”, specjalne oznaczenia tańszych produktów. |
| **Zalogowany użytkownik** | Składanie zamówień | Koszyk w JavaScript (`localStorage`/sesja), zapis do bazy MySQL, podgląd historii w `my_orders.php`. |
| **Administrator** | Zarządzanie użytkownikami | Lista kont, możliwość usuwania użytkowników i zmiany ról (`user`/`admin`). Bezpieczeństwo sesji. |
| **Administrator** | Zarządzanie produktami | Formularz dodawania, edycji oraz usuwania produktów z bazy. |
| **Administrator** | Zarządzanie zamówieniami | Podgląd spływających zamówień na żywo, szczegóły koszyka, zmiana statusu zamówienia. |

### Wymagania Niefunkcjonalne oraz UX/UI

* **Spójność wizualna:** Jednolita kolorystyka nawiązująca do barw szkoły, maksymalnie 2–3 kroje pisma, standardowe komponenty Bootstrap.
* **Dostępność (WCAG) & Optymalizacja:** Kontrast tekst-tło, teksty alternatywne dla grafik, obsługa focusu z klawiatury. Grafiki w formatach JPG/PNG z kompresją oraz ikony w formacie SVG.
* **Responsywność:** Skalowanie i poprawne wyświetlanie na komputerach, tabletach oraz smartfonach.

---

## ⚙️ Instrukcja Instalacji i Wdrożenia

### Środowisko lokalne (XAMPP)

1. Skopiuj folder projektu do katalogu `C:/xampp/htdocs/zegowska_szama/`.
2. Uruchom **Apache** oraz **MySQL** w XAMPP Control Panel.
3. Wejdź na `localhost/phpmyadmin`, utwórz bazę danych `zegowska_szama` i zaimportuj plik `zegowska_szama.sql`.
4. Skonfiguruj dane dostępowe w pliku `includes/db.php`.

### Środowisko produkcyjne (InfinityFree / VistaPanel)

1. **Pliki:** Za pomocą FM-Manager wgraj zawartość projektu bezpośrednio do katalogu publicznego `htdocs/` (usuwając domyślny plik `index.html`).
2. **Baza danych:** W *VistaPanel -> MySQL Databases* utwórz bazę danych, przejdź do phpMyAdmin i zaimportuj plik `zegowska_szama.sql`.
3. **Konfiguracja PHP:** Zaktualizuj plik `includes/db.php` o dane produkcyjne:
```php
// Przykład konfiguracji w includes/db.php
$host = "sql207.infinityfree.com"; // Adres serwera iFastNet
$user = "if0_twoj_uzytkownik";
$pass = "twoje_haslo";
$dbname = "if0_nazwa_bazy";

```



---

## 📖 Instrukcja Obsługi Aplikacji

### 👤 Dla Klienta (Uczeń / Nauczyciel)

1. **Konto:** Kliknij żółty przycisk **Zaloguj się**, a następnie przejdź do linku rejestracji. Załóż konto podając e-mail i hasło (otrzyma ono domyślną rolę `user`).
2. **Zakupy:** W zakładce *Oferta* przeglądaj menu. Produkty dostępne posiadają niebieski przycisk `+` (dodanie do koszyka). Produkty niedostępne są poszarzone i zablokowane.
3. **Finalizacja:** Kliknij ikonę koszyka w prawym górnym rogu, sprawdź podsumowanie i kliknij **Złóż zamówienie**. Status sprawdzisz w sekcji **Moje zamówienia**.

### 🔑 Dla Administratora (Obsługa Sklepiku)

Po zalogowaniu na konto z rolą `admin` w bazie danych, w menu głównym pojawi się zakładka **Panel Admina**:

* **Zarządzanie Menu (`admin/products.php`):** Umożliwia dodawanie nowych potraw, natychmiastowe włączanie/wyłączanie promocji oraz flagi dostępności (W sklepie / Brak) za pomocą suwaków (Toggle). Każda zmiana wymaga kliknięcia ikony zapisu.
* **Obsługa Zamówień (`admin/orders.php`):** Podgląd wszystkich zamówień od uczniów w czasie rzeczywistym z opcją aktualizacji statusu.

---

## 📅 Status projektu

🔧 **Aktualna faza:** Zakończono 