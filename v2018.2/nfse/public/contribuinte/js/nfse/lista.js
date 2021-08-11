$(function() {
	// Lista (management)
	$('table#lista').dataTable({
		"sAjaxSource"		: "/contribuinte/nfse/lista-ajax", // Url server
        "aoColumnDefs"		: [{ "bSortable" : false, "aTargets" : [0] }],
        "bServerSide"		: true,			// Dados via server, abaixo template para a paginacao
		"sDom"				: "<'fields-row'<'pull-right'l><'pull-left'f>r>t<'pull-left'i><'pull-right'p>>",
		"sPaginationType"	: "bootstrap",	// Estilo para paginacao
		"bProcessing"		: true, 		// Mostra o Loading
        "bLengthChange"		: true,    		// Mostra opcao para qtde de itens/pagina
        "bFilter"			: true,     	// Mostra campo de busca
        "bInfo"				: true,			// Mostra informacoes da qtde de registros
        "bPaginate"			: true,    		// Mostra a paginacao
        "bAutoWidth"		: false,     	// Largura automatica
        "bStateSave"		: false,		// Salva em cookie
		"oLanguage"			:
		{
			"sUrl"	: "/js/lib/table/jquery.dataTables.pt.js"
	    }
    });

	// Bug dataTable
	$('ul.nav li a').css('cursor', 'pointer');
});