<?php

return [

'paypal' => [
'client_id' =>'Absd1KCMNAvud2dHi9N7FoOfqKYrPrcS0938kmWZ3RTn8DLPe09cd-yucY5K7nCE0r_Ts9Q6OtLDFh8J',
'secret' => 'EBvPEGq9jB1vHUwNKOibXO5yXjQ_5hIukahMPLItIIx7v4-KIj_G2w9YVX3DYSWEB2oYk0GV9o5MEQQk',
'settings' => array(
'mode' => 'sandbox',
'http.ConnectionTimeOut' => 1000,
'log.LogEnabled' => true,
'log.FileName' => storage_path() . '/logs/paypal.log',
'log.LogLevel' => 'INFO'
),

],

'2checkout' => [

//

]

];
