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
    </ul>
    <div id="localiza" class="pestanya">
        <div class="col-md-12">
            <h2><?php echo __('Datos de Localización');?></h2>
            <table class="table table-condensed table-hover table-striped">
                <tr>
                    <th><?php echo __('Provincia');?></th>
                    <th><?php echo __('Comarca');?></th>
                    <th><?php echo __('Municipio');?></th>
                </tr>
                <tr>
                    <td><?php echo $emplazamiento['Municipio']['provincia'];?></td>
                    <td><?php echo $emplazamiento['Comarca']['comarca'];?></td>
                    <td><?php echo $emplazamiento['Municipio']['nombre'];?></td>
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
                            echo $emplazamiento['Entidad']['Municipio']['Municipio']['nombre'] . ' (';
                            echo $emplazamiento['Entidad']['Municipio']['Municipio']['provincia'] . ')';
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
</div>
