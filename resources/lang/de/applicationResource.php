<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    # -- standard errors --
    'errors.header' => '<UL>',
    'errors.prefix' => '<LI>',
    'errors.suffix' => '</LI>',
    'errors.footer' => '</UL>',
# -- validator --
    'errors.invalid' => '{0} is invalid.',
    'errors.maxlength' => '{0} can not be greater than {1} characters.',
    'errors.minlength' => '{0} can not be less than {1} characters.',
    'errors.range' => '{0} is not in the range {1} through {2}.',
    'errors.required' => '{0} is required.',
    'errors.byte' => '{0} must be an byte.',
    'errors.date' => '{0} is not a date.',
    'errors.double' => '{0} must be an double.',
    'errors.float' => '{0} must be an float.',
    'errors.integer' => '{0} must be an integer.',
    'errors.long' => '{0} must be an long.',
    'errors.short' => '{0} must be an short.',
    'errors.creditcard' => '{0} is not a valid credit card number.',
    'errors.email' => '{0} is an invalid e-mail address.',
# -- other --
    'errors.cancel' => 'Operation cancelled.',
    'errors.detail' => '{0}',
    'errors.general' => 'The process did not complete. Details should follow.',
    'errors.token' => 'Request could not be completed. Operation is not in sequence.',
# -- welcome --
    'welcome.title' => 'Struts Application',
    'welcome.heading' => 'Struts Applications in Netbeans!',
    'welcome.message' => "It's easy to create Struts applications with NetBeans.",
# -- Menu --
    'menu.sesion' => 'Login',
    'menu.busqueda' => 'SUCHE',
    'menu.historial' => 'SUCHVERLAUF ',
    'menu.colaboradores' => 'MITWIRKENDE',
    'menu.ayuda' => 'HILFE',
    'menu.agradecimientos' => 'DANKSAGUNG',
    'menu.condiciones' => 'NUTZUNGSBEDINGUNGEN',
# -- Submenu --
    'submenu.nombre' => 'Name',
    'submenu.estructura' => 'Struktur',
    'submenu.subestructura' => 'Substruktur',
    'submenu.desplazamiento' => 'Chemische Verschiebung',
    'submenu.tipocarbono' => 'Kohlenstoffbindung',
# -- SubSubMenu --
    'subsub.sinposicion' => 'Ohne position',
    'subsub.conposicion' => 'Mit position',
    'subsub.iterativa' => 'Iteration',
    'subsub.vecindad' => 'Nachbaratome',
# -- Inicio --
    'sesion.tituloc' => 'C<sup>13</sup> NMR Datenbank für Naturstoffe',
    'sesion.subtituloc' => 'Hier finden sie verschiedene Möglichkeiten zur Suche nach der Struktur von chemischen Verbindungen Suche anhand verschiedener Kriterien',
# -- Historial --
    'historial.historial' => 'Suchverlauf',
    'historial.numbusqueda' => 'Anfrage',
    'historial.codbusqueda' => 'Chiffre',
    'historial.numcompuestos' => 'Verbindungen',
    'historial.critbusqueda' => 'Kriterien',
    'historial.ver' => 'Ergebnisse',
    'historial.combinar' => 'Verknüpfen',
    'historial.eliminar' => 'Löschen',
# -- Formulario --
    'form.busquedas.nombre' => 'Suchkriterium: Name',
    'form.familia' => 'Stoffgruppe',
    'form.tipo' => 'Untergruppe',
    'form.grupo' => 'Teilgruppe',
    'form.formulamol' => 'Summenforme',
    'form.heteroatomo' => 'Heteroatom',
    'form.pesomol' => 'Molekülgewicht',
    'form.nombretri' => 'Trivialname',
    'form.nombresemi' => 'Systematischer Name',
    'form.biblio' => 'Bibliografie',
    'form.autores' => 'Autoren',
    'form.revista' => 'Fachzeitschrift',
    'form.anio' => 'Jahr',
    'form.vol' => 'Band',
    'form.pag' => 'Seites',
    'form.buscar' => 'SUCHE',
