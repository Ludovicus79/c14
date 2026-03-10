



@section('estilos')
    
    <link rel="stylesheet" href="{{ asset('css/d3.parcoords.css') }}">
    <link rel="stylesheet" href="{{ asset('js/lib/slickgrid/slick.grid.css') }}">
    <link rel="stylesheet" href="{{ asset('js/lib/slickgrid/jquery-ui-1.8.16.custom.css') }}">
    <link rel="stylesheet" href="{{ asset('js/lib/slickgrid/examples.css') }}">
    <link rel="stylesheet" href="{{ asset('js/lib/slickgrid/slick.pager.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footable.core.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footable.metro.css') }}">
    <link rel="stylesheet" href="{{ asset('css/herramienta.css') }}">
 
@endsection

@section('scripts')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script src="{{ asset('js/spin.js') }}"></script>
    <script src="{{ asset('js/loadingScreen.js') }}"></script>
    <script src="{{ asset('jsme/jsme.nocache.js') }}"></script>
    <script src="{{ asset('js/footable.js') }}"></script>
    <script src="{{ asset('js/footable.sort.js') }}"></script>
    <script src="{{ asset('js/lib/slickgrid/jquery-1.7.min.js') }}"></script>
    <script src="{{ asset('js/lib/slickgrid/jquery.event.drag-2.0.min.js') }}"></script>
    <script src="{{ asset('js/lib/slickgrid/slick.core.js') }}"></script>

    <script src="{{ asset('js/lib/slickgrid/slick.grid.js') }}"></script>
    <script src="{{ asset('js/lib/slickgrid/slick.dataview.js') }}"></script>
    <script src="{{ asset('js/lib/slickgrid/slick.pager.js') }}"></script>
    <script src="{{ asset('js/d3.min.js') }}"></script>
    <script src="{{ asset('js/d3.parcoords.js') }}"></script>
    <script src="{{ asset('js/lib/divgrid.js') }}"></script>
    
  



    

 

@endsection
<html>
<head>
    <meta name="viewport" content="width=device-width">
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="{{asset('images/logo.png')}}" />
    @yield('headers')

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nuevo.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navBarStyle.css') }}">
    @yield('estilos')

    <title>NAPROC 13 Base de datos de Carbono 13 de Productos Naturales</title>
    <script src="{{ asset('http://code.jquery.com/jquery-2.1.2.min.js') }}"></script>
    <script src="{{ asset('//code.jquery.com/ui/1.11.4/jquery-ui.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            var idioma = "{!! App::getLocale() !!}";

            if (idioma.indexOf("en") > -1) {
                $("#in").removeClass("inactive");
            } else if (idioma.indexOf("pt") > -1) {
                $("#po").removeClass("inactive");
            } else if (idioma.indexOf("de") > -1) {
                $("#al").removeClass("inactive");
            } else if (idioma.indexOf("fr") > -1) {
            	
                $("#fr").removeClass("inactive");
            } else if (idioma.indexOf("it") > -1) {
                $("#it").removeClass("inactive");
            } else {
                $("#es").removeClass("inactive");
            }

            var docHeight = $(window).height();
            var footerHeight = $('footer').height();
            var footerTop = $('footer').position().top + footerHeight;
            if (footerTop < docHeight) {
                $('footer').css('margin-top', 10 + (docHeight - footerTop) + 'px');
            }
        });


    </script>
    @yield('scripts')
