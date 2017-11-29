<h1><?php echo __('Suministro del Emplazamiento') . ' ' . $suministro['Emplazamiento']['centro']; ?></h1>
<div class="row">
    <div class="col-md-12">
        <h2><?php echo __('Datos del emplazamiento');?></h2>
        <table class="table table-condensed table-hover table-striped">
            <tr>
                <th><?php echo __('Latitud');?></th>
                <th><?php echo __('Longitud');?></th>
                <th><?php echo __('COMDES');?></th>
                <th><?php echo __('TDT-GVA');?></th>
                <th><?php echo __('RTVV');?></th>
            </tr>
            <tr>
                <td><?php echo $suministro['Emplazamiento']['latitud'];?></td>
                <td><?php echo $suministro['Emplazamiento']['longitud'];?></td>
                <?php
                $servicios = array(1 => 'comdes', 2 => 'tdt-gva', 4 => 'rtvv');
                foreach ($servicios as $nomserv) {
                    $servicio = 'glyphicon glyphicon-remove';
                    if ($suministro['Emplazamiento'][$nomserv] == 'SI'){
                        $servicio = 'glyphicon glyphicon-ok';
                    }
                ?>
                    <td><span class="'. <?php echo $servicio;?> . '" aria-hidden="true"></span></td>
                <?php
                }
                ?>

            </tr>
        </table>
    </div>
    <div class="col-md-6">
        <h2><?php echo __('Titular del suministro');?></h2>
        <table class="table table-condensed table-hover table-striped">
            <tr>
                <th><?php echo __('CIF');?></th>
                <td><?php echo $suministro['TitSuministro']['cif'];?></td>
                <th><?php echo __('Titular');?></th>
                <td><?php echo $suministro['TitSuministro']['nombre'];?></td>
            </tr>
        </table>
    </div>
    <div class="col-md-6">
        <h2><?php echo __('Proveedor del suministro');?></h2>
        <table class="table table-condensed table-hover table-striped">
            <tr>
                <th><?php echo __('CIF');?></th>
                <td><?php echo $suministro['ProvSuministro']['cif'];?></td>
                <th><?php echo __('Proveedor');?></th>
                <td><?php echo $suministro['ProvSuministro']['nombre'];?></td>
            </tr>
        </table>
    </div>
    <h2 class="col-md-12"><?php echo __('Datos del suministro');?></h2>
    <div class="col-md-6">
        <table class="table table-condensed table-hover table-striped">
            <tr>
                <th><?php echo __('CUPS');?></th>
                <td><?php echo $suministro['Suministro']['cups'];?></td>
                <th><?php echo __('Nº Póliza / Ref. Contrato');?></th>
                <td><?php echo $suministro['Suministro']['nreferencia'];?></td>
            </tr>
            <tr>
                <th><?php echo __('Dirección');?></th>
                <td colspan="3"><?php echo $suministro['Suministro']['dirsuministro'];?></td>
            </tr>
        </table>
    </div>
    <div class="col-md-6">
        <table class="table table-condensed table-hover table-striped">
            <tr>
                <th><?php echo __('Tarifa Acceso');?></strong></th>
                <td><?php echo $suministro['Suministro']['taracceso'];?> A</td>
                <th><?php echo __('Pot. Punta');?></th>
                <td><?php echo $suministro['Suministro']['potpunta'];?> kW</td>
                <th><?php echo __('Pot. Acceso');?></th>
                <td><?php echo $suministro['Suministro']['potacceso'];?> kW</td>
            </tr>
            <tr>
                <th><?php echo __('Pot. Valle');?></div>
                <td><?php echo $suministro['Suministro']['potvalle'];?> kW</td>
                <th><?php echo __('Pot. Llano');?></div>
                <td><?php echo $suministro['Suministro']['potllano'];?> kW</td>
                <th><?php echo __('Nº Expediente');?></div>
                <td><?php echo $suministro['Suministro']['expediente'];?></td>
            </tr>
        </table>
    </div>
     <div class="col-md-12">
        <h2><?php echo __('Observaciones');?></h2>
        <?php
        if ($suministro['Suministro']['notas'] != ""){
            echo $suministro['Suministro']['notas'];
        }
        else{
            echo '&mdash;';
        }
        ?>
    </div>
</div>
<div class="row">
    <div class="form-group text-center">
        <div class="btn-group" role="group" aria-label="...">
            <?php
            echo $this->Html->Link(
                '<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>' . ' ' . __('Modificar suministro'),
                array('controller' => 'suministros', 'action' => 'editar', $suministro['Suministro']['id']),
                array('class' => 'btn btn-default', 'title' => __('Modificar suministro'), 'alt' => __('Modificar suministro'), 'escape' => false)
            );
            echo $this->Form->postLink(
                '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>' . ' ' . __('Borrar Suministro'),
                array('controller' => 'suministros', 'action' => 'borrar', $suministro['Suministro']['id']),
                array('class' => 'btn btn-default', 'title' => __('Borrar Suministro'), 'escape' => false),
                __('¿Seguro que desea eliminar este suministro?')
            );
            echo $this->Html->Link(
                '<span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>' . ' ' . __('Ir a emplazamiento'),
                array('controller' => 'emplazamientos', 'action' => 'detalle', $suministro['Emplazamiento']['id']),
                array('class' => 'btn btn-default', 'title' => __('Ir a emplazamiento'), 'alt' => __('Ir a emplazamiento'), 'escape' => false)
            );
            echo $this->Html->Link(
                '<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>' . ' ' . __('Volver'),
                array('controller' => 'suministros', 'action' => 'index'),
                array('class' => 'btn btn-default', 'title' => __('Volver'), 'alt' => __('Volver'), 'escape' => false)
            );
            ?>
        </div>
    </div>
</div>
