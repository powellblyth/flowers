@extends('layouts/main')
@php

$Lang = ['AFRIKAANS'=>'welkom',
'ALBANIAN' => 'mirë se vini',
'ALSATIAN' => 'welkomma',
'ARABIC' => 'مرحبا (marhaban)',
'ARMENIAN' => 'bari galoust',
'AZERI' => 'xos gelmissiniz',
'BAMBARA' => 'i bisimila',
'BAOULÉ' => 'akwaba',
'BASQUE' => 'ongi etorri',
'BELARUSIAN' => 'Шчыра запрашаем (ščyra zaprašajem)',
'BENGALI' => 'swagata',
'BERBER' => 'amrehba sisswène',
'BOBO' => 'ani kié',
'BOSNIAN' => 'dobro došli',
'BRETON' => 'degemer mad',
'BULGARIAN' => 'добре дошъл',
'BURMESE' => 'kyo tzo pa eit',
'CATALAN' => 'benvinguts',
'CHECHEN' => 'marsha vog\'iyla',
'CHEROKEE' => 'ulihelisdi',
'CHINESE (MANDARIN)' => '欢迎你来 (huan ying ni lai)',
'CORSICAN' => 'bonavinuta',
'CROATIAN' => 'dobrodošli',
'CZECH' => 'vítejte',
'DANISH' => 'velkommen',
'DUALA' => 'bepôyédi ba bwam',
'DUTCH' => 'welkom',
'ENGLISH' => 'welcome',
'ESPERANTO' => 'bonvenon',
'ESTONIAN' => 'tere tulemast',
'EWÉ' => 'woezon',
'FAROESE' => 'vælkomin',
'FINNISH' => 'tervetuloa',
'FLEMISH' => 'welkom',
'FRENCH' => 'bienvenue',
'FRISIAN' => 'wolkom',
'FRIULAN' => 'binvignut',
'GA' => 'awaa waa atuu',
'GALICIAN' => 'benvido',
'GALLO' => 'bin la v\'nu',
'GEORGIAN' => 'mobrdzandit',
'GERMAN' => 'herzlich willkommen',
'GOTHIC' => 'waila andanems',
'GREEK' => 'Καλώς ήλθατε (kalos ilthate)',
'GUARANÍ' => 'eguahé porá',
'GUN' => 'mikouabô',
'HAITIAN CREOLE' => 'bienvéni',
'HAWAIIAN' => 'e komo mai',
'HEBREW' => 'baroukh haba',
'HINDI' => 'swaagat / aap ka swaagat hein',
'HMONG' => 'tos txais / nyob zou tos txais',
'HUNGARIAN' => 'üdvözlet',
'ICELANDIC' => 'velkomin',
'IGBO' => 'i biala',
'INDONESIAN' => 'selamat datang',
'IRISH GAELIC' => 'fáilte',
'ITALIAN' => 'benvenuti',
'JAPANESE' => 'yôkoso',
'KABYLIAN' => 'amrehva ysswène',
'KHMER' => 'chum reap suor',
'KINYARWANDA' => 'murakaza neza',
'KOREAN' => '환영합니다 (hwan yung hap ni da)',
'KOTOKOLI' => 'nodé',
'KURDISH' => 'bi xer hati',
'LAO' => 'gnindi ton hap',
'LATIN' => '(per) gratus mihi venis',
'LATVIAN' => 'laipni lūdzam',
'LEBANESE ARABIC' => 'أهلا وسهلا (ahla w sahla)',
'LIGURIAN' => 'benvegnûo / benvegnûi',
'LINGALA' => 'boyeyi bolamu',
'LITHUANIAN' => 'sveiki atvykę',
'LOW SAXON' => 'welkum',
'LUXEMBOURGEOIS' => 'wëllkom',
'MACEDONIAN' => 'добредојде (dobredojde)',
'MALAGASY' => 'tonga soa',
'MALAY' => 'selamat datang',
'MALAYALAM' => 'swagatham',
'MALTESE' => 'merħba',
'MAORI' => 'haere mai',
'MBEMBE' => 'kakwa o',
'MINA' => 'miawezon',
'MONGOLIAN' => 'Тавтай морилогтун (tavtai morilogtun)',
'MORÉ' => 'ne y waoongo',
'NEPALI' => 'namaste',
'NORMAN' => 'byivenun / la vilkoume',
'NORMAN (GUERNÉSIAIS)' => 'bianvnu',
'NORMAN (JÈRRIAIS)' => 'bein\'vnu',
'NORWEGIAN' => 'velkommen',
'OCCITAN' => 'benvenguts',
'OLD NORSE' => 'velkom',
'OSSETIAN' => 'Табуафси (tabuafši)',
'PAPIAMENTU' => 'bon bini',
'PERSIAN' => 'خوش آمدید یا (khosh âmadi)',
'POLISH' => 'witajcie (pl.)',
'PORTUGUESE' => 'bem-vindo',
'ROMANI' => 'mishto-avilian tú',
'ROMANIAN' => 'bine aţi venit (pl.)',
'RUSSIAN' => 'добро пожаловать (dobro pojalovat)',
'SAMOAN' => 'afio mai, susu mai ma maliu mai',
'SARDINIAN' => 'benènnidu',
'SCOTTISH GAELIC' => 'fàilte',
'SERBIAN' => 'dobrodošli',
'SHIMAORE' => 'karibu',
'SHONA' => 'wauya (plural: mauya)',
'SINDHI' => 'bhali karay aaya',
'SINHALA' => 'aayuboovan',
'SLOVAK' => 'vitame vás / vitajte',
'SLOVENIAN' => 'dobrodošli',
'SOBOTA' => 'zupinje z te videtite',
'SOMALI' => 'soo dhawaw',
'SPANISH' => 'bienvenidos (pl)',
'SUNDANESE' => 'wilujeng sumping',
'SWAHILI' => 'karibuni',
'SWEDISH' => 'välkommen',
'SWISS-GERMAN' => 'härzliche wöikomme',
'TAGALOG' => 'maligayang pagdating',
'TAHITIAN' => 'maeva',
'TAMIL' => 'nal-varravu',
'TATAR' => 'rahim itegez',
'TELUGU' => 'swagatham',
'THAI' => 'ยินดีต้อนรับ (yindii ton rap)',
'TIBETAN' => 'tashi delek',
'TONGAN' => 'malo e lelei',
'TSHILUBA' => 'difika dilenga',
'TURKISH' => 'hoş geldiniz',
'UDMURT' => 'gazhasa oetiśkom',
'UKRAINIAN' => 'Ласкаво просимо (laskavo prosymo)',
'URDU' => 'khush amdeed',
'UZBEK' => 'hush kelibsiz',
'VIETNAMESE' => 'chào mừng ông mới ðến ',
'HOAN NGHINH (in public, on banner)',
'WALOON' => 'bénvnou',
'WELSH' => 'croeso',
'WEST INDIAN CREOLE' => 'bel bonjou',
'WOLOF' => 'dalal ak diam',
'YORUBA' => 'ékouabô'];

