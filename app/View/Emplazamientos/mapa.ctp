<?php
$this->Js->get("select");
$this->Js->event('change', '$("#EmplazamientoMapaForm").submit()');
$this->Js->get("input[type=radio]");
$this->Js->event('change', '$("#EmplazamientoMapaForm").submit()');
$nemp = count($emplazamientos);
?>
<h1><?php echo __('Emplazamientos de Telecomunicaciones de la Comunitat'); ?></h1>
<?php
echo $this->Form->create('Emplazamiento', array(
    'inputDefaults' => array('label' => false,'div' => false),
    'class' => 'form-horizontal'
));
?>
<fieldset>
    <legend>
        <?php
        echo __('Criterios de Selección') . ' &mdash; ';
        echo $this->Html->Link(
            '<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>',
            array('controller' => 'emplazamientos', 'action' => 'mapa'),
            array('title' => __('Limpiar Criterios'), 'escape' => false)
        );
        ?>
    </legend>
    <div class="form-group">
        <?php
        $opciones = array ('SI' => 'Sí', 'NO' => 'No');        
        echo $this->Form->label('Emplazamiento.comdes', __('COMDES'), array('class' => 'col-sm-1 control-label'));
        echo $this->Form->input('Emplazamiento.comdes', array('options' => $opciones, 'empty' => __('Seleccionar'), 'div' => 'col-sm-2', 'class' => 'form-control'));
        echo $this->Form->label('Emplazamiento.tdt-gva', __('TDT GVA'), array('class' => 'col-sm-1 control-label'));
        echo $this->Form->input('Emplazamiento.tdt-gva', array('options' => $opciones, 'empty' => __('Seleccionar'), 'div' => 'col-sm-2', 'class' => 'form-control'));
        echo $this->Form->label('Emplazamiento.rtvv', __('TDT RTVV'), array('class' => 'col-sm-1 control-label'));
        echo $this->Form->input('Emplazamiento.rtvv', array('options' => $opciones, 'empty' => __('Seleccionar'), 'div' => 'col-sm-2', 'class' => 'form-control'));
        echo $this->Form->label('Emplazamiento.titular', __('Titular'), array('class' => 'col-sm-1 control-label'));
        echo $this->Form->input('Emplazamiento.titular', array('options' => $titulares, 'empty' => __('Seleccionar'), 'div' => 'col-sm-2', 'class' => 'form-control'));
        ?>
    </div>
</fieldset>
<fieldset>
    <legend>
        <?php
        echo __('Resultados de Búsqueda');
        if ($nemp > 0){
            echo ' &mdash; ' . $nemp . ' ' . __('Emplazamientos');
        }
        ?>
    </legend>
</fieldset>
<div id="map">
	
