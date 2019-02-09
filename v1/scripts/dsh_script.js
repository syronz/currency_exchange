$(document).ready(function (){

	$('#print_btn').click(function(){
		// alert();
		// var printDivCSS = new String ('<link href="scripts/jtable.2.3.1/themes/metro/blue/jtable.css" rel="stylesheet" type="text/css" />'+'<link href="themes/redmond/jquery-ui-1.8.16.custom.css" rel="stylesheet">'+'<link href="print_style.css" rel="stylesheet" type="text/css" />');

printDivCSS = "<style>@font-face{font-family:kxani;src:url(themes/kxani.woff)}.corner{margin-top:-50px;float:right;font-family:arial;font-size:smaller;direction:rtl}.dash,.dash2{text-align:center;font-size:7px}section{direction:rtl;font-family:kxani}section h2,section h3{text-align:center;margin:0}.corner p{margin:0 25px 5px 0}section p{margin:0 15px 2px 0;padding:5px 15px 5px 5px;border-radius:3px}section p span{display:inline-block;width:100px}section .package{border:2px solid gray;border-radius:5px;padding:10px;margin-top:10px}.pedar{float:right;margin:25px 150px 0 0}.warger{float:left;margin:25px 0 0 150px}.clear{clear:both}.ee{background-color:#EEE}.dash{border-bottom:1px dotted gray;margin:40px  10px;font-family:courier new}.dash2{margin:20px 0 0;font-family:courier}.jtable-command-column,.jtable-command-column-header{display:none}.jtable-column-header-container{background:0 0} h2,h3,h5{text-align:center}*{font-family:'Unikurd Xani'}table{border-collapse:collapse;border:1px solid gray;width:80%;margin:10px auto}.facture_footer,.facture_header{background-image:url();background-repeat:no-repeat;width:100%}td{border:1px dotted gray;text-align:right;padding-right:3px;font-size:9pt;font-family:arial;padding-top:1px;padding-bottom:1px}tr:nth-child(even){background-color:#EEE}h5{margin-top:30px;margin-bottom:5px}.clear{clear:both}h2,h3{font-size:15px}.facture_header{height:150px;background-size:650px 140px}.facture_footer{height:100px;background-size:650px 92px}th{height:150%;background-color:#DDD}a{text-decoration:none}tr td:last-child,tr th:last-child{display:none;}</style>"


	    var styles = '<style> td{text-decoration:underline;} </style>';
	    window.frames["print_frame"].document.body.innerHTML=printDivCSS + document.getElementById("main").innerHTML;
	    window.frames["print_frame"].window.focus();
	    window.frames["print_frame"].window.print();
	});
});
	