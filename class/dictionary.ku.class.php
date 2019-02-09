<?php

$words = array(
	'Main'=>'سەرەتا',
	'Fund'=>'سندوق',
	'Expense'=>'خەرجییەکان',
	'Accounts'=>'ئەکاونتەکان',
	'Loan in'=>'وەرگرتنی پاره',
	'Loan out'=>'پێدانی پارە',
	'Order in'=>'وەرگرتنی حەوالە',
	'Order out'=>'پێدانی حەوالە',
	'Activity'=>'چالاکی',
	'Print'=>'پرینت',
	'NO'=>'ژ',
	'User'=>'یوزەر',
	'Type'=>'جۆر',
	'id_f'=>'ID',
	'Amount $'=>'بری دۆلار',
	'Amount IQD'=>'بری دینار',
	'Amount Tman'=>'بری تمەن',
	'Date'=>'بەروار',
	'detail'=>'تێبینی',
	'Box $'=>'سندوقی دۆلار',
	'Box IQD'=>'سندوقی دینار',
	'Box Tman'=>'سندوقی تمەن',
	'Description'=>'جۆری خەرجی',
	'Owner Name'=>'ناو',
	'Phone'=>'تەلەفون',
	'Balance $'=>'بالانسی دۆلار',
	'Balance IQD'=>'بالانسی دینار',
	'Balance Tman'=>'بالانسی تمەن',
	'Date Created'=>'بەروار',
	'Account'=>'ئەکاونت',
	'Sender Name'=>'ناوی نێردەر',
	'Sender Phone'=>'تەلەفونی نێردەر',
	'Reciever Name'=>'ناوی وەرگر',
	'Reciever Phone'=>'تەلەفونی وەرگر',
	'Reciever Address'=>'ناونیشانی وەرگر',
	'State'=>'حالەت',
	'Order Payment'=>'حەوالە وەرگرتن',
	'Loan Payment'=>'وەرگرتنی پارە',
	'Loan Payout'=>'پێدانی پارە',
	'Reports'=>'پۆخته',
	'Fund For Day '=>'حیساباتی رۆژی ',
	'to fund'=>'دەستی',
	'Amount'=>'پاره $',
	'Debtor'=>'قەرزدار',
	'Creditor'=>'قەرزدەر',
	'Show Fund Daily'=>'بینینی پوختەی رۆژانەی سندوق',
	'Show Account Balance'=>'جەردی قەرز',
	'Backup'=>'بەک ئاپ',
	'Restore'=>'رێستۆر',
	'Show Account Transiction'=>'بینینی حیسابات',
	'give'=>'رؤشتو',
	'send'=>'هاتو',
	'balance'=>'بالانس',
	'By Account'=>'لە رێگای',
	'From Account'=>'لە لایەن',
	'Buy & Sell'=>'کرین و فرۆش',
	'Amounts'=>'بڕ',
	'Buy'=>'کرین',
	'Sell'=>'فرۆشتن',
	'Buy Rate'=>'نرخی کرین',
	'Sell Rate'=>'نرخی فرۆش',
	'Logout'=>'دەرچون',
	'jard'=>'جەرد',
	'All Buy & Sell'=>'کرین و فرۆشی گشتی',
	'All Fund'=>'سندوقی گشتی',
	'Point Company'=>'کۆمپانیای پۆینت',
	'news'=>'هەوالی نوێ',
	'regular'=>'عادی',
	'loss'=>'خسائر',
	'profit'=>'ربح',
	'Psula'=>'پسولە',
	'Cost'=>'عمولە',
	'type'=>'جۆر',
	'Sender'=>'وەرگیراوە لە',
	'Reciever'=>'بدرێت بە',
	'tman'=>'تمەن',
	'dollar'=>'دۆلار',
	'dinar'=>'دینار',
	'euro'=>'یۆرۆ',
	''=>'',
	''=>'',
	''=>'',
	''=>'',
	''=>'',
	''=>'',
	''=>'',
	''=>'',
	''=>'',
	''=>'',
	''=>'',
	''=>'',
	''=>'',
	''=>'',
	''=>'',
	''=>'',
	''=>'',
	''=>'',
	''=>'',
	''=>'',
	''=>'',
	''=>''
	);

function dic_show($phrase,$check=null){
	global $words;
	if(@$words[$phrase] && !$check)
		echo $words[$phrase];
	else
		echo $phrase;
}

function dic_return($phrase,$check=null){
	global $words;
	if(@$words[$phrase] && !$check)
		return $words[$phrase];
	else
		return $phrase;
}


?>