</div>
<?php
echo $this->Form->end();
?>
<script type="text/javascript">
    // Creamos el mapa
    var mapa = L.map('map',{
        maxBounds: [[37.7, -1.7], [40.9, 0.65]],
    });
    mapa.setView([39.47, -0.38], 10);

    var wms2 = L.tileLayer.wms('http://www.ign.es/wms-inspire/pnoa-ma', {
        layers: 'OI.OrthoimageCoverage',
        format: 'image/jpeg',
        transparent: true,
        attribution: '(c) Instituto Geográfico Nacional',
    });
    wms2.addTo(mapa);

    var wms1 = L.tileLayer.wms('http://www.ign.es/wms-inspire/ign-base', {
        layers: 'IGNBaseTodo',
        format: 'image/jpeg',
        transparent: true,
        attribution: '(c) Instituto Geográfico Nacional',
    });
    wms1.addTo(mapa);

    var baseMaps = {
        "Ortofoto IGN": wms2,
        "Mapa Cartográfico Base": wms1
    };
    L.control.layers(baseMaps).addTo(mapa);
    L.control.scale().addTo(mapa);

    // Tipo de marcadores
    var Iconos = L.Icon.extend({
        options: {
            iconSize:     [25, 40], // Tamaño del Icono
            iconAnchor:   [12, 40], // Punto de anclaje del icono
            tooltipAnchor:  [5, -10],
            popupAnchor:  [5, -10]
        }
    });
    // Creamos los iconos
    var iconoAzul = new Iconos({iconUrl: '../img/marca-azul.png'});
    var iconoVerde = new Iconos({iconUrl: '../img/marca-verde.png'});
    var iconoRojo = new Iconos({iconUrl: '../img/marca-rojo.png'});
    var iconoNaranja = new Iconos({iconUrl: '../img/marca-naran.png'});
    var iconoAmarillo = new Iconos({iconUrl: '../img/marca-amar.png'});
    var iconoCian = new Iconos({iconUrl: '../img/marca-cian.png'});
    var iconoLila = new Iconos({iconUrl: '../img/marca-lila.png'});
    var iconoLima = new Iconos({iconUrl: '../img/marca-lima.png'});
    var iconoRosa = new Iconos({iconUrl: '../img/marca-rosa.png'});
    var iconoGris = new Iconos({iconUrl: '../img/marca-gris.png'});
    var iconoMar = new Iconos({iconUrl: '../img/marca-mar.png'});
    var iconoMarron = new Iconos({iconUrl: '../img/marca-marron.png'});
    var iconoGrana = new Iconos({iconUrl: '../img/marca-grana.png'});
    <?php
    foreach ($emplazamientos as $emplazamiento) {
        $comdes = substr($emplazamiento['Emplazamiento']['comdes'], 0, 1);
        $tdt = substr($emplazamiento['Emplazamiento']['tdt-gva'], 0, 1);
        $rtvv = substr($emplazamiento['Emplazamiento']['rtvv'], 0, 1);
        $servicios = $comdes . $rtvv . $tdt;
        if ((empty($this->request->data['leyenda'])) || ($this->request->data['leyenda'] == 'SERV')) {
            $titleyenda =  __("Emplazamientos por servicio");
            switch ($servicios) {
                case 'SNN':
                    $icono = 'iconoAzul';
                    break;

                case 'NSN':
                    $icono = 'iconoRojo';
                    break;

                case 'NNS':
                    $icono = 'iconoVerde';
                    break;

                case 'SSN':
                    $icono = 'iconoNaranja';
                    break;

                case 'SNS':
                    $icono = 'iconoAmarillo';
                    break;

                case 'NSS':
                    $icono = 'iconoLila';
                    break;

                case 'SSS':
                    $icono = 'iconoLima';
                    break;

                default:
                    $icono = 'iconoCian';
                    break;
            }
        ?>
            colores = ['#002255', '#AA0000', '#008000', '#D45500', '#D4AA00', '#7137C8', '#00D400'],
            etiquetas = [
                'COMDES', 'RTVV', 'TDT-GVA', 'COMDES + RTVV', 'COMDES + TDT-GVA',
                 'TDT-GVA + RTVV', 'COMDES, TDT-GVA + RTVV'
            ];

        <?php
        }
        else{
            $titleyenda =  __("Emplazamientos por titular");
            $titular = substr($emplazamiento['Entidad']['nombre'], 0, 4);
            switch ($titular) {
                case 'Gene':
                    $icono = 'iconoAzul';
                    break;

                case 'Corp':
                    $icono = 'iconoRojo';
                    break;

                case 'Dipu':
                    $dipu = substr($emplazamiento['Entidad']['nombre'], -4);
                    if ($dipu == 'ante'){
                        $icono = 'iconoVerde';
                    }
                    else{
                        $icono = 'iconoNaranja';
                    }
                    break;

                case 'Ayun':
                    $icono = 'iconoAmarillo';
                    break;

                case 'Ferr':
                    $icono = 'iconoLila';
                    break;

                case 'Cell':
                    $icono = 'iconoLima';
                    break;


                case 'Voda':
                    $icono = 'iconoGris';
                    break;

                case 'Tele':
                    $icono = 'iconoRosa';
                    break;

                case 'Oran':
                    $icono = 'iconoMar';
                    break;

                case 'Iber':
                    $icono = 'iconoMarron';
                    break;

                case 'Priv':
                    $icono = 'iconoGrana';
                    break;

                default:
                    $icono = 'iconoCian';
                    break;
            }
        ?>
            colores = [
                '#002255', '#AA0000', '#008000', '#D45500', '#D4AA00', '#7137C8', 
                '#00D400', '#535D6F', '#FF2AD4', '#006680', '#504416', '#501616'
            ],
            etiquetas = [
                'GENERALITAT', 'CVMC', '<?php echo __("Dip. Alicante");?>', '<?php echo __("Dip. Castellón");?>', 
                '<?php echo __("GVA-Ayuntamiento");?>', 'FGV', 'Cellnex', 'Vodafone', 'Telefónica', 
                'Orange', 'Iberdrola', 'Privado/Otros'
            ];
        <?php
        }
        ?>
        var marcador = L.marker(
            [<?php echo $emplazamiento['Emplazamiento']['latitud']; ?>,
            <?php echo $emplazamiento['Emplazamiento']['longitud']; ?>],
            {icon: <?php echo $icono; ?>}
        ).addTo(mapa);
        var texto = "<b><?php echo $emplazamiento['Emplazamiento']['centro']; ?></b>";
        marcador.bindTooltip(texto);
        var textpopup = "<h4>";
        textpopup += "<?php echo $emplazamiento['Emplazamiento']['centro']; ?>";
        textpopup += "</h4>";
        textpopup += "<ul>";
        textpopup += "<li>Ubicación</li>";
        textpopup += "<ul>";
        textpopup += "<li>Latitud: <b><?php echo $emplazamiento['Emplazamiento']['latitud']; ?></b></li>";
        textpopup += "<li>Longitud: <b><?php echo $emplazamiento['Emplazamiento']['longitud']; ?></b></li>";
        textpopup += "<li>Municipio: <b><?php echo $emplazamiento['Municipio']['nombre']; ?> (<?php echo $emplazamiento['Municipio']['provincia']; ?>)</b></li>";
        textpopup += "</ul>";
        textpopup += "</ul>";
        textpopup += "<ul>";
        textpopup += "<li>Titular &mdash; <b><?php echo $emplazamiento['Entidad']['nombre']; ?></b></li>";
        textpopup += "</ul>";        
        textpopup += "<ul>";
        textpopup += "<li>Servicios</li>";
        textpopup += "<ul>";
        <?php 
        if ($comdes == "S"){
        ?>
        	textpopup += "<li><b>COMDES</b></li>";
        <?php 
        }
        ?>
        <?php 
        if ($tdt == "S"){
        ?>
        	textpopup += "<li><b>TDT-GVA</b></li>";
        <?php 
        }
        ?>
        <?php 
        if ($rtvv == "S"){
        ?>
        	textpopup += "<li><b>RTVV</b></li>";
        <?php 
        }
        ?>
        textpopup += "</ul>";
        textpopup += "<div class='text-center'>";
        textpopup += "<a href='detalle/<?php echo $emplazamiento['Emplazamiento']['id']; ?>' class='btn btn-default btn-sm' role='button'>";
        textpopup += "<span class='glyphicon glyphicon-search' aria-hidden='true'></span> Ir a detalle";
        textpopup += "</a>";
        textpopup += "</div>";
        marcador.bindPopup(textpopup);
    <?php
    }
    ?>

    // Agregamos la leyenda:
    var leyenda = L.control({position: 'bottomright'});
    leyenda.onAdd = function (mapa) {
        var div = L.DomUtil.create('div', 'info legend');
        div.innerHTML = '<h4><?php echo __('Mostrar Leyenda');?></h4>';
        div.innerHTML += '<input type="radio" name="leyenda" id="servicio" value="SERV" <?php if ((empty($this->request->data['leyenda'])) || ($this->request->data['leyenda'] == "SERV")) {?> checked="checked" <?php } ?>> <?php echo __('Por Servicio');?> &nbsp;';
        div.innerHTML += '<input type="radio" name="leyenda" id="titular" value="TIT" <?php if ((!empty($this->request->data['leyenda'])) && ($this->request->data['leyenda'] == "TIT")) {?> checked="checked" <?php } ?>> <?php echo __('Por Titular');?>';
        div.innerHTML += '<h4><?php echo $titleyenda;?></h4>';
        // Representamos los colores
        for (var i = 0; i < colores.length; i++) {
            div.innerHTML += '<i style="background:' + colores[i] + '"></i> ' + etiquetas[i] + '<br>';
        }
        return div;
    };
    leyenda.addTo(mapa);

    // Agregamos el botón de centrar
    var centrar = L.control({position: 'topleft'});
    centrar.onAdd = function (mapa) {
        var div = L.DomUtil.create('div', 'info legend');        
        div.innerHTML = "<a href='#' class='btn btn-default btn-xs' role='button' id='centrar' title='Centrar Mapa'><span class='glyphicon glyphicon-screenshot' aria-hidden='true'></span></a>";
        return div;
    };
    centrar.addTo(mapa);
    // Botón centrar:
    $('a#centrar').click(function(){
        mapa.setView([39.47, -0.38], 10);
    });
</script>