# -- Colaboradores --
    'colab.colaboradores' => 'Mitwirkende',
    'colab.autor' => 'Autor',
    'colab.email' => 'eMail',
    'colab.organismo' => 'Institut',
    'colab.pais' => 'Land',
    'colab.numcompuestos' => 'Anzahl der Einträge',

    # -- Ayuda --
    'ayuda.menu.ayuda' => 'HILFE',
    'ayuda.menu.busqueda' => 'SUCHKRITERIEN',
    'ayuda.menu.nombre' => 'NAME',
    'ayuda.menu.subestructura' => 'SUBSTRUKTUR',
    'ayuda.menu.iterativa' => 'ITERATION',
    'ayuda.menu.tipos' => 'ATOMBINDUNG',
    'ayuda.menu.historial' => 'SUCHVERLAUF',
    'ayuda.menu.resultados' => 'SUCHERGEBNISSE',
    'ayuda.menu.editor' => 'EDITOR',

    'ayuda.busnombre.p0' => 'NAME',
    'ayuda.busnombre.p1' => 'Um NAPROC-13 für eine Suche, von Verbindung mit einem bestimmten Namen zu nutzen, klicken Sie in der Menüleiste links auf “Suche” und anschließend auf “Name”. Es wird eine neue Seite geöffnet. Diese beinhaltet verschiedene Kriterien, die Sie frei kombinieren können.',
    'ayuda.busnombre.p2' => "<strong>Beispiel Stoffgruppe:</strong> Terpenoids<br><strong>Beispiel Untergruppe:</strong> Triterpenoids<br><strong>Beispiel Teilgruppe:</strong> Oleananes",
    'ayuda.busnombre.p3' => 'Eingabe der Summenformel: Geben Sie dazu hinter den angegebenen Atomsorten deren Anzahl ein. Weiterhin können Sie das Sternchen (*) als Platzhalter bei unbekannter beziehungsweise variabler Anzahl nutzen oder ein Feld frei lassen, falls eine Atomsorte nicht vertreten sein soll.',
    'ayuda.busnombre.p4' => 'Angaben zu Trivial- oder systematischem Namen, sowie Bibliografie (Literaturnachweise): Geben Sie dazu die Daten in das oder die gewünschten Felder ein. Auch hier können Sie Platzhalter verwenden. Das Sternchen (*) steht dabei stellvertretend für eine beliebige Anzahl von Zeichen und das Fragezeichen (?) für genau ein Zeichen.',
    'ayuda.busnombre.p5' => 'Tipp: Sie können eine beliebige Anzahl von Felder ausfüllen oder frei lassen.',

    'ayuda.bussubestructura.p0' => 'SUBSTRUKTUR',
    'ayuda.bussubestructura.p1' => 'Um NAPROC-13 für eine Suche, nach Verbindungen mit einer bestimmten Molekülstruktur zu nutzen, klicken Sie in der Menüleiste links auf “Suche” und anschließend auf “Substruktur”. Es wird eine neue Seite geöffnet. Diese beinhaltet einen EDITOR zum erstellen von Strukturformeln. ',
    'ayuda.bussubestructura.p2' => 'Zeichnen Sie in diesem die Struktur oder einen Strukturbestandteil der Verbindung die Sie Suchen.Um das Erstellen der Zeichnungen zu erleichtern finden Sie eine horizontal angeordnete Schaltflächenleise mit vordefinierten Standartstrukturen, die Sie anwählen und per Klick in das Arbeitsfeld einfügen können.',
    'ayuda.bussubestructura.p3' => 'Insofern Sie zuvor unten rechts auf die Schaltfläche „mit Stereochemie“ geklickt haben, finden Sie im Editor auch ein Symbol in der Form eines liegenden Keils. Es dient der räumlichen Darstellung einer Atombindung. Wählen Sie das Symbol an und klicken sie auf eine bestehende einfache Atombindung im Arbeitsfeld. Diese verwandelt sich in einen schwarzen Keil und bei einem weiteren Klick in einen gestrichelten Keil, als Symbole für Bindungen aus der gedachten Papierebene heraus oder hinein.',
    'ayuda.bussubestructura.p4' => 'Vertikal angeordnet finden Sie die vom Editor bereitgestellten Atomsorten. Weitere können Sie durch die Verwendung der Schaltfläche “X” einfügen. Wählen Sie diese dazu an. Es öffnet sich zusätzlich ein neues kleines Fenster, in dem Sie den Kode für die Atomsorte angeben müssen.',
    'ayuda.bussubestructura.p5' => 'Mit den Auswahllisten am oberen Rand der Seite können Sie die Suche zusätzlich zur gezeichneten Struktur eingrenzen. Diese enthalten Einträge für die in der Datenbank erfassten Stoffgruppen und - sofern vorhanden - deren Unter- und Teilgruppen.',

    'ayuda.example' => 'BEISPIEL:',

    'ayuda.busiterativa.p0' => 'ITERATION',
    'ayuda.busiterativa.p1' => 'Um NAPROC-13 für eine Suche nach Verbindungen, die einer bestimmten Kombination von Werten für die chemische Verschiebung von Kohlenstoffatomen am ähnlichsten sind zu nutzen, klicken Sie in der Menüleiste links auf “Suche” und anschließend auf “Iteration”. Es wird eine neue Seite geöffnet. Dort ist es nötig die Art der Kohlenstoffbindung (C, CH, CH2 oder CH3) anzugeben.',
    'ayuda.busiterativa.p2' => 'Die Toleranz beträgt standardmäßig für jede neue Zeile den Wert 1, kann aber angepasst werden.',
    'ayuda.busiterativa.p3' => 'Um den Suchangaben die chemische Verschiebung für ein weiteres Kohlenstoffatom hinzuzufügen, drücken Sie bitte die Schaltfläche „Zeile hinzufügen“. Stellen Sie sicher, dass zuvor alle Felder der letzten Zeile ausgefüllt worden sind. ',
    'ayuda.busiterativa.p4' => 'Mit den Auswahllisten am unteren Rand der Seite können Sie die Suche zusätzlich eingrenzen. Diese enthalten Einträge für die in der Datenbank erfassten Stoffgruppen und - sofern vorhanden - deren Unter- und Teilgruppen.',
    'ayuda.busiterativa.p5' => 'Mit dieser Suchmethode finden Sie Verbindungen, die maximal die gesuchte Anzahl der chemischen Verschiebungen aufweisen, die innerhalb der angegebenen Toleranz liegen. Zum Beispiel: Wenn sie 20 Zeilen mit Werten eingeben und Verbindungen erhalten, die 12 der gesuchten Kriterien entsprechen. ',
    'ayuda.busiterativa.p6' => 'Die Suchergebnisse werden geordnet angegeben - von der höchsten zur niedrigsten Übereinstimmung mit den gesuchten Werten für die chemische Verschiebung. ',
    'ayuda.busiterativa.p7' => '<strong>Kohlenstoffbindung:</strong> CH, <strong>Chemische Verschiebung:</strong> 75, <strong>Toleranz:</strong> 3<br/><strong>Kohlenstoffbindung:</strong> CH2, <strong>Chemische Verschiebung:</strong> 101, <strong>Toleranz:</strong> 4<br/><strong>Kohlenstoffbindung:</strong> CH3, <strong>Chemische Verschiebung:</strong> 26, <strong>Toleranz:</strong> 1',
    'ayuda.busiterativa.p8' => 'Die Suche könnte beispielsweise Verbindungen finden mit einer chemischen Verschiebung für ein CH von 72 ppm und ein CH3 von 25 ppm, jedoch ohne eine Verschiebung für ein CH2 zwischen 97 und 105 ppm. ',

    'ayuda.bustipcarb.p0' => 'ATOMBINDUNG',
    'ayuda.bustipcarb.p1' => 'Um NAPROC-13 für eine Suche, nach Verbindungen mit einer bestimmten Kombination aus Anzahl und Bindung von Kohlenstoffatomen zu nutzen, klicken Sie in der Menüleiste links auf “Suche” und anschließend auf „Kohlenstoffbindung“.',
    'ayuda.bustipcarb.p2' => 'Es wird eine neue Seite mit einer Reihe von Schiebereglern geöffnet. Dort können Sie den Bereich für die Anzahl der Kohlenstoffatome mit der gesuchten Bindung (C, CH, CH2 oder CH3) einstellen. Dabei ist es auch möglich Verbindungen zu Heteroatomen anzugeben.',
    'ayuda.bustipcarb.p3' => 'Um weitere Balken hinzuzufügen oder die Belegung der Bestehenden zu ändern, drücken Sie bitte die Schaltfläche „Optionen“. Anschließend öffnet sich ein neues Fenster mit der Frage, wie viel Balken angezeigt werden sollen und anschließend wie diese belegt werden sollen. Zur Auswahl stehen die möglichen Atombindungen für das Kohlenstoffgrundgerüst oder die Kohlenstoffbindungen und Heteroatome der Gesamtstruktur.',
    'ayuda.bustipcarb.p4' => '<strong>GRUNDGERÜST:</strong> C*, CH*, CH2*, CH3*, C-O*, CH-O*, CH2-O* y CH3-O*',
    'ayuda.bustipcarb.p5' => '<strong>GESAMTSTRUKTUR:</strong> C, CH, CH2, CH3, C-O, CH-O, CH2-O, CH3-O, Br, Cl, F, H, I, N, O, P and S',
    'ayuda.bustipcarb.p6' => '<strong>Atombindung:</strong> C* <strong>Bereich der Anzahl:</strong> 0-5<br/><strong>Atombindung:</strong> CH* <strong>Bereich der Anzahl:</strong> 4-4',

    'ayuda.historial.p0' => 'SUCHVERLAUF ',
    'ayuda.historial.p1' => 'Jedes Mal wenn sie nach der Auswahl Ihrer Suchkriterien die Schaltfläche „Suchen“ drücken, erscheint eine Seite mit dem bisherigen Suchverlauf. Die Suchanfragen werden mit der jeweils zugewiesenen Nummer, Anzahl der gefunden Verbindungen und den gewählten Suchkriterien Zeilenweise aufgelistet.
