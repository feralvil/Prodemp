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
<h1><?php echo __('Emplazamiento') . ' ' . $emplazamiento['Emplazamiento']['centro']; ?></h1>
<div id="principal">
    <ul class="nav nav-tabs">
      <li role="presentation" class="active">
          <a href="#" id="localiza">
              <span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span> <?php echo __('Localización');?>
          </a>
      </li>
      <li role="presentation">
          <a href="#" id="servicios">
              <span class="glyphicon glyphicon-tasks" aria-hidden="true"></span> <?php echo __('Servicios');?>
          </a>
      </li>
      <li role="presentation">
          <a href="#" id="titular">
              <span class="glyphicon glyphicon-record" aria-hidden="true"></span> <?php echo __('Titular');?>
          </a>
      </li>
      <li role="presentation">
          <a href="#" id="suministro">
              <span class="glyphicon glyphicon-flash" aria-hidden="true"></span> <?php echo __('Suministro');?>
          </a>
      </li>
      <li role="presentation">
          <a href="#" id="info">
              <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> <?php echo __('Notas');?>
          </a>
      </li>
    </ul>
    <div id="localiza" class="pestanya">
        <div class="col-md-12">
            <h2><?php echo __('Datos de Localización');?></h2>
            <table class="table table-condensed table-hover table-striped">
                <tr>
                    <th><?php echo __('Provincia');?></th>
                    <th><?php echo __('Comarca');?></th>
                    <th><?php echo __('Municipio');?></th>
                    <th><?php echo __('Ubicación');?></th>
                </tr>
                <tr>
                    <td><?php echo $emplazamiento['Municipio']['provincia'];?></td>
                    <td><?php echo $emplazamiento['Comarca']['comarca'];?></td>
                    <td><?php echo $emplazamiento['Municipio']['nombre'];?></td>
                    <td><?php echo $emplazamiento['Emplazamiento']['ubicacion'];?></td>
                </tr>
            </table>
            <h2><?php echo __('Coordenadas');?></h2>
            <table class="table table-condensed table-hover table-striped">
                <tr>
                    <th><?php echo __('Latitud');?></th>
                    <th><?php echo __('Longitud');?></th>
                </tr>
                <tr>
                    <td><?php echo $emplazamiento['Emplazamiento']['latitud'];?></td>
                    <td><?php echo $emplazamiento['Emplazamiento']['longitud'];?></td>
                </tr>
            </table>
        </div>
        <div class="form-group text-center">
            <div class="btn-group" role="group" aria-label="...">
                <?php
                echo $this->Html->Link(
                    '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>' . ' ' . __('Editar Emplazamiento'),
                    array('controller' => 'emplazamientos', 'action' => 'editar', $emplazamiento['Emplazamiento']['id']),
                    array('class' => 'btn btn-default', 'title' => __('Editar Emplazamiento'), 'alt' => __('Editar Emplazamiento'), 'escape' => false)
                );
                echo $this->Html->Link(
                    '<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>' . ' ' . __('Volver'),
                    array('controller' => 'emplazamientos', 'action' => 'index'),
                    array('class' => 'btn btn-default', 'title' => __('Volver'), 'alt' => __('Volver'), 'escape' => false)
                );
                ?>
            </div>
        </div>
    </div>
    <div id="servicios" class="pestanya row hidden">
        <div class="col-md-12">
            <h2><?php echo __('Servicios');?></h2>
            <table class="table table-condensed table-hover table-striped">
                <tr>
                    <th><?php echo __('COMDES');?></th>
                    <th><?php echo __('TDT de la Generalitat');?></th>
                    <th><?php echo __('TDT RTVV');?></th>
                </tr>
                <tr>
                    <?php
                    $servicios = array(1 => 'comdes', 2 => 'tdt-gva', 4 => 'rtvv');
                    $servtipos = array();
                    foreach ($emplazamiento['Servicio'] as $servemp) {
                        $servtipos[] = $servemp['servtipo_id'];
                    }
                    foreach ($servicios as $indserv => $nomserv) {
                    ?>
                        <td class="text-center">
                            <?php
                            $servicio = 'glyphicon glyphicon-remove';
                            if (in_array($indserv, $servtipos)){
                                $servicio = 'glyphicon glyphicon-ok';
                            }
                            ?>
                            <span class="'. <?php echo $servicio;?> . '" aria-hidden="true"></span>
                        </td>
                    <?php
                    }
                    ?>
                </tr>
            </table>
        </div>
    </div>
    <div id="titular" class="pestanya row hidden">
        <div class="col-md-12">
            <h2><?php echo __('Titular del emplazamiento');?></h2>
            <table class="table table-condensed table-hover table-striped">
                <tr>
                    <th><?php echo __('Entidad');?></th>
                    <td><?php echo $emplazamiento['Entidad']['nombre'];?></td>
                    <th><?php echo __('CIF');?></th>
                    <td><?php echo $emplazamiento['Entidad']['cif'];?></td>
                    <th><?php echo __('Mail');?></th>
                    <td><?php echo $emplazamiento['Entidad']['mail'];?></td>
                </tr>
                <tr>
                    <th><?php echo __('Domicilio');?></th>
                    <td>
                        <?php
                            echo $emplazamiento['Entidad']['domicilio'] . ' &mdash; ';
                            echo $emplazamiento['Entidad']['codpostal'] . ' ';
                            if (isset($emplazamiento['Entidad']['Municipio'])){
                                echo $emplazamiento['Entidad']['Municipio']['Municipio']['nombre'] . ' (';
                                echo $emplazamiento['Entidad']['Municipio']['Municipio']['provincia'] . ')';
                            }
                        ?>
                    </td>
                    <th><?php echo __('Teléfono');?></th>
                    <td><?php echo $emplazamiento['Entidad']['telefono'];?></td>
                    <th><?php echo __('Fax');?></th>
                    <td><?php echo $emplazamiento['Entidad']['fax'];?></td>
                </tr>
            </table>
        </div>
    </div>
    <div id="suministro" class="pestanya row hidden">
        <div class="col-md-12">
            <h2><?php echo __('Suministro eléctrico del emplazamiento');?></h2>
            <?php
            if (!empty($emplazamiento['Suministro'])){
            ?>
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="page-header"><?php echo __('Titular del suministro');?></h3>
                        <table class="table table-condensed table-hover table-striped">
                            <tr>
                                <th><?php echo __('CIF');?></th>
                                <td><?php echo $emplazamiento['Suministro']['Titular']['Entidad']['cif'];?></td>
                                <th><?php echo __('Titular');?></th>
                                <td><?php echo $emplazamiento['Suministro']['Titular']['Entidad']['nombre'];?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h3 class="page-header"><?php echo __('Proveedor del suministro');?></h3>
                        <table class="table table-condensed table-hover table-striped">
                            <tr>
                                <th><?php echo __('CIF');?></th>
                                <td><?php echo $emplazamiento['Suministro']['Proveedor']['Entidad']['cif'];?></td>
                                <th><?php echo __('Proveedor');?></th>
                                <td><?php echo $emplazamiento['Suministro']['Proveedor']['Entidad']['nombre'];?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <h3 class="page-header"><?php echo __('Datos del suministro');?></h3>
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-condensed table-hover table-striped">
                            <tr>
                                <th><?php echo __('CUPS');?></th>
                                <td><?php echo $emplazamiento['Suministro']['cups'];?></td>
                                <th><?php echo __('Nº Póliza / Ref. Contrato');?></th>
                                <td><?php echo $emplazamiento['Suministro']['nreferencia'];?></td>
                            </tr>
                            <tr>
                                <th><?php echo __('Dirección');?></th>
                                <td colspan="3"><?php echo $emplazamiento['Suministro']['dirsuministro'];?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-condensed table-hover table-striped">
                            <tr>
                                <th><?php echo __('Tarifa Acceso');?></strong></th>
                                <td><?php echo $emplazamiento['Suministro']['taracceso'];?> A</td>
                                <th><?php echo __('Pot. Punta');?></th>
                                <td><?php echo $emplazamiento['Suministro']['potpunta'];?> kW</td>
                                <th><?php echo __('Pot. Acceso');?></th>
                                <td><?php echo $emplazamiento['Suministro']['potacceso'];?> kW</td>
                            </tr>
                            <tr>
                                <th><?php echo __('Pot. Valle');?></div>
                                <td><?php echo $emplazamiento['Suministro']['potvalle'];?> kW</td>
                                <th><?php echo __('Pot. Llano');?></div>
                                <td><?php echo $emplazamiento['Suministro']['potllano'];?> kW</td>
                                <th><?php echo __('Nº Expediente');?></div>
                                <td><?php echo $emplazamiento['Suministro']['expediente'];?> kW</td>
                            </tr>
                        </table>
                    </div>
                </div>
            <?php
            }
            else{
            ?>
            <div class='panel panel-warning'>
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo  __('No hay resultados'); ?></h3>
                </div>
                <div class="panel-body">
                    <?php echo __('No se han econtrado datos de suministro eléctrico del emplazamiento'); ?>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
    </div>
    <div id="info" class="pestanya row hidden">
        <div class="col-md-12">
            <h2><?php echo __('Observaciones');?></h2>
            <p>
                <?php
                if ($emplazamiento['Emplazamiento']['notas'] != ""){
                    echo $emplazamiento['Emplazamiento']['notas'];
                }
                else{
                ?>
                    <div class='panel panel-warning'>
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo  __('No hay Observaciones'); ?></h3>
                        </div>
                        <div class="panel-body">
                            <?php echo __('No se han encontrado observaciones para este emplazamiento'); ?>
                        </div>
                    </div>
                <?php
                }
                ?>
                
            </p>
        </div>
    </div>
</div>
