<?php
// Dinamismo con JQuery
$next = $this->Paginator->counter('{:page}') + 1;
$prev = $this->Paginator->counter('{:page}') - 1;
$ultima = $this->Paginator->counter('{:pages}');
$this->Js->get("#anterior");
$this->Js->event('click', "$('#SuministroIrapag').val($prev);$('#SuministroIndexForm').submit()");
$this->Js->get("#siguiente");
$this->Js->event('click', "$('#SuministroIrapag').val($next);$('#SuministroIndexForm').submit()");
$this->Js->get("#primera");
$this->Js->event('click', "$('#SuministroIrapag').val(1);$('#SuministroIndexForm').submit()");
$this->Js->get("select");
$this->Js->event('change', '$("#SuministroIndexForm").submit()');
$this->Js->get("#ultima");
$this->Js->event('click', "$('#SuministroIrapag').val($ultima);$('#SuministroIndexForm').submit()");
$nsum = count($suministros);
?>
<h1><?php echo __('Suministros eléctricos de Telecomunicaciones de la Comunitat'); ?></h1>
<?php
echo $this->Form->create('Suministro', array(
    'inputDefaults' => array('label' => false,'div' => false),
    'class' => 'form-horizontal'
));
echo $this->Form->hidden('tampag', array('value' => $this->Paginator->counter('{:current}')));
echo $this->Form->hidden('irapag', array('value' => '0'));
?>
<fieldset>
    <legend>
        <?php
        echo __('Criterios de Búsqueda') . ' &mdash; ';
        echo $this->Html->Link(
            '<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>',
            array('controller' => 'suministros', 'action' => 'index'),
            array('title' => __('Limpiar Criterios'), 'escape' => false)
        );
        ?>
    </legend>
    <div class="form-group">
        <?php
        echo $this->Form->label('Suministro.emplazamiento_id', __('Emplazamiento'), array('class' => 'col-sm-1 control-label'));
        echo $this->Form->input('Suministro.emplazamiento_id', array('options' => $emplazamientos, 'empty' => __('Seleccionar'), 'div' => 'col-sm-3', 'class' => 'form-control'));
        echo $this->Form->label('Suministro.titular', __('Titular'), array('class' => 'col-sm-1 control-label'));
        echo $this->Form->input('Suministro.titular', array('options' => $titulares, 'empty' => __('Seleccionar'), 'div' => 'col-sm-3', 'class' => 'form-control'));
        echo $this->Form->label('Suministro.proveedor', __('Proveedor'), array('class' => 'col-sm-1 control-label'));
        echo $this->Form->input('Suministro.proveedor', array('options' => $proveedores, 'empty' => __('Seleccionar'), 'div' => 'col-sm-3', 'class' => 'form-control'));
        ?>
    </div>
