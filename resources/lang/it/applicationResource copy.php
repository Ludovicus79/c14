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
    'menu.busqueda' => 'RICERCA',
    'menu.historial' => 'CRONOLOGIA',
    'menu.colaboradores' => 'COLLABORATORI',
    'menu.ayuda' => 'AIUTO',
    'menu.agradecimientos' => 'RINGRAZIAMENTI',
    'menu.condiciones' => 'CONDIZIONI DI UTILIZZO',
# -- Submenu --
    'submenu.nombre' => 'Nome',
    'submenu.subestructura' => 'Substruttura',
    'submenu.desplazamiento' => 'Spostamento',
    'submenu.tipocarbono' => 'Tipo di carbonio',
# -- SubSubMenu --
    'subsub.sinposicion' => 'Senza posizione',
    'subsub.conposicion' => 'Con posizione',
    'subsub.iterativa' => 'Iterativa',
    'subsub.vecindad' => 'Gruppo',
# -- Inicio --
    'sesion.tituloc' => 'Base di dati di Carbonio c13 di Prodotti Naturali e Relazionati',
    'sesion.subtituloc' => "La applicazione presenta una serie di strumenti di ricerca mediante l'uso di diversi parametri chimici",
# -- Historial --
    'historial.historial' => 'Cronologia',
    'historial.numbusqueda' => 'Num. ricerca',
    'historial.codbusqueda' => 'Cod. ricerca',
    'historial.numcompuestos' => 'Num. risultati',
    'historial.critbusqueda' => 'Criterio di ricerca',
    'historial.ver' => 'Vedere risultati',
    'historial.combinar' => 'Combinare',
    'historial.eliminar' => 'Eliminare',

# -- Formulario --
    'form.busquedas.nombre' => 'Ricerca per nome',
    'form.familia' => 'Famiglia',
    'form.tipo' => 'Tipo',
    'form.grupo' => 'Gruppo',
    'form.formulamol' => 'Formula Molecolare',
    'form.heteroatomo' => 'Eteroatomo',
    'form.pesomol' => 'Peso molecolare',
    'form.nombretri' => 'Nome',
    'form.nombresemi' => 'Nome Semisistematico',
    'form.biblio' => 'Bibliografia ',
    'form.autores' => 'Autori',
    'form.revista' => 'Rivista',
    'form.anio' => 'Anno',
    'form.vol' => 'Volume',
    'form.pag' => 'Pagine',
    'form.buscar' => 'CERCARE',

   # -- Usuarios --
    'userData.name' => 'Nome',
    'userData.city' => 'Città',
    'userData.country' => 'Nazione',
    'userData.org' => 'Organismo',
    'userData.allowed' => 'Permessi',
    'user.specific' => 'Utilizzatore specifico',
    'user.user' => 'Bienvenido',

    /* -- Diálogos -- */
    'dialog.sure' => 'Sei sicuro?',
    'dialog.deleteLog' => 'Stai per eliminare un record',
    'dialog.deleteMol' => 'Stai per eliminare una molecola',
    'dialog.save' => 'Confermare i cambiamenti',
    'dialog.confirm' => 'Conferma molecola',

