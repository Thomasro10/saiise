<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|


Route::get('/', function () {
    return view('welcome');
});
*/



Route::get('/registro', ['uses' => 'IndexController@getRegistro','as' => 'sistema.registro']);
Route::post('/registro/add', ['uses' => 'IndexController@agregarRegistro','as' => 'sistema.registro.add']);

Route::get('/acceso', ['uses' => 'IndexController@getLogin','as' => 'sistema.acceso']);
Route::post('/validar', ['uses' => 'IndexController@postLogin', 'as' => 'sistema.validar']);

Route::get('/edos', ['uses' => 'UtilidadesController@getEstados','as' => 'sistema.edos']);
Route::get('/mcpios', ['uses' => 'UtilidadesController@getMunicipios','as' => 'sistema.mcpios']);
Route::get('/pquias', ['uses' => 'UtilidadesController@getParroquias','as' => 'sistema.pquias']);

Route::group(['middleware' => 'auth'], function () {

    Route::get('/getEmpresa', ['uses' => 'UtilidadesController@getEmpresa','as' => 'sistema.getEmpresa']);
    Route::get('/getSolicitud', ['uses' => 'UtilidadesController@getSolicitud','as' => 'sistema.getSolicitud']);
    Route::get('/getSolicitudMPrima', ['uses' => 'UtilidadesController@getSolicitudMPrima','as' => 'sistema.getSolicitudMPrima']);

    Route::get('/getDetalleEmpresa', ['uses' => 'UtilidadesController@getDetalleEmpresa','as' => 'sistema.getDetalleEmpresa']);

    Route::get('/getMtriaPrima', ['uses' => 'UtilidadesController@getMtriaPrima','as' => 'sistema.getMtriaPrima']);
    Route::get('/getMPMedida', ['uses' => 'UtilidadesController@getMPMedida','as' => 'sistema.getMPMedida']);

    Route::get('/getFeriaEsp', ['uses' => 'UtilidadesController@getFeriaEsp','as' => 'sistema.getFeriaEsp']);



    Route::get('/', ['uses' => 'IndexController@getIndex', 'as' => 'sistema.index']);
    Route::post('/salir', ['uses' => 'IndexController@getLogout', 'as' => 'sistema.salir']);
    Route::post('/ccambiar', ['uses' => 'IndexController@cambiarClave', 'as' => 'sistema.ccambiar']);

    Route::get('/empresas', ['uses' => 'EmpresaController@getIndex','as' => 'sistema.empresas']);
    Route::post('/empresas/data', ['uses' => 'EmpresaController@getData','as' => 'sistema.empresas.data']);
    Route::post('/empresas/agregar',['uses' => 'EmpresaController@agregarEmpresa','as' => 'sistema.empresas.add']);
    Route::post('/empresas/buscar',['uses' => 'EmpresaController@buscarEmpresa', 'as' => 'sistema.empresas.find']);
    Route::post('/empresas/actualizar',['uses' => 'EmpresaController@actualizarEmpresa','as' => 'sistema.empresas.upd']);
    Route::post('/empresas/eliminar',['uses' => 'EmpresaController@eliminarEmpresa','as' => 'sistema.empresas.del']);
    Route::post('/empresas/detalle',['uses' => 'EmpresaController@verEmpresa','as' => 'sistema.empresas.view']);
    Route::post('/empresas/responsable',['uses' => 'EmpresaController@asigResponsable','as' => 'sistema.empresas.aresp']);




    Route::get('/encuestas', ['uses' => 'EncuestaController@getIndex','as' => 'sistema.encuestas']);
    Route::post('/encuestas/data', ['uses' => 'EncuestaController@getData','as' => 'sistema.encuestas.data']);
    Route::post('/encuestas/add', ['uses' => 'EncuestaController@agregarEncuesta','as' => 'sistema.encuestas.add']);
    Route::post('/encuestas/buscar',['uses' => 'EncuestaController@buscarEncuesta', 'as' => 'sistema.encuestas.find']);
    Route::post('/encuestas/actualizar',['uses' => 'EncuestaController@actualizarEncuesta','as' => 'sistema.encuestas.upd']);
    Route::post('/encuestas/eliminar',['uses' => 'EncuestaController@eliminarEncuesta','as' => 'sistema.encuestas.del']);
    Route::post('/encuestas/detalle',['uses' => 'EncuestaController@verEncuesta','as' => 'sistema.encuestas.view']);

    Route::get('/mprima', ['uses' => 'MprimaController@getIndex','as' => 'sistema.mprima']);
    Route::post('/mprima/data', ['uses' => 'MprimaController@getData','as' => 'sistema.mprima.data']);
    Route::post('/mprima/add', ['uses' => 'MprimaController@agregarMprima','as' => 'sistema.mprima.add']);
    Route::post('/mprima/buscar',['uses' => 'MprimaController@buscarMprima', 'as' => 'sistema.mprima.find']);
    Route::post('/mprima/actualizar',['uses' => 'MprimaController@actualizarMprima','as' => 'sistema.mprima.upd']);
    Route::post('/mprima/eliminar',['uses' => 'MprimaController@eliminarMprima','as' => 'sistema.mprima.del']);
    Route::post('/mprima/detalle',['uses' => 'MprimaController@verMprima','as' => 'sistema.mprima.view']);

    Route::get('/requerimientos', ['uses' => 'RequerimientoController@getIndex','as' => 'sistema.requerimientos']);
    Route::post('/requerimientos/data', ['uses' => 'RequerimientoController@getData','as' => 'sistema.requerimientos.data']);
    Route::post('/requerimientos/add', ['uses' => 'RequerimientoController@agregarRequerimiento','as' => 'sistema.requerimientos.add']);
    Route::post('/requerimientos/buscar',['uses' => 'RequerimientoController@buscarRequerimiento', 'as' => 'sistema.requerimientos.find']);
    Route::post('/requerimientos/actualizar',['uses' => 'RequerimientoController@actualizarRequerimiento','as' => 'sistema.requerimientos.upd']);
    Route::post('/requerimientos/eliminar',['uses' => 'RequerimientoController@eliminarRequerimiento','as' => 'sistema.requerimientos.del']);
    Route::post('/requerimientos/detalle',['uses' => 'RequerimientoController@verRequerimiento','as' => 'sistema.requerimientos.view']);

    Route::get('/logros', ['uses' => 'LogroController@getIndex','as' => 'sistema.logros']);
    Route::post('/logros/data', ['uses' => 'LogroController@getData','as' => 'sistema.logros.data']);
    Route::post('/logros/add', ['uses' => 'LogroController@agregarLogro','as' => 'sistema.logros.add']);
    Route::post('/logros/buscar',['uses' => 'LogroController@buscarLogro', 'as' => 'sistema.logros.find']);
    Route::post('/logros/actualizar',['uses' => 'LogroController@actualizarLogro','as' => 'sistema.logros.upd']);
    Route::post('/logros/eliminar',['uses' => 'LogroController@eliminarLogro','as' => 'sistema.logros.del']);
    Route::post('/logros/detalle',['uses' => 'LogroController@verLogro','as' => 'sistema.logros.view']);

    Route::get('/finanzas', ['uses' => 'RqfinanciamientoController@getIndex','as' => 'sistema.finanzas']);
    Route::post('/finanzas/data', ['uses' => 'RqfinanciamientoController@getData','as' => 'sistema.finanzas.data']);
    Route::post('/finanzas/add', ['uses' => 'RqfinanciamientoController@agregarRqfinanciamiento','as' => 'sistema.finanzas.add']);
    Route::post('/finanzas/buscar',['uses' => 'RqfinanciamientoController@buscarRqfinanciamiento', 'as' => 'sistema.finanzas.find']);
    Route::post('/finanzas/actualizar',['uses' => 'RqfinanciamientoController@actualizarRqfinanciamiento','as' => 'sistema.finanzas.upd']);
    Route::post('/finanzas/eliminar',['uses' => 'RqfinanciamientoController@eliminarRqfinanciamiento','as' => 'sistema.finanzas.del']);
    Route::post('/finanzas/detalle',['uses' => 'RqfinanciamientoController@verRqfinanciamiento','as' => 'sistema.finanzas.view']);

    Route::get('/consultas', ['uses' => 'ConsultasController@getIndex','as' => 'sistema.consultas']);

    Route::get('/usuarios', ['uses' => 'UserController@getIndex','as' => 'sistema.usuarios']);
    Route::get('/usuarios/data', ['uses' => 'UserController@getData','as' => 'sistema.usuarios.data']);
    Route::post('/usuarios/agregar',['uses' => 'UserController@agregarUsuario','as' => 'sistema.usuarios.add']);
    Route::post('/usuarios/buscar',['uses' => 'UserController@buscarUsuario', 'as' => 'sistema.usuarios.find']);
    Route::post('/usuarios/actualizar',['uses' => 'UserController@actualizarUsuario','as' => 'sistema.usuarios.upd']);
    Route::post('/usuarios/eliminar',['uses' => 'UserController@eliminarUsuario','as' => 'sistema.usuarios.del']);
    Route::post('/usuarios/reset',['uses' => 'UserController@resetClaveUsuario','as' => 'sistema.usuarios.res']);
    Route::post('/usuarios/actdes',['uses' => 'UserController@activarDesactivarUsuario','as' => 'sistema.usuarios.ades']);

    Route::get('/logs', ['uses' => 'LogController@getIndex','as' => 'sistema.logs']);
    Route::any('/logs/data', ['uses' => 'LogController@getData','as' => 'sistema.logs.data']);

    Route::get('/solicitudes', ['uses' => 'SolicitudController@getIndex','as' => 'sistema.solicitudes']);
    //Route::post('/solicitudes/data', ['uses' => 'SolicitudController@getData','as' => 'sistema.solicitudes.data']);
    Route::any('/solicitudes/data', ['uses' => 'SolicitudController@getData','as' => 'sistema.solicitudes.data']);
    Route::post('/solicitudes/agregar',['uses' => 'SolicitudController@agregarSolicitud','as' => 'sistema.solicitudes.add']);
    Route::post('/solicitudes/buscar',['uses' => 'SolicitudController@buscarSolicitud', 'as' => 'sistema.solicitudes.find']);
    Route::post('/solicitudes/actualizar',['uses' => 'SolicitudController@actualizarSolicitud','as' => 'sistema.solicitudes.upd']);
    Route::post('/solicitudes/eliminar',['uses' => 'SolicitudController@eliminarSolicitud','as' => 'sistema.solicitudes.del']);
    Route::post('/solicitudes/detalle',['uses' => 'SolicitudController@verSolicitud','as' => 'sistema.solicitudes.view']);
    Route::post('/solicitudes/aprobar',['uses' => 'SolicitudController@aprobarSolicitud','as' => 'sistema.solicitudes.apro']);
    Route::post('/solicitudes/resetAprobar',['uses' => 'SolicitudController@raprobarSolicitud','as' => 'sistema.solicitudes.rapr']);



    Route::get('/permisologia', ['uses' => 'PermisologiaController@getIndex','as' => 'sistema.permisologia']);
    Route::post('/permisologia/data', ['uses' => 'PermisologiaController@getData','as' => 'sistema.permisologia.data']);
    Route::post('/permisologia/agregar',['uses' => 'PermisologiaController@agregarPermisologia','as' => 'sistema.permisologia.add']);
    Route::post('/permisologia/buscar',['uses' => 'PermisologiaController@buscarPermisologia', 'as' => 'sistema.permisologia.find']);
    Route::post('/permisologia/actualizar',['uses' => 'PermisologiaController@actualizarPermisologia','as' => 'sistema.permisologia.upd']);
    Route::post('/permisologia/eliminar',['uses' => 'PermisologiaController@eliminarPermisologia','as' => 'sistema.permisologia.del']);
    Route::post('/permisologia/detalle',['uses' => 'PermisologiaController@verPermisologia','as' => 'sistema.permisologia.view']);

    Route::get('/acciones', ['uses' => 'AccionesController@getIndex','as' => 'sistema.acciones']);
    Route::post('/acciones/data', ['uses' => 'AccionesController@getData','as' => 'sistema.acciones.data']);
    Route::post('/acciones/agregar',['uses' => 'AccionesController@agregarAcciones','as' => 'sistema.acciones.add']);
    Route::post('/acciones/eliminar',['uses' => 'AccionesController@eliminarAcciones','as' => 'sistema.acciones.del']);
    Route::post('/acciones/verform',['uses' => 'AccionesController@verForm','as' => 'sistema.acciones.verform']);
    Route::post('/acciones/veracciones',['uses' => 'AccionesController@verAcciones','as' => 'sistema.acciones.veracciones']);

    Route::get('/seguimiento', ['uses' => 'SeguimientoController@getIndex','as' => 'sistema.seguimiento']);
    Route::post('/seguimiento/data', ['uses' => 'SeguimientoController@getData','as' => 'sistema.seguimiento.data']);
    Route::post('/seguimiento/agregar',['uses' => 'SeguimientoController@agregarSeguimiento','as' => 'sistema.seguimiento.add']);
    Route::post('/seguimiento/eliminar',['uses' => 'SeguimientoController@eliminarSeguimiento','as' => 'sistema.seguimiento.del']);
    Route::post('/seguimiento/verform',['uses' => 'SeguimientoController@verForm','as' => 'sistema.seguimiento.verform']);
    Route::post('/seguimiento/verseguimiento',['uses' => 'SeguimientoController@verSeguimiento','as' => 'sistema.seguimiento.verseguimiento']);

    Route::get('/reportes', ['uses' => 'ReportesController@getIndex','as' => 'sistema.reportes']);
    Route::any('/reportes/empaten', ['uses' => 'ReportesController@getDataEmpresasAtendidas','as' => 'sistema.reportes.empaten']);
    Route::any('/reportes/avance', ['uses' => 'ReportesController@getDataStatusSolicitud','as' => 'sistema.reportes.avance']);

    Route::get('/reportes/graficos', ['uses' => 'GraficosController@getIndexGraficosInt','as' => 'sistema.reportes.graficos']);



    Route::get('/visitas', ['uses' => 'VisitaController@getIndex','as' => 'sistema.visitas']);
    Route::post('/visitas/data', ['uses' => 'VisitaController@getData','as' => 'sistema.visitas.data']);
    Route::post('/visitas/agregar', ['uses' => 'VisitaController@agregarVisitasForm','as' => 'sistema.visitas.agregar']);
    Route::post('/visitas/add', ['uses' => 'VisitaController@agregarVisitas','as' => 'sistema.visitas.add']);
    Route::post('/visitas/dataVisitas', ['uses' => 'VisitaController@getDataVisitas','as' => 'sistema.visitas.dataVisitas']);





    Route::get('/pproductivo', ['uses' => 'ProcesoProductivoController@getIndex','as' => 'sistema.pproductivo']);
    Route::post('/pproductivo/data', ['uses' => 'ProcesoProductivoController@getData','as' => 'sistema.pproductivo.data']);


    Route::get('/eproyecto/responsables', ['uses' => 'EvaluacionProyectoController@getIndexResponsables','as' => 'sistema.eproyecto.responsables']);
    Route::get('/eproyecto/responsables/data', ['uses' => 'EvaluacionProyectoController@getDataResponsables','as' => 'sistema.eproyecto.responsables.data']);
    Route::post('/eproyecto/responsables/agregar',['uses' => 'EvaluacionProyectoController@agregarResponsable','as' => 'sistema.eproyecto.responsables.add']);
    Route::post('/eproyecto/responsables/buscar',['uses' => 'EvaluacionProyectoController@buscarResponsable', 'as' => 'sistema.eproyecto.responsables.find']);
    Route::post('/eproyecto/responsables/actualizar',['uses' => 'EvaluacionProyectoController@actualizarResponsable','as' => 'sistema.eproyecto.responsables.upd']);
    Route::post('/eproyecto/responsables/eliminar',['uses' => 'EvaluacionProyectoController@eliminarResponsable','as' => 'sistema.eproyecto.responsables.del']);
    Route::post('/eproyecto/responsables/actDes',['uses' => 'EvaluacionProyectoController@activarDesactivarResponsable','as' => 'sistema.eproyecto.responsables.ades']);
    Route::get('/eproyecto/responsables/asigProy',['uses' => 'EvaluacionProyectoController@getDataAsigProyectos','as' => 'sistema.eproyecto.responsables.asig']);
    Route::get('/eproyecto/getRespMod', ['uses' => 'UtilidadesController@getEvaRespMod','as' => 'sistema.getRespMod']);
    Route::get('/eproyecto/responsables/asigProyEva',['uses' => 'EvaluacionProyectoController@getDataAsigEvaluacion','as' => 'sistema.eproyecto.responsables.viewAsig']);
    Route::post('/eproyecto/responsables/addAsigEva',['uses' => 'EvaluacionProyectoController@agregarAsigEvaluacion','as' => 'sistema.eproyecto.responsables.addAsigEva']);






    Route::get('/eproyecto/legal', ['uses' => 'EvaluacionProyectoController@getIndexLegal','as' => 'sistema.eproyecto.legal']);
    Route::get('/eproyecto/legal/data', ['uses' => 'EvaluacionProyectoController@getDataLegal','as' => 'sistema.eproyecto.legal.data']);
    Route::post('/eproyecto/legal/buscar',['uses' => 'EvaluacionProyectoController@buscarEvaLegal', 'as' => 'sistema.eproyecto.legal.find']);
    Route::post('/eproyecto/legal/agregar',['uses' => 'EvaluacionProyectoController@agregarEvaLegal','as' => 'sistema.eproyecto.legal.add']);
    Route::post('/eproyecto/legal/ver',['uses' => 'EvaluacionProyectoController@verEvaLegal', 'as' => 'sistema.eproyecto.legal.view']);
    Route::post('/eproyecto/legal/eliminar',['uses' => 'EvaluacionProyectoController@eliminarEvaLegal', 'as' => 'sistema.eproyecto.legal.del']);

    Route::get('/eproyecto/economica', ['uses' => 'EvaluacionProyectoController@getIndexEcomonica','as' => 'sistema.eproyecto.economica']);
    Route::get('/eproyecto/economica/data', ['uses' => 'EvaluacionProyectoController@getDataEconomica','as' => 'sistema.eproyecto.economica.data']);
    Route::post('/eproyecto/economica/buscar',['uses' => 'EvaluacionProyectoController@buscarEvaEconomica', 'as' => 'sistema.eproyecto.economica.find']);
    Route::post('/eproyecto/economica/agregar',['uses' => 'EvaluacionProyectoController@agregarEvaEconomica','as' => 'sistema.eproyecto.economica.add']);
    Route::post('/eproyecto/economica/ver',['uses' => 'EvaluacionProyectoController@verEvaEconomica', 'as' => 'sistema.eproyecto.economica.view']);
    Route::post('/eproyecto/economica/eliminar',['uses' => 'EvaluacionProyectoController@eliminarEvaEconomica', 'as' => 'sistema.eproyecto.economica.del']);

    Route::get('/eproyecto/financiera', ['uses' => 'EvaluacionProyectoController@getIndexFinanciera','as' => 'sistema.eproyecto.financiera']);
    Route::get('/eproyecto/financiera/data', ['uses' => 'EvaluacionProyectoController@getDataFinanciera','as' => 'sistema.eproyecto.financiera.data']);
    Route::post('/eproyecto/financiera/buscar',['uses' => 'EvaluacionProyectoController@buscarEvaFinanciera', 'as' => 'sistema.eproyecto.financiera.find']);
    Route::post('/eproyecto/financiera/agregar',['uses' => 'EvaluacionProyectoController@agregarEvaFinanciera','as' => 'sistema.eproyecto.financiera.add']);
    Route::post('/eproyecto/financiera/ver',['uses' => 'EvaluacionProyectoController@verEvaFinanciera', 'as' => 'sistema.eproyecto.financiera.view']);
    Route::post('/eproyecto/financiera/eliminar',['uses' => 'EvaluacionProyectoController@eliminarEvaFinanciera', 'as' => 'sistema.eproyecto.financiera.del']);

    Route::get('/eproyecto/ingenieria', ['uses' => 'EvaluacionProyectoController@getIndexIngenieria','as' => 'sistema.eproyecto.ingenieria']);
    Route::get('/eproyecto/ingenieria/data', ['uses' => 'EvaluacionProyectoController@getDataIngenieria','as' => 'sistema.eproyecto.ingenieria.data']);
    Route::post('/eproyecto/ingenieria/buscar',['uses' => 'EvaluacionProyectoController@buscarEvaIngenieria', 'as' => 'sistema.eproyecto.ingenieria.find']);
    Route::post('/eproyecto/ingenieria/agregar',['uses' => 'EvaluacionProyectoController@agregarEvaIngenieria','as' => 'sistema.eproyecto.ingenieria.add']);
    Route::post('/eproyecto/ingenieria/ver',['uses' => 'EvaluacionProyectoController@verEvaIngenieria', 'as' => 'sistema.eproyecto.ingenieria.view']);
    Route::post('/eproyecto/ingenieria/eliminar',['uses' => 'EvaluacionProyectoController@eliminarEvaIngenieria', 'as' => 'sistema.eproyecto.ingenieria.del']);

    Route::get('/eproyecto/reportes', ['uses' => 'EvaluacionProyectoController@getIndexReportes','as' => 'sistema.eproyecto.reportes']);
    Route::get('/eproyecto/reportes/dataEvaModSA', ['uses' => 'EvaluacionProyectoController@getReporteEvaluacionEnModuloSA','as' => 'sistema.eproyecto.reportes.dataEvaModSA']);
    Route::get('/eproyecto/reportes/dataEvaModCA', ['uses' => 'EvaluacionProyectoController@getReporteEvaluacionEnModuloCA','as' => 'sistema.eproyecto.reportes.dataEvaModCA']);

    Route::get('/eproyecto/reportes/dataEvaTFLegal', ['uses' => 'EvaluacionProyectoController@getReporteTiempoFaseLegal','as' => 'sistema.eproyecto.reportes.dataEvaTFLegal']);
    Route::get('/eproyecto/reportes/dataEvaTFEconomica', ['uses' => 'EvaluacionProyectoController@getReporteTiempoFaseEconomica','as' => 'sistema.eproyecto.reportes.dataEvaTFEconomica']);
    Route::get('/eproyecto/reportes/dataEvaTFFinanciera', ['uses' => 'EvaluacionProyectoController@getReporteTiempoFaseFinanciera','as' => 'sistema.eproyecto.reportes.dataEvaTFFinanciera']);
    Route::get('/eproyecto/reportes/dataEvaTFIngenieria', ['uses' => 'EvaluacionProyectoController@getReporteTiempoFaseIngenieria','as' => 'sistema.eproyecto.reportes.dataEvaTFIngenieria']);


});

Route::get('/graficos', ['uses' => 'GraficosController@getDatosGrafPie','as' => 'sistema.graficos']);
Route::get('/gbar', ['uses' => 'GraficosController@getDatosGrafBar','as' => 'sistema.gbar']);
Route::get('/grfmp', ['uses' => 'GraficosController@getDatosGrafPieMp','as' => 'sistema.grfmp']);

Route::get('/graficosInt', ['uses' => 'GraficosController@getDatosGrafPieInt','as' => 'sistema.graficosInt']);
Route::get('/gbarInt', ['uses' => 'GraficosController@getDatosGrafBarInt','as' => 'sistema.gbarInt']);
Route::get('/grfmpInt', ['uses' => 'GraficosController@getDatosGrafPieMpInt','as' => 'sistema.grfmpInt']);


Route::get('/amgraficos', ['uses' => 'PruebaController@getDatosGrafPie','as' => 'sistema.amgraficos']);
Route::get('/amgbar', ['uses' => 'PruebaController@getDatosGrafBar','as' => 'sistema.amgbar']);
Route::get('/prueba', ['uses' => 'PruebaController@getIndex','as' => 'sistema.prueba']);