</fieldset>
<fieldset>
    <legend>
        <?php
        echo __('Resultados de Búsqueda');
        if ($nsum > 0){
            echo ' &mdash; ' . __($this->Paginator->counter("Suministros <b>{:start}</b> a <b>{:end}</b> de <b>{:count}</b>"));
        }
        ?>
    </legend>
    <div class="form-group">
        <?php
        $opciones = array(30 => 30, 50 => 50, 100 => 100, $this->Paginator->counter('{:count}') => 'Todos');
        echo $this->Form->label('Suministro.regPag', __('Suministros por página'), array('class' => 'col-md-2 control-label'));
        echo $this->Form->input('Suministro.regPag', array('options' => $opciones, 'empty' => __('Seleccionar'), 'div' => 'col-md-2', 'class' => 'form-control'));
        ?>
        <div class="btn-group col-md-4" role="group" aria-label="...">
            <?php
            $clase = 'btn btn-default';
            if ($this->Paginator->counter('{:page}') == 1) {
                    $clase .= ' disabled';
            }
            echo $this->Html->Link(
                    '<span class="glyphicon glyphicon-step-backward" aria-hidden="true"></span>', '#',
                    array('title' => __('Primera Página'), 'class' => $clase, 'id' => 'primera', 'alt' => __('Primera Página'), 'escape' => false)
            );
            $clase = 'btn btn-default';
            if (!$this->Paginator->hasPrev()) {
                    $clase .= ' disabled';
            }
            echo $this->Html->Link(
                    '<span class="glyphicon glyphicon-backward" aria-hidden="true"></span>', '#',
                    array('title' => __('Página Anterior'), 'class' => $clase, 'id' => 'anterior', 'alt' => __('Página Anterior'), 'escape' => false)
            );
            $clase = 'btn btn-default';
            echo $this->Html->Link(
                    __('Página') . ' ' . $this->Paginator->counter('{:page}')  . ' / ' . $this->Paginator->counter('{:pages}'), '#',
                    array('title' => __('Página Actual'), 'class' => $clase, 'alt' => __('Página Actual'), 'escape' => false)
            );
            $clase = 'btn btn-default';
            if (!$this->Paginator->hasNext()) {
                    $clase .= ' disabled';
            }
            echo $this->Html->Link(
                '<span class="glyphicon glyphicon-forward" aria-hidden="true"></span>', '#',
                array('title' => __('Página Siguiente'), 'class' => $clase, 'id' => 'siguiente', 'alt' => __('Página Siguiente'), 'escape' => false)
            );
            $clase = 'btn btn-default';
            if ($this->Paginator->counter('{:page}') == $this->Paginator->counter('{:pages}')) {
                    $clase .= ' disabled';
            }
            echo $this->Html->Link(
                    '<span class="glyphicon glyphicon-step-forward" aria-hidden="true"></span>', '#',
                    array('title' => __('Última Página'), 'class' => $clase, 'id' => 'ultima', 'alt' => __('Última Página'), 'escape' => false)
            );
            ?>
        </div>
        <div class="col-md-2">
            <div class="btn-group" role="group" aria-label="...">
                <?php
                if ((AuthComponent::user('role') == 'admin') || (AuthComponent::user('role') == 'colab')) {
                    echo $this->Html->Link(
                        '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>',
                        array('controller' => 'suministros', 'action' => 'agregar'),
                        array('title' => __('Agregar Suministro'), 'class' => 'btn btn-default', 'alt' => __('Agregar Suministro'), 'escape' => false)
                    );
                }
                echo $this->Html->Link(
                    '<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>',
                    array('controller' => 'suministros', 'action' => 'xlsexportar'),
                    array('title' => __('Exportar a Excel'), 'class' => 'btn btn-default', 'alt' => __('Exportar a Excel'), 'target' => '_blank', 'escape' => false)
                );
                ?>
            </div>
        </div>
    </div>
</fieldset>
<?php
echo $this->Form->end();
if ($nsum > 0){
?>
    <table class="table table-condensed table-hover table-striped table-bordered">
        <tr>
            <th><?php echo __('Acciones');?></th>
            <th><?php echo __('Emplazamiento');?></th>
            <th><?php echo __('CIF Titular');?></th>
            <th><?php echo __('Titular Suminstro');?></th>
            <th><?php echo __('CUPS');?></th>
            <th><?php echo __('Dirección de Suminstro');?></th>
            <th><?php echo __('Proveedor');?></th>
        </tr>
        <?php
        foreach ($suministros as $suministro) {
        ?>
            <tr>
                <td class="text-center">
                    <?php
                    echo $this->Html->Link(
                        '<span class="glyphicon glyphicon-search" aria-hidden="true"></span>',
                        array('controller' => 'suministros', 'action' => 'detalle', $suministro['Suministro']['id']),
                        array('title' => __('Detalle de Suministro'), 'alt' => __('Detalle de Suministro'), 'escape' => false)
                    );
                    ?>
                    &mdash;
                    <?php
                    echo $this->Html->Link(
                        '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>',
                        array('controller' => 'suministros', 'action' => 'editar', $suministro['Suministro']['id']),
                        array('title' => __('Modificar Suministro'), 'alt' => __('Modificar Suministro'), 'escape' => false)
                    );
                    ?>
                </td>
                <td><?php echo $suministro['Emplazamiento']['centro'];?></td>
                <td><?php echo $suministro['TitSuministro']['cif'];?></td>
                <td><?php echo $suministro['TitSuministro']['nombre'];?></td>
                <td><?php echo $suministro['Suministro']['cups'];?></td>
                <td><?php echo $suministro['Suministro']['dirsuministro'];?></td>
                <td><?php echo $suministro['ProvSuministro']['nombre'];?></td>
            </tr>
        <?php
        }
        ?>
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
            <?php echo __('No se han econtrado suministros eléctricos con los criterios de búsqueda seleccionados'); ?>
        </div>
    </div>
<?php
}
?>
