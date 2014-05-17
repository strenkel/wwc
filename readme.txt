INSTALLATION
-- stand: 9.5.2014

- Apache Server (min-version 2.4) aufsetzen mit php (min-version 5.3)
- MySql - Server mit Datenbank wwc (min-version 5.5)
- Source-Verzeichnis wwc in das apache root Verzeichnis (z.B. 'www', 'http', 'htdocs', ...) kopieren.
- Parallel zum apache root ein Verzeichnis config anlegen und dort eine Datei 'wwc.ini' anlegen.
- wwc.ini Datei mit folgenden Config-Werten füllen:
    mysqlUser = "..." (meist 'root')
    mysqlPassword = "..."
    mysqlDb = "wwc"
    mysqlServer = "..." (z.B. 'localhost', 'example.com:3307', ...)
- Aus dem Source-Verzeichnis wwc/sql das sql-Script CreateAll.sql auf der leeren Datenbank wwc ausführen.
- Einen Ordner 'worker' im Source-Verzeichnis 'w2c' anlegen. Schreibrechte für den Server setzten. (Hier kommen die hochgeladenen Worker rein.)
- achape und mysql starten
- z.B. 'http://localhost/wwc/' in einem aktuellen Browser (ff>29, ie>11, chrome>34) aufrufen.
- Worker aus dem Verzeichnis 'worker-examples' zum Testen hochladen.