Weiterhin gibt es die Möglichkeit einzelne Anfragen aus dem Verlauf zu löschen oder durch die Logischen Operatoren AND, OR oder NOT mit anderen Anfragen zu verknüpfen.Für die Auflistung der gefunden Verbindungen und ihrer Strukturformeln, drücken Sie bitte die Schaltfläche „Anzeigen“ in der Zeile der jeweiligen Suchanfrage. ',

    'ayuda.resultados.p0' => 'SUCHERGEBNISSE',
    'ayuda.resultados.p1' => 'Wenn Sie auf der Seite mit dem Suchverlauf in der Zeile einer beliebigen Suchanfrage auf die Schaltfläche “Anzeigen” drücken, gelangen Sie zu einer Übersicht der Verbindungen und ihrer Strukturformeln die den jeweiligen Suchkriterien entsprechen. Unter jeder Abbildung finden Sie zwei Verweise, die zu den Stoffeigenschaften und NMR-SPEKTRUM führen.',
    'ayuda.resultados.p2' => 'Am oberen Rand der Seite finden Sie folgende Schaltflächen:',
    'ayuda.resultados.p3' => 'Hilfe: Verweis zur Onlinehilfe',
    'ayuda.resultados.p4' => 'Analysewerkzeug: Verweis zur Anwendung für die interaktive Auswertung des Suchergebnisses.',
    'ayuda.resultados.p5' => 'Suchanfrage bearbeiten: Verweis zurück zur Seite für die Eingabe der Suchkriterien.',
    'ayuda.resultados.p6' => '"δ(ppm)in Tabellenform": Zeigt zusätzlich unter der Abbildung der Strukturformel eine Tabelle mit Daten für die chemische Verschiebung.',
    'ayuda.resultados.p7' => '"δ(ppm) in Strukturformel": Zeigt zusätzlich die Daten für die chemische Verschiebung in der Abbildung der Strukturformel.',

    'ayuda.editor.p0' => 'EDITOR',
    'ayuda.editor.p1' => 'MENÜSCHALTFLÄCHEN:',
    'ayuda.editor.p2' => ': Zeigt den SMILES-Code (Simplified Molecular Input Line Entry Specification) der erstellten Strukturformel.',
    'ayuda.editor.p3' => 'CLR: Löscht den Inhalt des Editorfensters.',
    'ayuda.editor.p4' => 'NEW: Ermöglicht das Erstellen einer neuen Struktur im gleichen Fenster, ohne die bestehenden zu löschen.',
    'ayuda.editor.p5' => 'DEL: Löscht das ausgewählte Element.',
    'ayuda.editor.p6' => '123: Ermöglicht das Nummerieren der Kohlenstoffatome.',
    'ayuda.editor.p7' => 'D-R: Löscht Substituenten - Drücken Sie dazu die Schaltfläche und klicken Sie anschließend auf die Bindung zum Stammsystem.',
    'ayuda.editor.p8' => 'QRY: Ermöglicht das Einfügen von SMARTS, also Platzhaltern für molekulare Substrukturen mit definierbaren Attributen für Suchanfragen:',
    'ayuda.editor.p9' => 'Z.B. Atomtyp und -position',
    'ayuda.editor.p10' => 'Bindungsart, aromatische oder aliphatische Struktur und Vorhandensein von Hybridorbitalen.',
    'ayuda.editor.p11' => '',
    'ayuda.editor.p12' => '+/-: Ermöglicht die Änderung der erlaubten Ladungszahl eines Atomes.',
    'ayuda.editor.p13' => 'UDO: Macht die letzte Aktion rückgängig.',
    'ayuda.editor.p14' => 'JME: Öffnet ein kleines Fenster mit Angaben zum Autor und zur Versionsnummer der Editor-Anwendung. ',
    'ayuda.editor.p15' => 'LINEARE UND ZYKLISCHE STRUKTUREN:',
    'ayuda.editor.p16' => 'Diese Schaltflächen ermöglichen das Einfügen von definierten Standartstrukturen.',
    'ayuda.editor.p17' => 'BINDUNGEN:',
    'ayuda.editor.p18' => 'Diese Schaltflächen ermöglichen das Einfügen und Ändern von Atombindungen.',
    'ayuda.editor.p19' => 'ATOMSORTEN:',
    'ayuda.editor.p20' => 'Diese Schaltflächen ermöglichen das Einfügen der dargestellten Atomsorten.',
    'ayuda.editor.p21' => 'Es ist auch möglich Atome einzufügen, die im Editor nicht aufgeführt sind. Drücken Sie dazu die Schaltfläche „X“ und klicken Sie danach an die gewünschte Stelle in der Strukturformel. Es öffnet sich zusätzlich ein kleines Fenster in dem Sie den SMILES-Code für das eingefügte Atom eingeben und bestätigen müssen.',
];
