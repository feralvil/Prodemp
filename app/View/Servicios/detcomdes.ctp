<?php
// Funciones JQuery:
$functab = "$('div[class*=\"pestanya\"]').addClass('hidden');";
$functab .= "$('ul li').removeClass('active');";
$functab .= "$(this).parent().addClass('active');";
$functab .= "var divshow = $(this).attr('id');";
$functab .= "$('div#' + $(this).attr('id')).removeClass('hidden');";
$this->Js->get("div#principal ul li a");
$this->Js->event('click', $functab);
?>
<h1><?php echo __('Servicio') . ' COMDES de ' . $servicio['Emplazamiento']['centro']; ?></h1>
<div id="principal">
    <ul class="nav nav-tabs">
        <li role="presentation" class="active">
            <a href="#" id="localiza">
                <span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span> <?php echo __('Emplazamiento');?>
            </a>
        </li>
        <li role="presentation">
            <a href="#" id="cobertura">
                <span class="glyphicon glyphicon-signal" aria-hidden="true"></span> <?php echo __('Cobertura');?>
            </a>
        </li>
    </ul>
    <div id="localiza" class="pestanya">
        <h2><?php echo __('Datos de Localización');?></h2>
        <table class="table table-condensed table-hover table-striped">
            <tr>
                <th><?php echo __('Provincia');?></th>
                <th><?php echo __('Comarca');?></th>
                <th><?php echo __('Municipio');?></th>
            </tr>
            <tr>
                <td><?php echo $servicio['Emplazamiento']['Municipio']['provincia'];?></td>
                <td><?php echo $servicio['Emplazamiento']['Municipio']['Comarca']['comarca'];?></td>
                <td><?php echo $servicio['Emplazamiento']['Municipio']['nombre'];?></td>
            </tr>
        </table>
        <h2><?php echo __('Coordenadas');?></h2>
        <table class="table table-condensed table-hover table-striped">
            <tr>
                <th><?php echo __('Latitud');?></th>
                <th><?php echo __('Longitud');?></th>
            </tr>
            <tr>
                <td><?php echo $servicio['Emplazamiento']['latitud'];?></td>
                <td><?php echo $servicio['Emplazamiento']['longitud'];?></td>
            </tr>
        </table>
    </div>
    <div id="cobertura" class="pestanya">
        <?php
        if (count($servicio['Cobertura']) > 0){
            $totHabitantes = 0;
            $totCubiertos = 0;
        ?>
            <h3><?php echo __('Municipios cubiertos') . ': ' . count($servicio['Cobertura']); ?></h3>
            <table class="table table-condensed table-hover table-striped">
                <tr>
                    <th><?php echo __('Provincia');?></th>
                    <th><?php echo __('Municipio');?></th>
                    <th><?php echo __('Población');?></th>
                    <th><?php echo __('Hab. Cubiertos (%)');?></th>
                </tr>
                <?php
                foreach ($servicio['Cobertura'] as $cobertura) {
                    $totHabitantes += $cobertura['poblacion'];
                    $totCubiertos += $cobertura['habCubiertos'];
                ?>
                    <tr>
                        <td><?php echo $cobertura['provincia'];?></td>
                        <td><?php echo $cobertura['municipio'];?></td>
                        <td><?php echo $cobertura['poblacion'];?></td>
                        <td>
                            <?php
                            echo $cobertura['habCubiertos'] . ' (' . $cobertura['porcentaje'] . ' %)';
                            ?>
                        </td>
                    </tr>
                <?php
                }
                ?>
                <tr>
                    <th colspan="2"><?php echo __('Totales');?></th>
                    <th><?php echo $totHabitantes;?></th>
                    <th><?php echo $totCubiertos;?></th>
                </tr>
            </table>
        <?php
        }
        else{
        ?>
            <div class='panel panel-warning'>
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo  __('No hay resultados'); ?></h3>
                </div>
                <div class="panel-body">
                    <?php echo __('No se han econtrado municipios cubiertos por este centro'); ?>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</div>
