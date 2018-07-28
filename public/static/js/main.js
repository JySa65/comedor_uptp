require("../../../node_modules/hammerjs/hammer.js");
require("../../../node_modules/jquery/dist/jquery.js");
require("../../../node_modules/materialize-css/dist/js/materialize.js");


$('.button-collapse').sideNav({
	menuWidth: 300, 
	edge: 'left', 
	closeOnClick: false, 
	draggable: true 
});
// $('.collapsible').collapsible();
$(".dropdown-button").dropdown();
$('select').material_select();

$.extend($.fn.pickadate.defaults, {
	monthsFull: [ 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre' ],
	weekdaysShort: [ 'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic' ],
	weekdaysFull: [ 'Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado' ],
	weekdaysShort: [ 'Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab' ],
	weekdaysLetter: [ 'D', 'L', 'M', 'MI', 'J', 'V', 'S' ],
	labelMonthNext: 'Siguiente mes',
	labelMonthPrev: 'Mes anterior',
	labelMonthSelect: 'Selecciona un mes',
	labelYearSelect: 'Selecciona un año'
})

$('.datepicker').pickadate({
	'format': 'yyyy-mm-dd',
	'selectMonths': true, 
	'selectYears': 1,
	'today': 'Hoy',
	'clear': 'Limpiar',
	'close': 'Ok',
	'closeOnSelect': true, 
	'firstDay': true,
	'max': new Date(),
	'disable': [0,6]
})


