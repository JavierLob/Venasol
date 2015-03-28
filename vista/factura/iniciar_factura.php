<div class="col-lg-12">
    <div class="main-box">    
        <header class="main-box-header clearfix">
            <h3><i class="fa fa-market-card"></i> Iniciar Facturación</h3>
        </header>
        <div class="main-box-body clearfix">
            <div class="row">
                <div class="alert alert-info">
                    <ul>
                        <li>En este módulo podrás realizar la facturación.</li>
                        <li>Sí necesitas ayuda para usar este módulo haz clic en el botón <button class="btn btn-warning" type="button" onclick="javascript:introJs().start();"><i class="fa fa-question-circle"></i> AYUDA</button>.</li>
                    </ul>
                </div>
            </div>
            <form action="../controlador/control_cliente.php" method="POST" name="form_cliente">
                <input type="hidden" value="{operacion}" name="operacion" id="cam_operacion"/>
                <input type="hidden" value="{idcliente}" name="idcliente" id="cam_idcliente"/>
                <div class="row">
                    <div class="form-group col-sm-12 col-xs-12">
                        <label for="buscar_cliente">Buscar Cliente <span class="badge badge-warning" data-toggle="tooltip" data-placement="rigth" title="Buscar cliente"><i class="fa fa-question"></i></span></label>
                        <input type="text" class="form-control" data-step="1" data-intro='Ingrese la palabra clave a buscar del cliente' data-position="bottom" name="buscar_cliente" id="buscar_cliente" value="" placeholder="Por favor ingrese el Rif o Nombre de un cliente...">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-offset-2 col-lg-10">
                        <button type="submit" data-step="9" data-intro='Para finalizar haga click en guardar para {funcion} el cliente.' data-position="top" class="btn btn-success"><i class="fa fa-check"></i> Guardar</button>
                        <a href="?modulo=cliente/cliente" data-step="10" data-intro='Para salir haga click en regresar.' data-position="top" class="btn btn-danger "><i class="fa fa-chevron-left"></i> Regresar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function($){
    });
</script>