</head>
<body>
<header class="container-fluid">
    <div class="row" id="barraSup">
        <div class="col-md-3 col-xs-12 text-center">
            <ul class="list-inline">
                <li>
                    <a href="{!! route('lang.switch', 'es') !!}">
                        <img id="es" class="logo inactive" src="{!! asset('images/esp.png') !!}" alt="">
                    </a>
                </li>
                <li>
                    <a href="{!! route('lang.switch', 'en') !!}">
                        <img id="in" class="logo inactive" src="{!! asset('images/eng.png') !!}" alt="">
                    </a>
                </li>
                <li>
                    <a href="{!! route('lang.switch', 'fr') !!}">
                        <img id="fr" class="logo inactive" src="{!! asset('images/fr.png') !!}" alt="">
                    </a>
                </li>
                <li>
                    <a href="{!! route('lang.switch', 'de') !!}">
                        <img id="al" class="logo inactive" src="{!! asset('images/ger.png') !!}" alt="">
                    </a>
                </li>
                <li>
                    <a href="{!! route('lang.switch', 'it') !!}">
                        <img id="it" class="logo inactive" src="{!! asset('images/ita.png') !!}" alt="">
                    </a>
                </li>
                <li>
                    <a href="{!! route('lang.switch', 'pt') !!}">
                        <img id="po" class="logo inactive" src="{!! asset('images/pt.png') !!}" alt="">
                    </a>
                </li>
            </ul>
        </div>
        <div class="col-md-offset-4 col-md-5 col-xs-12 text-center">
            <ul class="list-inline">
                @guest
                    <li><img class="logo" src="{!! asset('images/login.png') !!}" alt="login"></li>
                    <li><a href="{{ url('login') }}">{!! trans('applicationResource.menu.sesion') !!}</a></li>
                    <li><a href="{{ url('register') }}">{!! trans('applicationResource.menu.signUp') !!}</a></li>
                @else
                    <li class="col-md-5" style="color:white; font-weight: bold">{!!trans('applicationResource.user.user')!!} {!! Auth::user()->name !!}</li>
                    <li><a href="{{ url('logout') }}">{!! trans('applicationResource.menu.logout') !!}</a></li>
                    @if(Auth::user()->allowed)
                        <li><a href="{{ url('admin') }}">{!! trans('applicationResource.menu.admin') !!}</a></li>
                    @endif
                @endguest
            </ul>
        </div>
    </div>
    <div class="row">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="/"><img class="img-responsive" src="{!! asset('images/naproclogo.png') !!}"
                                     alt="Naproc 13"></a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown"
                               href="">{!! trans('applicationResource.menu.busqueda') !!} <span
                                        class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ url('search/byName') }}">{!! trans('applicationResource.submenu.nombre') !!}</a></li>
                                <li><a href="{{ url('search/bySubstructure') }}">{!! trans('applicationResource.submenu.subestructura') !!}</a></li>
                                <li><a href="{{ url('search/byShiftNoPosition') }}">{!! trans('applicationResource.submenu.desplazamiento') !!}</a></li>
                                <li><a href="{{ url('search/byCarbonType') }}">{!! trans('applicationResource.submenu.tipocarbono') !!}</a></li>
                            </ul>
                        </li>
                        <li class="liCabecera"><a href="{{ url('history') }}">{!! trans('applicationResource.menu.historial') !!}</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</header>

<div class="wrapper">
<section class="container main-container">
 <div class="row"> 

 	<div class="col-md-7">
    <div id="container" ></div>
    
            <!--<input type="button" value="AYUDA"></input>  
            <input id="eje" type="button" value="Añadir Eje" onclick="nuevaVentana()"></input> 
            <input id="eje" type="button" value="Eliminar Eje" onclick="nuevaVentana()"></input--> 

        <!-- PARA LA REPRESENTACION GRAFICA PARALELA -->
       
    
  </div>
    

        <!--CAPA PARA LA REPRESENTACION GRAFICA NORMAL -->
        
        

       <!-- <div id="configuracion" class="row">
	        	<div class="col-md-12">
		        	<table >
		            <tr>
		              <th>bor</th> <th>bor</th> <th>bor</th> <th>bor</th>
		            </tr>
		          </table> 
	          </div>
        </div>

        <div id="botones">
            <input type="button" value="AYUDA"></input>  
            <input id="eje" type="button" value="Añadir Eje" onclick="nuevaVentana()"></input> 
        </div>-->


	<div class="col-md-5">
		<div class="row">
			<div class="col-md-12">
				<div id="cuerpo" class="cuerpo">
					
				</div>
			</div>
			<div class="col-md-8">
				<div id="tablas" class="tablas">
					
				</div>
			</div>
			<div class="col-md-4">
        <div id="grid1">
          <div id="grid" class="grid" >
        </div>
				
					
				</div>
			</div> 
		</div>
		
	</div>
      
       
     
        
        
    </div>   
