INSTALLATION
-- stand: 24.5.2014

- Apache Server (min-version 2.4) aufsetzen mit php (min-version 5.3)
- MySql - Server mit Datenbank wwc / wwctest aufsetzen (min-version 5.5)
- DB-Skripte CreateAll.sql und CreateSuperuser.sql ausführen.
- In Tabelle einen Eintrag mit login='superuser' und md5-verschluesseltem Passwort anlegen.
- Source-Verzeichnis wwc / wwctest in das apache root Verzeichnis (z.B. 'www', 'http', 'htdocs', ...) kopieren.
- Parallel zum apache root ein Verzeichnis config anlegen und dort eine Datei 'wwc-password.ini' anlegen.
- In wwc / wwctest ebenfalls ein Verzeichnis config anlegen und dort eine Datei 'wwc.ini' anlegen.
- wwc.ini Datei mit folgenden Config-Werten füllen:
    mysqlUser = "..." (meist 'root')
    mysqlPassword = "..."
    mysqlDb = "wwc" oder "wwctest"
    mysqlServer = "..." (z.B. 'localhost', 'example.com:3307', ...)
- wwc-password-ini wie folgt fuellen:
    mysqlPassword_wwc = "..."
    mysqlPassword_wwctest = "..."
- Einen Ordner 'worker' im Source-Verzeichnis 'wwc' anlegen. Schreibrechte für den Server setzten. (Hier kommen die hochgeladenen Worker rein.)
- achape und mysql starten
- z.B. 'http://localhost/wwc/' in einem aktuellen Browser (ff>29, ie>11, chrome>34) aufrufen.
- Worker aus dem Verzeichnis 'worker-examples' zum Testen hochladen.
- Weitere Infos, insbesondere zum Spiel: www.webworkercontest.net
