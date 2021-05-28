# Corona-Zertifikats-Generator

Dieses Verzeichnis beinhaltet Vorlagen, um Bescheinigungen für
Coronatests in Betrieben semi-automatisch auszufüllen. Eine
solche Bescheinigung liegt z.B. für NRW bei
([Quelle](https://recht.nrw.de/lmi/owa/br_vbl_show_pdf?p_id=34628)).
Alle Bundesländer verwenden eigentlich ziemlich ähnliche Vorlagen,
die sich nur in Wappen unterscheiden.

Diese Vorlage wird in der LaTeX-File `template.tex` geladen
ausgefüllt. Dabei kann auch eine Unterschrift und ein Stempel
als Bild (PDF oder Bitmap, z.B. JPG oder PNG) geladen werden.

Das Tex-File ist derzeit mit Variablen gefüllt, die einfach
mit Kommandozeilen-Tools wie `sed` oder einfacher
Text-Ersetzung programmatorisch ersetzt werden können.

Das Script `index.php` generiert ein HTML-Formular, welches
beim Abschicken eine Kopie von `template.tex` anpasst und
ein PDF serverseitig rendert.

## Bekannte Beschränkungen

* In TikZ sollten keine Leerzeilen sein. Das macht den
  Einsatz von leeren Strings schwierig.
* Wenn das PHP-Script verwendet wird, sollte auf dem Server
  `pdflatex` vorhanden sein, mit Paketen wie `tikz`. Bei
  einem Ubuntu-Server reicht ein `apt install texlive-full`.

## Disclaimer

Wer eine Corona-Testbescheinigung fälscht oder einen nich
erfolgten Test unrichtig bescheinigt, macht sich nach § 267 StGB
der Urkundenfälschung strafbar.  Wer ein gefälschtes Dokument
verwendet, um Zugang zu einer Einrichtung oder einem Angebot
zu erhalten, begeht nach der Coronaschutzverordnung des Landes
eine Ordnungswidrigkeit, die mit einer Geldbuße in Höhe von
1000 € geahndet wird.

Das Erzeugen von gefälschten Zertifikaten mit diesem Tool ist
identisch zum Erzeugen von gefälschten Zertifikaten mit der Hand.

Diesem Repository liegen "Example"-Dateien bzgl. Unterschrift
und Firmenstempel bei. In jedem Fall ist es auch strafbar, eine
fremde Unterschrift zu verwenden und einen selbst angefertigten
Test damit zu unterzeichnen.

## Lizenz

Public Domain bzw. [Do what the fuck you want](http://www.wtfpl.net/).


