<script type="text/javascript">
            function pide(murl) {
                    var iden=$("#identification").val();
                    alert(murl+iden);

         $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            // En data puedes utilizar un objeto JSON, un array o un query string
            data: {"identification" : iden},
           
            //Cambiar a type: POST si necesario
            type: "post",
            // Formato de datos que se espera en la respuesta
            dataType: "json",
            // URL a la que se enviará la solicitud Ajax
            url: "http://127.0.0.1:8000/"+murl,
        })
         .done(function( data ) {
             if ( console && console.log ) {
                 arr=data["data"];
                 /*alert(arr.name);*/

                 alert(data);
                $.each(data, function(i, item) {console.log(item); });



                  $("#identification").text(data["identification"]);
                 /*alert( "La solicitud se ha completado correctamente." );*/
             }
         })
         .fail(function( jqXHR, textStatus, errorThrown ) {
             if ( console && console.log ) {   
                 alert( "La solicitud a fallado: " +  textStatus);
             }
        });
        }
</script>



<?php 
            use App\Patient;
            ?>
@extends('history.layout')

@section('eltema')

    <style type="text/css">
        .form-inline { font-family: arial, helvetica, sans-serif; 
                 margin-top: 10px;
                 margin-bottom: 0px;
                }

        .form-group { font-family: arial, helvetica, sans-serif; 
                 margin-right: 40px;
                 margin-left: 0px;
                }
    </style>

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Patient Data</h2>
            </div>
        </div>
    </div>

   @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (isset($patient))
           <?php $identification=$patient->identification; 
                    $patientActive=true;
           ?>
    @else         
           <?php                     
            $patient=new Patient;
            if (!isset($identification)) {$identification="";}
             $patientActive=false;
           
            ?>           
    @endif

    
    <?php 
    if(!isset($_SESSION)){
    session_start();
}
    if (!isset($_SESSION['identification'])) { $_SESSION['identification'] = '';} 
                        ?>

    <div class="row">
        
      

		<div class="col-xs-12 col-sm-12 col-md-12" id="dpatient">
    
            
            <!--{{url('pfind')}}-->
            <form  action="{{url('pfind')}}" method="post">
                @csrf
                <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />

                <div class="form-inline">
                    <div class="form-group">

                        <strong> Identification: </strong>
                        <input type="text" name="identification"  placeholder="Identification number" value='{{ $identification }}' maxlength="15" size="15"  pattern="|^[0-9   A-ZñÑáéíóúÁÉÍÓÚüÜ]*$|" id="identification" required>

                          <button type="submit" class="btn btn-primary">Find it</button>
                    </div>    
                </div>
            </form>
       

            <form  action="{{url('add')}}" method="post">
            @csrf
                <input type="hidden" name="identification"  placeholder="Identification number" value='{{ $identification }}'>
                <div class="form-inline">    
                            <div class="form-group">
                                <strong> Nationality: </strong>
                                <?php include(app_path().'/includes/paises.php') ?>
                                {{ paises() }}
                                <script type="text/javascript"> var nation="<?php  echo  $patient->nationality; ?>"; </script>
                            </div>
                </div>

                <div class="form-inline">
                            <div class="form-group">
                                <strong>Surname:</strong>
                                <input type="text" name="surname" class="form-inline" placeholder="Patien surame" value="{{ $patient->surname }}" required>
                            </div>
            		        <div class="form-group">
            		            <strong>Name:</strong>
            		            <input type="text" name="name" value="{{ $patient->name }}" class="form-inline" placeholder="Patien name" required>
            		        </div>
                            <div class="form-group">
                                <strong>Date of Birth:</strong>
                                <input type="date" name="DOB" value="{{ $patient->DOB }}" class="form-inline" placeholder="" required>
                            </div>
                </div>

                <?php $sexo=strval($patient->sex); ?>

                <div class="form-inline">
                            <div class="form-group">
                                
                                <div class="form-check form-check-inline">
                                    <strong>Sex:</strong>
                                  <input class="form-check-input" type="radio" name="sex" id="sex" value="M" <?php if ($sexo=="M") {echo "checked";}?> required>
                                  <label class="form-check-label" for="sex1">M</label>

                                  <input class="form-check-input" type="radio" name="sex" id="sex2" value="F" <?php if ($sexo=="F") { echo "checked"; } ?>  required>
                                  <label class="form-check-label" for="sex2">F</label>
                                </div>

                            </div>

                            <div class="form-group">
                                <strong>Marital Status:</strong>
                                <select name="maritalStts"id="marital" required>
                                    <option value="S" >Single</option>
                                    <option value="M" >Married</option>
                                    <option value="D" >Divorced</option>
                                    <option value="W" >Widowed</option>
                                </select>
                                 <script type="text/javascript"> var marital="<?php  echo  $patient->maritalStts; ?>"; </script>    
                            </div>
                </div>

                <div class="form-inline">
                            <div class="form-group">
                                <strong>Address:</strong>
                                <input type="text" name="addres" value="{{ $patient->addres }}" class="form-inline" placeholder="Address"  maxlength="85" size="85" required>
                            </div>
                </div>

                <div class="form-inline">
                            <div class="form-group">
                                <strong>Telephone:</strong>
                                 <input type="text" name="telephone" value="{{ $patient->telephone }}" placeholder="telephone number" id="inputNumero" onkeypress="return soloNumeros(event);" required>
                            </div>
                            <div class="form-group">
                                <strong>Email:</strong>
                                <input type="email" name="email" value="{{ $patient->email }}" class="form-inline" placeholder="email" required>
                            </div>

                </div>
                <br><br>
                <div class="form-inline" >
                            <div class="form-group">
                                <strong>Next of kin:</strong>
                                <input type="text" name="nxOfKin" value="{{ $patient->nxOfKin }}" class="form-inline" placeholder="Near relative" required>
                            </div>
                            <div class="form-group">
                                <strong>Relationship:</strong>
                                <select name="relation" id="myrelation" required>
                                    <option value="SP" >Spouse</option>
                                    <option value="PR" >Parents</option>
                                    <option value="SB" >Siblings</option>
                                    <option value="CH" >Children</option>
                                    <option value="GC" >Grandchildren</option>
                                    <option value="GP" >Grandparents</option>
                                    <option value="NN" >Nieces/Nephews</option>
                                    <option value="AU" >Aunts/Uncles</option>
                                    <option value="TC" >Great Grandchildren</option>
                                    <option value="TP" >Great Grandparents</option>
                                    <option value="GN" >Great Nieces/Nephews</option>
                                    <option value="CS" >Cousins</option>
                                    <option value="NG" >Neighbor</option>
                                </select>
                                <script type="text/javascript"> var srelation="<?php  echo  $patient->relation; ?>"; </script>
                            </div>
                </div>
                <div class="form-inline">
                            <div class="form-group">
                                <strong>Contact information:</strong>
                                <input type="text" name="contact" value="{{ $patient->contact }}" class="form-inline" placeholder="Contac Infotmation"  maxlength="70" size="70" required>
                            </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <br>
                </div>

            </form>
		    </div>
 
        
	</div> <!-- Fin del <div class="row ">  -->
          
    <script>
 
        /**
         * Función que solo permite la entrada de numeros, un signo negativo y
         * un punto para separar los decimales
         */
        function soloNumeros(e)

        {
            // capturamos la tecla pulsada

            var teclaPulsada=window.event ? window.event.keyCode:e.which;
            // capturamos el contenido del input
            var valor=document.getElementById("inputNumero").value;
     
            if(valor.length<20)
            {
                // 13 = tecla enter
                // Si el usuario pulsa la tecla enter o el punto y no hay ningun otro
                // punto
                if(teclaPulsada==13)
                {
                    return false;
                }
     
                // devolvemos true o false dependiendo de si es numerico o no
                return /\d/.test(String.fromCharCode(teclaPulsada));
            }else{
                return false;
            }
        }



        function iniSelect(elm, vlr){  document.getElementById(elm).value=vlr;}

        iniSelect("nation",nation);
        iniSelect("myrelation",srelation);
        iniSelect("marital",marital);


        if(document.forms[1].length > 0) {
                                        
                                        if(document.forms[0].elements.length > 0) {
                                                                                    document.forms[0].elements[1].focus();
                                                                                  }
                                        for (i = 3; i < document.forms[1].elements.length; i++) {
                                                                               
                                                                            /*document.forms[1].elements[i].disabled =true;*/ 
                                                                           
                                                                         };
                                       }

</script>
@endsection