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

    # -- Errores --
    'errors.requeridos' => "<div id='error'>Introduce al menos un criterio de búsqueda</div>",
    'errors.busquedaNull' => "<div id='error'>No hay resultados para esa búsqueda</div>",
    'errors.deleteOk'  => "<div id='error'>Moleculas eliminadas correctamente</div>",
    'errors.shift' => 'Los campos deben ser numéricos y no estar vacíos',
    'errors.tolerance' => 'La tolerancia debe estar entre 0 y 5',
    'errors.timeLimit' => 'Se ha superado el tiempo de consulta<br>Disminuya el nivel o elimine alguna condicion',
    'errors.404' => 'Pagina no encontrada',
    'errors.generic' => 'Se ha producido un error',
    'errors.reference' => 'Esa referencia no existe',

    # -- other --
    'errors.cancel' => 'Operation cancelled.',
    'errors.detail' => '{0}',
    'errors.general' => 'The process did not complete. Details should follow.',
    'errors.token' => 'Request could not be completed. Operation is not in sequence.',
    'button.back' => 'Volver',
    'button.showHideDetails' => 'Mostrar/Ocultar Detalles',
    

    # -- welcome --
    'welcome.title' => 'Struts Application',
    'welcome.heading' => 'Struts Applications in Netbeans!',
    'welcome.message' => "It's easy to create Struts applications with NetBeans.",
    # -- Menu --
    'menu.sesion' => 'Iniciar Sesión',
    'menu.login' => 'Usuario',
    'menu.organization' => 'Organización/Universidad',
    'menu.logout' => 'Cerrar Sesión',
    'menu.password' => 'Contraseña',
    'menu.rememberMe' => 'Recordar',
    'menu.forgotPassword' => '¿Has olvidado tu contraseña?',
    'menu.resetPassword' => 'Reestablecer contraseña',
    'menu.sendReset' => 'Enviar enlace para reestablecer',
    'menu.signIn' => 'Entrar',
    'menu.signUp' => 'Registrar',
    'menu.admin' => 'Panel de Administración',
    'menu.name' => 'Nombre',
    'menu.passwordConfirm' => 'Confirmar contraseña',
    'menu.email' => 'E-Mail',
    'menu.busqueda' => 'BÚSQUEDA',
    'menu.historial' => 'HISTORIAL',
    'menu.colaboradores' => 'COLABORADORES',
    'menu.ayuda' => 'AYUDA',
    'menu.agradecimientos' => 'AGRADECIMIENTOS',
    'menu.condiciones' => 'CONDICIONES DE USO',
    'menu.developers' => 'DESARROLLADORES',
    'menu.print' => 'Imprimir / Descargar PDF',
    'menu.analitica' => 'Herramienta Analítica',
    # -- Submenu --
    'submenu.nombre' => 'Nombre',
    'submenu.estructura' => 'Estructura',
    'submenu.subestructura' => 'Subestructura',
    'submenu.desplazamiento' => 'Desplazamiento',
    'submenu.tipocarbono' => 'Tipo de Carbono',
    # -- SubSubMenu --
    'subsub.sinposicion' => 'Sin posición',
    'subsub.conposicion' => 'Con posición',
    'subsub.iterativa' => 'Iterativa',
    'subsub.vecindad' => 'Vecindad',
    # -- Inicio --
    'sesion.tituloc' => 'Base de datos de Carbono<sup>13</sup> de Productos Naturales y Relacionados',
    'sesion.subtituloc' => 'Dispone de una serie de herramientas que facilitan la identificación estructural de Productos Naturales',
    # -- Historial --
    'historial.historial' => 'Historial',
    'historial.numbusqueda' => 'Nº de búsqueda',
    'historial.codbusqueda' => 'Codigo de búsqueda',
    'historial.numcompuestos' => 'Nº de compuestos',
    'historial.critbusqueda' => 'Criterio de búsqueda',
    'historial.ver' => 'Ver Resultados',
    'historial.combinar' => 'Combinar',
    'historial.eliminar' => 'Eliminar',
    'historial.busquedaRefinada' => 'Busqueda Refinada',

    # -- Disolventes --
    'solvent.C' => 'Cloroformo-d',
    'solvent.M' => 'Metanol-d4',
    'solvent.A' => 'Acetona-d6',
    'solvent.P' => 'Piridina-d5',
    'solvent.DMSO' => 'Dimetilsulfoxido-d6',
    'solvent.D' => 'Dimetilsulfoxido-d6',
    'solvent.C+D' => 'Cloroformo-d + Dimetilsulfoxido-d6',
    'solvent.C+M' => 'Cloroformo-d + Metanol-d4',
    'solvent.C+Ac' => 'Cloroformo-d + Acetonitrilo-d3',
    'solvent.M+M' => 'Metanol-d4 + Metanol-d4',
    'solvent.M+W' => 'Metanol-d4 + Agua',
    'solvent.Ac' => 'Acetonitrilo-d3',
    'solvent.B' => 'Benceno-d6',
    'solvent.W' => 'Agua',
    'solvent.T' => 'Tetracloruro de carbono',
    'solvent.DC' => 'Diclorometano-d2',
    'solvent.F' => 'Acido Trifluoroacetico-d4',
    'solvent.Di' => '1,4-Dioxano',
    'solvent.AT' => 'Acido Trifluoroacetico',

    # -- Varios --
    'molecule.shift' => 'Desplazamiento',
    'molecule.solvent' => 'Disolvente',
    'molecule.spectrum' => 'Espectro',
    'molecule.hide'  => 'Ocultar',
    'result.numeration' => 'Numeración',
    'result.noNumeration' => 'Sin numeración',
    'result.compounds' => 'compuestos',
    'result.results' => 'Resultados de la búsqueda',
    'properties.types' => 'Tipos',
    'properties.properties' => 'Propiedades',
    'delete' => 'Eliminar',

    # -- Criterios --
    'criteria.family' => 'Familia',
    'criteria.subFamily' => 'Tipo',
    'criteria.subSubFamily' => 'Grupo',
    'criteria.molecularFormula' => 'Formula Molecular',
    'criteria.minWeight' => 'Peso minimo',
    'criteria.maxWeight' => 'Peso maximo',
    'criteria.triName' => 'Nombre Trivial',
    'criteria.semiName' => 'Nombre Sistemático',
    'criteria.authors' => 'Autores',
    'criteria.magazine' => 'Revista',
    'criteria.year' => 'Año',
    'criteria.volume' => 'Volumen',
    'criteria.page' => 'Paginas',
    'criteria.minCarbons' => 'Nivel de búsqueda',
    'criteria.conditions' => 'Condiciones cumplidas',
    'criteria.createdAt' => 'Fecha de creación',


    # -- Formulario --
    'form.tolerance' => 'Tolerancia',
    'form.selectCarbonType' => 'Tipo de Carbono',
    'form.selectFamily' => 'Elige una familia',
    'form.selectSubFamily' => 'Elige un tipo',
    'form.selectSubSubFamily' => 'Elige un grupo',
    'form.heteroAtom' => 'HeteroAtomo',
    'form.busquedas.nombre' => 'Búsqueda por nombre',
    'form.busquedas.subestructura' => 'Búsqueda por subestructura',
    'form.busquedas.desplazamiento' => 'Búsqueda por desplazamiento',
    'form.busquedas.tiposCarbono' => 'Búsqueda por tipos de carbono',
    'form.familia' => 'Familia',
    'form.tipo' => 'Tipo',
    'form.grupo' => 'Grupo',
    'form.formulamol' => 'Fórmula Molecular',
    'form.heteroatomo' => 'Heteroátomo',
    'form.pesomol' => 'Peso Molecular',
    'form.nombretri' => 'Nombre Trivial',
    'form.nombresemi' => 'Nombre Semisistemático',
    'form.biblio' => 'Bibliografía',
    'form.autores' => 'Autores',
    'form.revista' => 'Revista',
    'form.anio' => 'Año',
    'form.vol' => 'Volumen',
    'form.pag' => 'Páginas',
    'form.buscar' => 'BUSCAR',
    'form.iteraciones' => 'Iteraciones',
    'form.minimo' => 'Nivel de búsqueda',
    'form.estereoquimica' => 'Estereoquímica',
    'form.compare' => 'Moleculas seleccionadas',

    # -- Búsqueda por tipos de carbono --
    'type.esqueleto' => 'Esqueleto',
    'type.carbono' => 'Carbonos',
    'type.heteroatomos' => 'Heteroátomos',
    'type.tipos' => 'Tipos de carbono',
    'type.alifaticos' => 'Alifáticos',
    'type.aromaticos' => 'Aromáticos',
    'type.olefinicos' => 'Olefínicos',
    'type.otros' => 'Otros',

    # -- Administración --
    'admin.panel' => 'Panel de Administrador',
    'admin.excel' => 'Cargar Excel',
    'admin.logs' => 'Informes de Errores',
    'admin.users' => 'Administrar Usuarios',
    'admin.mol' => 'Administrar Moléculas',
    'admin.config' => 'Configuración',
    'admin.search' => 'Buscar',
    'admin.new' => 'Nueva Molécula',
    'admin.edit' => 'Editar Molécula',
    'admin.confirm' => 'Confirmar Molécula',
    'admin.selectFile' => 'Elige un archivo',
    'admin.references' => 'Referencias',
    'admin.lastMol' => 'Últimas Moléculas',
    'admin.deleteUser' => 'usuario eliminado correctamente',

    # -- Datos de la molécula --
    'molData.name' => 'Nombre Trivial',
    'molData.ssname' => 'Nombre Sistemático',
    'molData.family' => 'Familia',
    'molData.group' => 'Grupo',
    'molData.type' => 'Tipo',
    'molData.solvent' => 'Disolvente',
    'molData.formula' => 'Fórmula Molecular',
    'molData.weight' => 'Peso molecular',
    'molData.smiles' => 'Smiles',
    'molData.smilesNum' => 'Smiles numeración',
    'molData.smilesDes' => 'Smiles desplazamiento',
    'molData.jme' => 'Jme',
    'molData.jmeNum' => 'Jme numeración',
    'molData.jmeDes' => 'Jme desplazamiento',
    'molData.bibliography' => 'Bibliografía',
    'molData.author' => 'Autor',
    'molData.comments' => 'Comentarios',
    'molData.priComments' => 'Comentarios privados',
    'molData.carbons' => 'Carbonos',
    'molData.rmn' => 'Desplazamientos Químicos RMN <sup>13</sup>C',
    'molData.state' => 'Estado',


    #--DAtos de la bibliografía --
    'biblioData.authors' => 'Autores',
    'biblioData.magazine' => 'Revista',
    'biblioData.year' => 'Año',
    'biblioData.volume' => 'Volumen',
    'biblioData.page' => 'Página',
    'biblioData.doi' => 'DOI',

    #--DAtos del autor --
    'authorData.author' => 'Autor',
    'authorData.email' => 'Email',
    'authorData.country' => 'País',
    'authorData.organization' => 'Organización',

    #--Datos del carbono --
    'carbonData.numeration' => 'Num',
    'carbonData.numeration2' => 'Num2',
    'carbonData.type' => 'Tipo',

    # -- Usuarios --
    'userData.name' => 'Nombre',
    'userData.city' => 'Ciudad',
    'userData.country' => 'País',
    'userData.org' => 'Organización',
    'userData.allowed' => 'Permisos',
    'user.specific' => 'Usuario específico',
    'user.user' => 'Bienvenido',

    # -- Confirmar molécula --
    'confirm.id' => 'ID',
    'confirm.ref' => 'Referencia',
    'confirm.created' => 'Creado en',
    'confirm.mod' => 'Modificado en',
    'confirm.edit' => 'Editar',
    'confirm.confirm' => 'Confirmar',

    # -- Botones --
    'button.save' => 'Guardar',
    'button.modify' => 'Modificar',
    'button.delete' => 'Borrar',
    'button.deleteAll' => 'Borrar todos',
    'button.add' => 'Añadir',
    'button.new' => 'Nuevo',
    'button.view' => 'Ver',
    'button.download' => 'Descargar',
    'button.downloadAll' => 'Descargar Todos',
    'button.upload' => 'Cargar',
    'button.reload' => 'Recargar',
    'button.confirm' => 'Confirmar',
    'button.cancel' => 'Cancelar',
    'button.edit' => 'Editar',


    /* -- Diálogos -- */

    'dialog.sure' => '¿Estás seguro?',
    'dialog.deleteLog' => 'Vas a eliminar un registro',
    'dialog.deleteMol' => 'Vas a eliminar una molécula',
    'dialog.save' => 'Confirmar cambios',
    'dialog.confirm' => 'Confirmar molécula',




    # -- Colaboradores --
    'colab.colaboradores' => 'Colaboradores',
    'colab.autor' => 'Autor',
    'colab.email' => 'eMail',
    'colab.organismo' => 'Organismo',
    'colab.pais' => 'País',
    'colab.numcompuestos' => 'Núm. de compuestos',

    # -- Developers --
    'developers.title' => 'Desarrollado por',
    'developers.web' => 'Web Personal',


    # -- Ayuda --
    'ayuda.menu.ayuda' => 'AYUDA',
    'ayuda.menu.busqueda' => 'BÚSQUEDA',
    'ayuda.menu.nombre' => 'NOMBRE',
    'ayuda.menu.subestructura' => 'SUBESTRUCTURA',
    'ayuda.menu.iterativa' => 'ITERATIVA',
    'ayuda.menu.tipos' => 'TIPOS DE CARBONO',
    'ayuda.menu.historial' => 'HISTORIAL',
    'ayuda.menu.resultados' => 'RESULTADOS',
    'ayuda.menu.editor' => 'EDITOR',

    'ayuda.busnombre.p0' => 'NOMBRE',
    'ayuda.busnombre.p1' => 'Despliegue la lista de Familias disponiblen en la base de datos y seleccione una de ellas. Una vez seleccionada, aparecen los Tipos disponibles para esa Familia si los hubiera. Si selecciona un determinado Tipo, a su vez, aparecen todos los Grupos pertenecientes a ese Tipo si los hubiera.',
    'ayuda.busnombre.p2' => "<strong>Ejemplo de familia:</strong> Terpenoids<br><strong>Ejemplo de tipo:</strong> Triterpenoids<br><strong>Ejemplo de grupo:</strong> Oleananes",
    'ayuda.busnombre.p3' => 'Puede incluir la fórmula molecular completa o parcial. Añada un número detrás del símbolo atómico o un asterisco (*) si desea buscar sólo el símbolo atómico.',
    'ayuda.busnombre.p4' => 'Escriba el nombre trivial o semisistemático en la casilla correspondiente. Si lo desea puede escribirlo de forma parcial.',
    'ayuda.busnombre.p5' => 'Puede rellenar o dejar en blanco los campos que desee.',

    'ayuda.bussubestructura.p0' => 'SUBESTRUCTURA',
    'ayuda.bussubestructura.p1' => 'Dibuje la estructura o subestructura que desee buscar en el <strong>EDITOR DE MOLECULAS</strong>.',
    'ayuda.bussubestructura.p2' => 'Para facilitar la generación de estructuras dispone de una paleta superior con agrupaciones ya definidas. Pulse una de ellas y después haga click dentro del editor.',
    'ayuda.bussubestructura.p3' => 'En la paleta de la izquierda dispone de la cuña para indicar la estereoquímica y los símbolos atómicos. La cuña inicialmente es siempre contínua; si desea indicar una cuña a rayas, dibuje inicialmente una cuña contínua y después haga click sobre ella. Alternativamente, la cuña irá cambiado de un tipo al otro.',
    'ayuda.bussubestructura.p4' => 'Los símbolos atómicos representados son los más frecuentes. La X es un comodín. Inicialmente representa un hidrógeno, pero si desea cambiarlo por cualquier otro símbolo, puede indicarlo en la caja de diálogo que muestra.',
    'ayuda.bussubestructura.p5' => 'Se puede limitar la búsqueda a una familia, tipo o grupo de productos naturales.',

    'ayuda.example' => 'EJEMPLO:',

    'ayuda.bussin.p1' => 'Permite realizar búsquedas de compuestos que posean carbonos con los desplazamientos químicos que se especifiquen. Es preciso definir la hibridación de cada uno de los átomos de carbono.',
    'ayuda.bussin.p2' => 'Por defecto la tolerancia en la búsqueda es 1 pero se puede establecer otra distinta para cada uno de los carbonos introducidos.',
    'ayuda.bussin.p3' => 'Para introducir desplazamientos adicionales, pulse el botón "nuevo desplazamiento" y aparecerá otra línea de campos vacía. Hasta que no se haya rellenada completamente la línea no se puede obtener una nueva. Esta operación se puede repetir tantas veces como desplazamientos químicos se desee introducir.',
    'ayuda.bussin.p4' => 'La búsqueda puede ser acotada si se conoce la familia, el tipo o el grupo a los cuales corresponde el compuesto. De esta manera se reduce el tiempo de búsqueda.',
    'ayuda.bussin.p5' => 'Esta búsqueda puede llevarse a cabo acotando un valor máximo y mínimo para cada uno de los carbonos deseados. Para ello, habrá de pulsar el botón búsqueda sin tolerancia.',
    'ayuda.bussin.p6' => 'Los compuestos encontrados en la búsqueda aparecen ordenados en el historial según un orden decreciente de similitud de los desplazamientos introducidos.',
    'ayuda.bussin.p7' => '<strong>Búsqueda con tolerancia:</strong>',
    'ayuda.bussin.p8' => '<strong>Tipo de Carbono:</strong> CH<br><strong>Desplazamiento:</strong> 100<br><strong>Tolerancia:</strong> 5',
    'ayuda.bussin.p9' => 'Se buscan compuestos que posean un CH en cualquier parte de la molécula cuyo desplazamiento químico esté comprendido entre 95 (desplazamiento - tolerancia) y 105 (desplazamiento + tolerancia).',
    'ayuda.bussin.p10' => '<strong>Búsqueda sin tolerancia:</strong>',
    'ayuda.bussin.p11' => '<strong>Tipo de Carbono:</strong> CH<br><strong>Desplazamiento:</strong> 95-105',
    'ayuda.bussin.p12' => 'Se buscan compuestos que posean un CH en cualquier parte de la molécula cuyo desplazamiento químico esté comprendido entre 95 y 105',

    'ayuda.buscon.p1' => 'Permite realizar búsquedas de compuestos que posean un carbono en una determinada posición de la molécula con el desplazamiento químico que se especifique; por ejemplo C-3 de Oleananes. Es preciso definir la hibridación de cada uno de los átomos de carbono.',
    'ayuda.buscon.p2' => 'Por defecto la tolerancia en la búsqueda es 1; pero se puede establecer otra distinta para cada uno de los carbonos introducidos.',
    'ayuda.buscon.p3' => 'Para introducir desplazamientos adicionales, pulse el botón "nuevo desplazamiento" y aparecerá otra línea de campos vacía. Hasta que no se haya rellenada completamente la línea no se puede obtener una nueva. Esta operación se puede repetir tantas veces como desplazamientos químicos se desee introducir.',
    'ayuda.buscon.p4' => 'La búsqueda puede ser acotada si se conoce la familia, el tipo o el grupo a los cuales corresponde el compuesto. De esta manera se reduce el tiempo de búsqueda.',
    'ayuda.buscon.p5' => 'Esta búsqueda puede llevarse a cabo acotando un valor máximo y mínimo para cada uno de los carbonos deseados. Para ello, habrá de pulsar el botón búsqueda sin tolerancia.',
    'ayuda.buscon.p6' => 'Los compuestos encontrados en la búsqueda aparecen ordenados en el historial según un orden decreciente de similitud de los desplazamientos introducidos.',
    'ayuda.buscon.p7' => '<strong>Búsqueda con tolerancia:</strong>',
    'ayuda.buscon.p8' => '<strong>Posición:</strong> 2<br><strong>Tipo de Carbono:</strong> CH<br><strong>Desplazamiento:</strong> 100<br><strong>Tolerancia:</strong> 5',
    'ayuda.buscon.p9' => 'Se buscan compuestos que posean un CH en la posición 2 cuyo desplazamiento químico esté comprendido entre 95 (desplazamiento - tolerancia) y 105 (desplazamiento + tolerancia).',
    'ayuda.buscon.p10' => '<strong>Búsqueda sin tolerancia:</strong>',
    'ayuda.buscon.p11' => '<strong>Posición:</strong> 2<br><strong>Tipo de Carbono:</strong> CH<br>Desplazamiento:</strong> 95-105',
    'ayuda.buscon.p12' => 'Se buscan compuestos que posean un CH en la posición 2 cuyo desplazamiento químico esté comprendido entre 95 y 105.',

    'ayuda.busiterativa.p0' => 'ITERATIVA',
    'ayuda.busiterativa.p1' => 'Permite llevar a cabo búsquedas por desplazamientos químicos indicando el tipo de carbono.',
    'ayuda.busiterativa.p2' => 'Por defecto la tolerancia en la búsqueda es 1; pero se puede establecer otra distinta para cada uno de los carbonos introducidos.',
    'ayuda.busiterativa.p3' => 'Para introducir desplazamientos adicionales, pulse el botón "nuevo desplazamiento" y aparecerá otra línea de campos vacía. No se puede obtener una nueva línea hasta que la anterior no haya sido rellenada completamente. Esta operación se puede repetir tantas veces como deseemos.',
    'ayuda.busiterativa.p4' => 'Adicionalmente podremos acotar la búsqueda si conocemos el tipo de compuesto problema, pudiendo especificar la familia, el tipo o el grupo.',
    'ayuda.busiterativa.p5' => 'Mediante esta búsqueda, se encontrarán aquellos compuestos que poseean un número máximo de desplazamientos similares a los buscados según la tolerancia que se especifique. Por ejemplo, se podrían introducir 20 desplazamientos químicos y obtener compuestos que presenten 12 desplazamientos comunes con los establecidos en la búsqueda.',
    'ayuda.busiterativa.p6' => 'Los compuestos encontrados en la búsqueda aparecen ordenados según la similitud de sus desplazamientos con los introducidos en la búsqueda.',
    'ayuda.busiterativa.p7' => '<strong>Tipo de Carbono:</strong> CH, <strong>Desplazamiento:</strong> 75, <strong>Tolerancia:</strong> 3<br/><strong>Tipo de Carbono:</strong> CH2, <strong>Desplazamiento:</strong> 101, <strong>Tolerancia:</strong> 4<br/><strong>Tipo de Carbono:</strong> CH3, <strong>Desplazamiento:</strong> 26, <strong>Tolerancia:</strong> 1',
    'ayuda.busiterativa.p8' => 'Se podrían encontrar compuestos que posean un CH a 72 ppm y un CH3 a 25 ppm y podrá carecer de un CH2 entre 97-105 ppm.',

    'ayuda.busvecindad.p1' => 'Sirve para llevar a cabo una búsqueda por desplazamientos químicos correspondientes a carbonos de la molécula que estén conectados. Resulta muy útil para llevar a cabo búsquedas con la información extraida del estudio de espectros bidimensionales (HMQC, HMBC)',
    'ayuda.busvecindad.p2' => 'Esta búsqueda ofrece un sistema de barras, de manera que el usuario debe de arrastrar el marcador de cada barra hasta el desplazamiento que se desee especificar. Se podrán seleccionar tantos desplazamientos como se desee.',
    'ayuda.busvecindad.p3' => 'El usuario debe de establecer el número de carbonos conectados por los que se desea realizar la búsqueda de sus desplazamientos químicos(1,2,3,4). En el caso de seleccionar la opción "Máximo" el sistema buscará el máximo número posible	de carbonos unidos. Además, puede considerar o no los heteroátomos existentes entre átomos de carbono pulsando la opción deseada.',
    'ayuda.busvecindad.p4' => '<strong>Desplazamientos:</strong> 125, 124, 55, 67, 120.<br/><strong>Número de coincidencias:</strong> Maximum<br/><strong>Tipo de búsqueda:</strong> No tener en cuenta heteroátomos.',
    'ayuda.busvecindad.p5' => 'Se buscarán compuestos con el máximo número de carbonos unidos que tengan como desplazamiento los valores 125, 124, 55, 67 o 120.',

    'ayuda.bustipcarb.p0' => 'TIPO DE CARBONO',
    'ayuda.bustipcarb.p1' => 'Permite al usuario buscar compuestos según el número que posean de distintos tipos de Carbono (C, CH, CH2, CH3). También se pueden establecer en la búsqueda el número de Carbonos unidos a Oxígenos y Nitrógenos, así como el número de heteroátomos.',
    'ayuda.bustipcarb.p2' => 'El usuario puede establecer un número concreto para cada tipo de átomo o establecer un intervalo. Dispone de un sistema de barras con dos marcadores para establecer el intervalo de forma rápida y sencilla.',
    'ayuda.bustipcarb.p3' => 'La búsqueda es completamente configurable. Basta con pulsar el botón "Configurar". Aparece una ventana en la que se pide la inserción del número de barras en las que se definirán el tipos de átomos por los que se desea realizar la búsqueda. Establecido este número, aparece otra ventana para establecer el tipo de carbono y los heteroátomos por los que se desea realizar la búsqueda. Esta opción se puede establecer sólamente para el esqueleto del compuesto o para toda la estructura del compuesto.<br><br>Los tipos de átomos que se pueden seleccionar son:',
    'ayuda.bustipcarb.p4' => '<strong>ESQUELETO:</strong> C*, CH*, CH2*, CH3*, C-O*, CH-O*, CH2-O* y CH3-O*',
    'ayuda.bustipcarb.p5' => '<strong>ESTRUCTURA TOTAL:</strong> C, CH, CH2, CH3, C-O, CH-O, CH2-O, CH3-O, Br, Cl, F, H, I, N, O, P and S',
    'ayuda.bustipcarb.p6' => '<strong>Tipo de átomo:</strong> C* <strong>Intervalo:</strong> 0-5<br/><strong>Tipo de átomo:</strong> CH* <strong>Intervalo:</strong> 4-4',

    'ayuda.historial.p0' => 'HISTORIAL',
    'ayuda.historial.p1' => 'Cuando se pulsa el botón "buscar" en cualquiera de las búsquedas, aparece una página con el historial de las búsquedas realizadas. Cada una de las búsquedas llevadas a cabo se define en una línea y aparecen ordenadas de forma correlativa. En cada una de ellas se especifica el número de búsqueda, el número de compuestos encontrados, el criterio que se ha utilizado en la búsqueda. Disponen de un cuadro para su eliminación y otro para su activación con el fin de realizar posteriores búsquedas booleanas con "OR" o "AND" entre las distitas búsquedas.