$keys = array_keys($Lang);
$chosen = (int)rand(0,count($Lang)-1);
$welcome = $Lang[$keys[$chosen]];

@endphp

@section('pagetitle', ucwords($welcome))
@section('pagesubtitle', '(Now you know how to say \'welcome\' in '. ucwords(strToLower($keys[$chosen])) . ')')


@section('content')
@if(Auth::check())
    <h1>Welcome, {{Auth::User()->firstname}}</h1>
    <p>This is the <a href="http://www.petershamhorticulturalsociety.org.uk" target="_blank">Petersham Horticultural Society</a>'s system for self-registering membership and entries to the show. Your user account allows you to manage Show Entrants, who are people you
    have the authority to speak for (normally Children, Husband, Wife, Life-Parter etc. etc.</p>
    <p>There's no real limit to the number of entrants you can represent, but remember, only one entrant can win any given cup, points are not aggregated to your user account.
    </p>
    <p>Getting Started - Simply go to "Add An Entrant" in the top menu and create your own personal details, then begin to create the rest of your clan</p>
    <p>Once you have created them all, you can create Entries (i.e. choose which categories you would like to enter) for <em><b>each</b></em> entrant.</p>
    <p>Once you have finished, simply bring a cheque or cash to the show to receive your entry cards, which will be printed in advance</p>
    @endif
@stop