# -- Colaboradores --
    'colab.colaboradores' => 'Collaboratori',
    'colab.autor' => 'Autore',
    'colab.email' => 'eMail',
    'colab.organismo' => 'Istituzioni',
    'colab.pais' => 'Paese',
    'colab.numcompuestos' => 'Numero di composti',

    # -- Developers --
    'developers.title' => 'Sviluppato da',
    'developers.web' => 'Sito web personale',

    # -- Ayuda --
    'ayuda.menu.ayuda' => 'AIUTO',
    'ayuda.menu.busqueda' => 'RICERCHE',
    'ayuda.menu.nombre' => 'NOME',
    'ayuda.menu.subestructura' => 'SUBSTRUTTURA',
    'ayuda.menu.iterativa' => 'INTERATTIVA',
    'ayuda.menu.tipos' => 'TIPO DI ATOMI',
    'ayuda.menu.historial' => 'STORICO',
    'ayuda.menu.resultados' => 'RISULTATI',
    'ayuda.menu.editor' => 'EDITOR',

    'ayuda.busnombre.p0' => 'NOME',
    'ayuda.busnombre.p1' => 'Apri la lista di famiglie disponibili nella banca dati e selezionane una. Una volta selezionata, appaiono i tipi disponibili per quella famiglia se ci dovessero essere. Se si seleziona un determinato tipo, a sua volta, appaiono tutti i gruppi pertinenti a quel tipo se ci dovessero essere',
    'ayuda.busnombre.p2' => "<strong>Esempio di famiglia:</strong> Terpénoïde<br><strong>Esempio di tipo:</strong> Triterpenoïde<br><strong>Esempio di gruppo:</strong> Oléane",
    'ayuda.busnombre.p3' => 'Può includere la formula molecolare completa aggiungendo dietro ogni simbolo atomico o solo i simboli atomici includendo un asterico in ogni sua casella.',
    'ayuda.busnombre.p4' => 'Scrivi il nome volgare o semi-sistematico nella casella corrispondente. Puoi scriverlo parzialmente aggiungendo asterischi (*) o il simbolo della interrogazione (?) in qualunque parte del nome. Un asterisco rappresenta un qualsiasi numero di caratteri, mentre un punto interrogativo rappresenta un solo carattere.',
    'ayuda.busnombre.p5' => 'Puoi riempire o lasciare bianchi i campi che desideri.',

    'ayuda.bussubestructura.p0' => 'SUBSTRUTTURA',
    'ayuda.bussubestructura.p1' => 'Disegna la struttura o substruttura che desideri cercare nell\' EDITOR DELLE MOLECOLE. ',
    'ayuda.bussubestructura.p2' => 'Per facilitare la genesi di strutture dispone di una barra superiore con raggruppamenti già definiti. Premi uno di questi e dopo clicca nell\'editor.',
    'ayuda.bussubestructura.p3' => 'Nella barra di sinistra si dispone di una freccia per indicare la stereochimica e i simboli atomici. La freccia inizialmente è sempre continua; se desideri indicare una freccia a linee, disegna inizialmente una freccia continua e dopo cliccaci sopra. Alternativamente la freccia cambierà da un tipo all\'altro. La parte stretta della freccia deve puntare verso lo stereocentro.',
    'ayuda.bussubestructura.p4' => 'I simboli atomici rappresentati sono i più frequenti. La X è un jolly. Inizialmente rappresenta un idrogeno però se desideri cambiarlo con qualsiasi altro simbolo puoi indicarlo nella finestra di dialogo mostrata.',
    'ayuda.bussubestructura.p5' => 'La ricerca per substruttura si può limitare a una famiglia , al tipo o gruppo di prodotti naturali selezionando la famiglia, tipo o gruppo desiderati situati nel menu della parte superiore.',

    'ayuda.example' => 'ESEMPIO:',

    'ayuda.busiterativa.p0' => 'INTERATTIVA',
    'ayuda.busiterativa.p1' => 'Questa ricerca ha come obiettivo quello di trovare quei composti che posseggano un numero massimo di carboni con shift uguali a quelli cercati nella tolleranza che si specifica. Per esempio, si potrebbero introdurre 20 shift e ottenete composti che presentano 12 shift in comune con quelli stabiliti nella ricerca. E\' importante specificare il tipo di carbonio cercato (C, CH, CH2, CH3)',
    'ayuda.busiterativa.p2' => 'Per difetto la tolleranza nella ricerca e\' 1; però si può stabilirne un\'altra diversa per ognuno dei carboni introdotti.',
    'ayuda.busiterativa.p3' => 'Per introdurre shift addizionali,premere il pulsante “nuovo shift” e apparirà un\'altra linea di campi vuota. Non si può ottenere una nuova linea finchè l\'anteriore non sia stata riempita completamente.Questa operazione si può ripetere tante volte quanto si desideri.',
    'ayuda.busiterativa.p4' => 'Addizionalmente possiamo accorciare la ricerca se conosciamo il tipo di composto problema,potendo specificare la famiglia,il tipo o il gruppo.',
    'ayuda.busiterativa.p5' => '',
    'ayuda.busiterativa.p6' => 'I composti trovati nella ricerca appaiono ordinati secondo il numero e la similitudine dei suoi shift con quelli introdotti con la ricerca.',
    'ayuda.busiterativa.p7' => '<strong>Tipo di carbonio:</strong> CH, <strong>Shift:</strong> 75, <strong>Tolleranza:</strong> 3<br/><strong>Tipo di carbonio:</strong> CH2, <strong>Shift:</strong> 101, <strong>Tolleranza:</strong> 4<br/><strong>Tipo di carbonio:</strong> CH3, <strong>Shift:</strong> 26, <strong>Tolleranza:</strong> 1',
    'ayuda.busiterativa.p8' => 'Si potrebbero trovare composti che abbiano un CH a 72 ppm e un CH3 a 25 ppm e potranno mancare di un CH2 tra 97-105 ppm.',

    'ayuda.bustipcarb.p0' => 'TIPO DI ATOMI',
    'ayuda.bustipcarb.p1' => 'Permette la ricerca di composti che possiedono el numero e il tipo di atomi di Carbonio(C, CH, CH2, CH3) che si specificano in forma grafica mediante un sistema di barre. Si possono anche stabilire come criteri di ricerca il numero e il tipo di atomi di Carbonio uniti a Ossigeno e Azoto,così come il numero di eteroatomi. In tutti i casi si può definire un numero concreto per ogni tipo di atomo o stabilire un intervallo. Dispone di un sistema de barre con due marcatori para stabilire il numero massimo e minimo degli atomi cercati in modo rapido e semplice.',
    'ayuda.bustipcarb.p2' => 'La ricerca è completamente configurabile. Basta premere il tasto "Configurare". Appare una finestra nella quale si chiede l\'inserimento del numero di barre nelle quali si definiranno il tipo di atomi per i quali si desidera realizzare la ricerca. Stabilito questo numero, appare un\'altra finestra per stabilire il tipo di carbonio e gli eteroatomi per i quali si desidera realizzare la ricerca. Questa opzione si può stabilire solamente per lo scheletro del composto o per tutta la struttura del composto.',
    'ayuda.bustipcarb.p3' => 'L\' asterisco in apice indica che si tratta di tipi di atomi di carbonio dello scheletro del composto.',
    'ayuda.bustipcarb.p4' => '<strong>SCHELETRO:</strong> C*, CH*, CH2*, CH3*, C-O*, CH-O*, CH2-O* y CH3-O*',
    'ayuda.bustipcarb.p5' => '<strong>STRUTTURA TOTALE:</strong> C, CH, CH2, CH3, C-O, CH-O, CH2-O, CH3-O, Br, Cl, F, H, I, N, O, P and S',
    'ayuda.bustipcarb.p6' => '<strong>Tipo di atomo:</strong> C* <strong>Intervallo:</strong> 0-5<br/><strong>Tipo di atomo:</strong> CH* <strong>Intervallo:</strong> 4-4',

    'ayuda.historial.p0' => 'STORICO',
    'ayuda.historial.p1' => 'Quando si preme il pulsante “cercare” in qualsiasi delle ricerche, appare una pagina con lo storico delle ricerche realizzate. Ogni ricerca eseguita si definisce in una linea e appaiono ordinate in maniera correlata. In ognuna di esse si specifica il numero di ricerca , il numero di composti trovati, il criterio che è stato utilizzato nella ricerca. Dispongono di un quadro per la loro eliminazione e un altro per la loro attivazione con il fine di realizzare in seguito ricerche booleane con le opzioni "OR", "AND" o "NOT" tra le diverse ricerche realizzate precedentemente.',

    'ayuda.resultados.p0' => 'RISULTATI',
    'ayuda.resultados.p1' => 'Premendo il pulsante “Vedere” nello schermo dello storico, si mostrano le strutture dei composti ottrnuti nella ricerca. Sotto a ogni struttura appaiono due link per accedere alle proprietà del composto e per rappresentare il suo SPETTRO graficamente',
    'ayuda.resultados.p2' => 'Nella parte superiore della finestra si trovano i seguenti bottoni:',
    'ayuda.resultados.p3' => 'Aiuto: Accede a questo sistema di aiuto',
    'ayuda.resultados.p4' => 'Strumento Analitico: Accede a una herramienta analítica visual.',
    'ayuda.resultados.p5' => 'Affinare Ricerca: Torna alla pagina della ricerca realizzata.',
    'ayuda.resultados.p6' => '"δ(ppm)in tavola": Mostra una tavola con i dati degli shift dei carboni del composto selezionato.',
    'ayuda.resultados.p7' => '"δ(ppm) in struttura": Mostra gli shift su ogni atomo di carbonio nella struttura.',

    'ayuda.editor.p0' => 'EDITOR',
    'ayuda.editor.p1' => 'CONTROLES:',
    'ayuda.editor.p2' => ': Presenta il codice Smiles della struttura disegnata.',
    'ayuda.editor.p3' => 'CLR: Cancella il contenuto della finestra dell\'editor.',
    'ayuda.editor.p4' => 'NEW: Comincia un\'altra catena diversa da quella che si stava disegnando.',
    'ayuda.editor.p5' => 'DEL: Cancella l\'elemento che si seleziona in seguito.',
    'ayuda.editor.p6' => '123: Una volta premuto, numererà i carboni premendoci sopra',
    'ayuda.editor.p7' => 'D-R: Cancella il gruppo funzionale che si seleziona in seguito.',
    'ayuda.editor.p8' => 'QRY: Permette di realizzare ricerche booleane complesse:',
    'ayuda.editor.p9' => 'Specificare vari tipi di atomi in qualsiasi posizione.',
    'ayuda.editor.p10' => 'Specificare il tipo di legami,se formano parte di un anello.',
    'ayuda.editor.p11' => 'In questa maniera si potenziano considerabilmente le ricerche.',
    'ayuda.editor.p12' => '+/-: Cambia le cariche atomiche in modo ragionevole.',
    'ayuda.editor.p13' => 'UDO: Annulla l\'ultimo passaggio.',
    'ayuda.editor.p14' => 'JME: Mostra l\'autore e la versione dell\' applet.',
    'ayuda.editor.p15' => 'FORME:',
    'ayuda.editor.p16' => 'Questi tasti permettono di creare forme standard già definite.',
    'ayuda.editor.p17' => 'LEGAMI:',
    'ayuda.editor.p18' => 'Questi controlli permettono di scegliere i differenti tipi di legame',
    'ayuda.editor.p19' => 'ATOMI:',
    'ayuda.editor.p20' => 'I distinti atomi che si possono scegliere per creare la substruttura.',
    'ayuda.editor.p21' => 'Sono i tipi di atomi più comuni nella chimica organica, però se se ne necessitano alcuni che non siano nella lista, e si conosce il suo codice smile si può crearlo premendo sul controllo segnato con una X. Solo si deve introdurre il suo codice smile nel quadro di dialogo che apparirà in seguito.',
];