<div id="example" class="parcoords col-md-12 tablasBarras" ></div>
  	<script type="text/javascript">
      //////////////////----------------------------------------------------------------------------
    ///-------------------------------------------------------------------------------------------
    ///                       SCRIPT PARA LA GRAFICA DE DESPALZAMIENTOS
    /// ------------------------------------------------------------------------------------------

      //para guardar el resultado de las busquedas de la base de datos
      auxJ2= "<?php 
            $elementos="";

             
              for( $k = 0; $k < sizeof($carbons); $k++) {

                for( $m=0; $m < sizeof($carbons[$k]); $m++){
                  if($m==(sizeof($carbons[$k])-1)){
                    $elementos.=$desp[$k][$m]->carbonType.',';
                      $elementos.=$desp[$k][$m]->shift.',';
                      $elementos.=$desp[$k][$m]->jmeDisplacement.',';
                      $elementos.=$desp[$k][$m]->name.',';
                      $elementos.=$desp[$k][$m]->family.',';
                      $elementos.=$desp[$k][$m]->subFamily.',';
                      $elementos.=$desp[$k][$m]->subSubFamily.',';
                      $elementos.=$desp[$k][$m]->solvent.',';
                      $elementos.=$desp[$k][$m]->molecularFormula;
                    }else{
                      $elementos.=$desp[$k][$m]->carbonType.',';
                      $elementos.=$desp[$k][$m]->shift.',';
                      $elementos.=$desp[$k][$m]->jmeDisplacement.',';
                      $elementos.=$desp[$k][$m]->name.',';
                      $elementos.=$desp[$k][$m]->family.',';
                      $elementos.=$desp[$k][$m]->subFamily.',';
                      $elementos.=$desp[$k][$m]->subSubFamily.',';
                      $elementos.=$desp[$k][$m]->solvent.',';
                      $elementos.=$desp[$k][$m]->molecularFormula.',';
                    }
                }
                $elementos.='*';
                    
              } 
            echo $elementos;        
            ?>"
            
            desplazamientosJ2= "<?php 
            $elementos3="";

             
              for( $k = 0; $k < sizeof($desplazamientos); $k++) {

                for( $m=0; $m < sizeof($desplazamientos[$k]); $m++){
                  if($m==(sizeof($desplazamientos[$k])-1)){
                    $elementos3.=$desplazamientos[$k][$m]->carbonType.',';
                      $elementos3.=$desp[$k][$m]->shift.',';
                    }else{
                      $elementos3.=$desp[$k][$m]->carbonType.',';
                      $elementos3.=$desp[$k][$m]->shift.',';
                  
                    }
                }
                $elementos3.='*';
                    
              } 
            echo $elementos3;        
            ?>"
            
      carbonsJ2= "<?php 
            $elementos2="";

      
              for( $i = 0; $i < sizeof($carbons); $i++) {

                for( $j=0; $j < sizeof($carbons[$i]); $j++){

                  if($j==(sizeof($carbons[$i])-1)){
                    $elementos2.=$carbons[$i][$j]->Cs.',';
                      $elementos2.=$carbons[$i][$j]->CHs.',';
                      $elementos2.=$carbons[$i][$j]->CH2s.',';
                      $elementos2.=$carbons[$i][$j]->CH3s.',';
                      $elementos2.=$carbons[$i][$j]->COs.',';
                      $elementos2.=$carbons[$i][$j]->CHOs.',';
                      $elementos2.=$carbons[$i][$j]->CH2Os.',';
                      $elementos2.=$carbons[$i][$j]->CH3Os.',';
                      $elementos2.=$carbons[$i][$j]->CNs.',';
                      $elementos2.=$carbons[$i][$j]->CHNs.',';
                      $elementos2.=$carbons[$i][$j]->CH2Ns.',';
                      $elementos2.=$carbons[$i][$j]->CH3Ns.',';
                      $elementos2.=$carbons[$i][$j]->C.',';
                      $elementos2.=$carbons[$i][$j]->CH.',';
                      $elementos2.=$carbons[$i][$j]->CH2.',';
                      $elementos2.=$carbons[$i][$j]->CH3.',';
                      $elementos2.=$carbons[$i][$j]->CO.',';
                      $elementos2.=$carbons[$i][$j]->CHO.',';
                      $elementos2.=$carbons[$i][$j]->CH2O.',';
                      $elementos2.=$carbons[$i][$j]->CH3O.',';
                      $elementos2.=$carbons[$i][$j]->CN.',';
                      $elementos2.=$carbons[$i][$j]->CHN.',';
                      $elementos2.=$carbons[$i][$j]->CH2N.',';
                      $elementos2.=$carbons[$i][$j]->CH3N.',';
                      $elementos2.=$carbons[$i][$j]->O.',';
                      $elementos2.=$carbons[$i][$j]->N.',';
                      $elementos2.=$carbons[$i][$j]->H.',';
                      $elementos2.=$carbons[$i][$j]->F.',';
                      $elementos2.=$carbons[$i][$j]->Cl.',';
                      $elementos2.=$carbons[$i][$j]->Br.',';
                      $elementos2.=$carbons[$i][$j]->I.',';
                      $elementos2.=$carbons[$i][$j]->P.',';
                      $elementos2.=$carbons[$i][$j]->S;
                  }else{
                    $elementos2.=$carbons[$i][$j]->Cs.',';
                      $elementos2.=$carbons[$i][$j]->CHs.',';
                      $elementos2.=$carbons[$i][$j]->CH2s.',';
                      $elementos2.=$carbons[$i][$j]->CH3s.',';
                      $elementos2.=$carbons[$i][$j]->COs.',';
                      $elementos2.=$carbons[$i][$j]->CHOs.',';
                      $elementos2.=$carbons[$i][$j]->CH2Os.',';
                      $elementos2.=$carbons[$i][$j]->CH3Os.',';
                      $elementos2.=$carbons[$i][$j]->CNs.',';
                      $elementos2.=$carbons[$i][$j]->CHNs.',';
                      $elementos2.=$carbons[$i][$j]->CH2Ns.',';
                      $elementos2.=$carbons[$i][$j]->CH3Ns.',';
                      $elementos2.=$carbons[$i][$j]->C.',';
                      $elementos2.=$carbons[$i][$j]->CH.',';
                      $elementos2.=$carbons[$i][$j]->CH2.',';
                      $elementos2.=$carbons[$i][$j]->CH3.',';
                      $elementos2.=$carbons[$i][$j]->CO.',';
                      $elementos2.=$carbons[$i][$j]->CHO.',';
                      $elementos2.=$carbons[$i][$j]->CH2O.',';
                      $elementos2.=$carbons[$i][$j]->CH3O.',';
                      $elementos2.=$carbons[$i][$j]->CN.',';
                      $elementos2.=$carbons[$i][$j]->CHN.',';
                      $elementos2.=$carbons[$i][$j]->CH2N.',';
                      $elementos2.=$carbons[$i][$j]->CH3N.',';
                      $elementos2.=$carbons[$i][$j]->O.',';
                      $elementos2.=$carbons[$i][$j]->N.',';
                      $elementos2.=$carbons[$i][$j]->H.',';
                      $elementos2.=$carbons[$i][$j]->F.',';
                      $elementos2.=$carbons[$i][$j]->Cl.',';
                      $elementos2.=$carbons[$i][$j]->Br.',';
                      $elementos2.=$carbons[$i][$j]->I.',';
                      $elementos2.=$carbons[$i][$j]->P.',';
                      $elementos2.=$carbons[$i][$j]->S.',';
                  }
                
                      
    
                    }
                    $elementos2.='*';
              } 
            echo $elementos2;        
            ?>"
          nElementos= "<?php 
            $elem=sizeof($carbons);  
            echo $elem;
          ?>"
          nDesplazamientos= "<?php 
            $elem=sizeof($carbons);  
            echo $elem;
          ?>"
             
          //arrays de objetos para representar en las graficas, coge como datos el resultado de las consultas y los separa mediante splits
      graficas=new Array();
      graficas2=new Array();
      graficas3=new Array();
      aux= new Array(); 
      aux2=new Array()
      k=0

      graficas=desplazamientosJ2.split('*');

      for (var j = 0; j < nDesplazamientos-1; j++) {

        graficas2[j]=graficas[j].split(',');
      };
        
      for (var k = 0; k < graficas2.length-1; k++) {

        graficas3[k]=graficas[k].split(',');
      };
        
      for (var i = 0; i < graficas3.length; i++) {
        for (var j = 0; j < graficas3[i].length-1; j++) {
          aux[i]={[graficas3[i][j]]:graficas3[i][j+1]}
          j++
        };
      };
        
      console.log(aux);
      graficas3=aux;
      console.log(graficas3);


     chart = Highcharts.chart('container', {
          chart: {
              type: 'column'
          },
          title: {
              text: 'HERRAMIENTA ANALITICA'
          },
          subtitle: {
              text: '----------------'
          },
          xAxis: {
              min:0,
              tickInterval: 10,
              max:240,
              allowDecimals: true
          },
          yAxis: {
              labels: {
                  enabled:false
              },
              title: {
                  text:null
              }

          },
          tooltip: {
              headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
              pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                  '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
              footerFormat: '</table>',
              shared: true,
              useHTML: true
          },

          


          series: [
              {
                name: "CH",
                id:"CH",
                data: [
                  [0,0],[0,0],[0,0],[0,0],[0,0],[0,0],[0,0],[0,0],[0,0],[0,0],
                ],
                dataLabels: {
                  format: '{point.y}'
                },
                color: "#F70505"
              },{
                name: "C",
                id:"C",
                data: [
                  [0,0],[0,0],[0,0],[0,0],[0,0],[0,0],[0,0],[0,0],[0,0],[0,0],
                ],
                dataLabels: {
                  format: '{point.y}'
                },
                color: '#FF00FF',
              },{
                name: "CH2",
                id:"CH2",
                data: [
                  [0,0],[0,0],[0,0],[0,0],[0,0],[0,0],[0,0],[0,0],[0,0],[0,0],
                ],
                dataLabels: {
                  format: '{point.y}'
                },
                color: '#0511F7',
              }
              ,{
                name: "CH3",
                id:"CH3",
                data: [
                  [0,0],[0,0],[0,0],[0,0],[0,0],[0,0],[0,0],[0,0],[0,0],[0,0],
                ],
                dataLabels: {
                  format: '{point.y}'
                },
                color: '#6AF705',
              }
          ]

          
      });




    function  nuevaVentana()//abre un popup al pulsar el boton duplicar
   {
    
       ventana = window.open("atomos.html", "ventana", "width=300,height=450,top=320,left=500,scrollbars=yes,resizable=no,location=no,menubar=no,estatus=no,toolbar=no");
       

   }
  		
    </script>

    <script id="brushing">
    //////////////////----------------------------------------------------------------------------
    ///-------------------------------------------------------------------------------------------
    ///                       SCRIPT PARA LAS COORDENADAS PARALELAS
    /// ------------------------------------------------------------------------------------------

    data= new Array();
    data2=new Array();
    dataSecundario=new Array();
    dataSecundario2=new Array();


      data=carbonsJ2.split('*');

      for (var j = 0; j < data.length-1; j++) {

        data2[j]=data[j].split(',');

      };


      dataSecundario=auxJ2.split('*');

      for (var i = 0; i < data.length-1; i++) {
        dataSecundario2[i]=dataSecundario[i].split(',');
      };

    for (var i = 0; i < data.length-1; i++) {
     data2[i]={Cs:data2[i][0],CHs:data2[i][1],CH2s:data2[i][2],CH3s:data2[i][3],COs:data2[i][4],CH0s:data2[i][5],CH2Os:data2[i][6],CH3Os:data2[i][7],CNs:data2[i][8],CHNs:data2[i][9],CH2Ns:data2[i][10],CsH3N:data2[i][11],C:data2[i][12],CH:data2[i][13],CH2:data2[i][14],CH3:data2[i][15],CO:data2[i][16],CHO:data2[i][17],CH2O:data2[i][18],CH3O:data2[i][19],CN:data2[i][20],CHN:data2[i][21],CH2N:data2[i][22],CH3N:data2[i][23],O:data2[i][24],N:data2[i][25],H:data2[i][26],F:data2[i][27],Cl:data2[i][28],Br:data2[i][29],I:data2[i][30],P:data2[i][31],S:data2[i][32]};
    };
    

    colores= new Array();



      function crearAleatorio(maximo,minimo){
        return Math.floor(parseInt(Math.random()*(maximo-minimo)+minimo));
      }
      function cambiarColor(){
        var color=crearAleatorio(16777216,0);
        color=color.toString(16);
        return "#"+color;
      }
  
      

      var parcoords = d3.parcoords()("#example")
          .alpha(0.4)
          .mode("queue") // progressive rendering
          .height(d3.max([document.body.clientHeight-450, 250]))
          
          .margin({
            top: 36,
            left: 0,
            right: 0,
            bottom: 16
          });

      // load csv file and create the chart
      d3.csv('', function(data) {

        // slickgrid needs each data element to have an id
        var data = data2;

        for (var i = 0; i < data.length; i++) {
            dataSecundario2[i]={id:i, carbonType:dataSecundario2[i][0], desplazamiento:dataSecundario2[i][1], jme:dataSecundario2[i][2] , nombre:dataSecundario2[i][3], familia:dataSecundario2[i][4], tipo:dataSecundario2[i][5], grupo:dataSecundario2[i][6], disolvente:dataSecundario2[i][7], formula:dataSecundario2[i][8]};
            console.log(dataSecundario2[i])
        };


        data.forEach(function(d,i) { 
          d.id = d.id || i; 
        });

             
        parcoords

          .data(data)
          
          .hideAxis(["name"])
          
          .color(function(d) {
            //console.log(colores);
            //console.log(data);
          
            var c=cambiarColor();
            colores.push(c);
            //d.col=c;
            //console.log(colores[0])
            return cambiarColor();
          })
          
          .render()
          .reorderable()
          .brushMode("1D-axes");
          
          
        // setting up grid
        var column_keys = d3.keys(data[0]);
        var columns = column_keys.map(function(key,i) {
          return {
            id: key,
            name: key,
            field: key,
            sortable: true
          }
        });

        var options = {
          enableCellNavigation: true,
          enableColumnReorder: false,
          multiColumnSort: false
        };

        var dataView = new Slick.Data.DataView();
        var grid = new Slick.Grid("#grid", dataView, columns, options);
        var pager = new Slick.Controls.Pager(dataView, grid, $("#pager"));


        // wire up model events to drive the grid
        dataView.onRowCountChanged.subscribe(function (e, args) {
          grid.updateRowCount();

          grid.render();
        });


        dataView.onRowsChanged.subscribe(function (e, args) {
          grid.invalidateRows(args.rows);
          grid.render();
        });

        // column sorting
        var sortcol = column_keys[0];
        var sortdir = 1;

        function comparer(a, b) {
          var x = a[sortcol], y = b[sortcol];
          return (x == y ? 0 : (x > y ? 1 : -1));
        }
        
        // click header to sort grid column
        grid.onSort.subscribe(function (e, args) {
          sortdir = args.sortAsc ? 1 : -1;
          sortcol = args.sortCol.field;

          if ($.browser.msie && $.browser.version <= 8) {
            dataView.fastSort(sortcol, args.sortAsc);
          } else {
            dataView.sort(comparer, args.sortAsc);
          }
        });

        // highlight row in chart
        grid.onMouseEnter.subscribe(function(e,args) {
          // Get row number from grid
          var grid_row = grid.getCellFromEvent(e).row;

          // Get the id of the item referenced in grid_row
          var item_id = grid.getDataItem(grid_row).id;

          var d = parcoords.brushed() || data;

          // Get the element position of the id in the data object
          elementPos = d.map(function(x) {return x.id; }).indexOf(item_id);

          // Highlight that element in the parallel coordinates graph
          parcoords.highlight([d[elementPos]]);
        });

        grid.onMouseLeave.subscribe(function(e,args) {
          parcoords.unhighlight();
        });

        // fill grid with data
        gridUpdate(data);

        // update grid on brush
        parcoords.on("brush", function(d) {
          gridUpdate(d);
        });

        function gridUpdate(data) {
          dataView.beginUpdate();
          dataView.setItems(data);
          dataView.endUpdate();
        };

      });
    </script>

</section>
</div>
</body>
</html>