Las estructuras encontradas en cada una de las búsquedas se pueden visualizar pulsando el botón "ver". ',

    'ayuda.resultados.p0' => 'RESULTADOS',
    'ayuda.resultados.p1' => '

Al pulsar el botón "ver" en la pantalla del historial, se muestran las estructuras de los compuestos resultantes de la busqueda. Debajo de cada una de las estructuras aparecen dos enlaces para acceder a las propiedades del compuesto y para representar su ESPECTRO de forma gráfica ',
    'ayuda.resultados.p2' => 'En la parte superior de la ventana se encuentran los siguientes botones:',
    'ayuda.resultados.p3' => 'Ayuda: Accede a este sistema de ayuda',
    'ayuda.resultados.p4' => 'Herramienta Analítica: Accede a una herramienta analítica visual.',
    'ayuda.resultados.p5' => 'Refinar Búsqueda: Vuelve a la página de la búsqueda realizada.',
    'ayuda.resultados.p6' => '"δ(ppm)en tabla": Muestra una tabla con los datos de los desplazamientos químicos de los carbonos del compuesto seleccionado.',
    'ayuda.resultados.p7' => '"δ(ppm) en estructuras": Muestra los desplazamientos químicos sobre cada uno de los átomos de carbonos en la estructura.',

    'ayuda.editor.p0' => 'EDITOR DE MOLÉCULAS',
    'ayuda.editor.p1' => 'CONTROLES:',
    'ayuda.editor.p2' => ': Presenta el código Smiles de la estructura dibujada.',
    'ayuda.editor.p3' => 'CLR: Borra el contenido de la ventana de edición.',
    'ayuda.editor.p4' => 'NEW: Empieza otra cadena distinta a la que se estaba dibujando.',
    'ayuda.editor.p5' => 'DEL: Borra el elemento que seleccione a continuación.',
    'ayuda.editor.p6' => '123: Una vez pulsado, numerará los carbonos pulsando sobre ellos.',
    'ayuda.editor.p7' => 'D-R: Borra el grupo funcional que seleccione a continuación.',
    'ayuda.editor.p8' => 'QRY: Permite realizar búsquedas booleanas complejas:',
    'ayuda.editor.p9' => 'Especificar varios tipos de átomos en cualquier posición.',
    'ayuda.editor.p10' => 'Especificar el tipo de enlaces, si forman parte de un anillo.',
    'ayuda.editor.p11' => ' De esta manera se potencian considerablemente las búsquedas',
    'ayuda.editor.p12' => '+/-: Cambia las cargas atómicas de una forma razonable.',
    'ayuda.editor.p13' => 'UDO: Deshace el último paso.',
    'ayuda.editor.p14' => 'JME: Muestra el autor y la versión del applet.',
    'ayuda.editor.p15' => ' FORMAS:',
    'ayuda.editor.p16' => 'Estos botones permiten crear formas estandar ya definidas',
    'ayuda.editor.p17' => 'ENLACES:',
    'ayuda.editor.p18' => 'Estos controles permiten elegir los distintos tipos de enlaces que forman la subestructura',
    'ayuda.editor.p19' => 'ÁTOMOS:',
    'ayuda.editor.p20' => 'Estos botones representan los distintos átomos que se pueden elegir para crear la subestructura.',
    'ayuda.editor.p21' => 'Son los tipos de átomo más comunes en la química orgánica, pero si necesita alguno que no esté en la lista, y conoce su código smile puede crearlo presionando en el control marcado con una X. Solo tiene que introducir su código smile en el cuadro de diálogo que aparecerá a continuación',

];
