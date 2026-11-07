<?php
return [
'name' => env('STUDIO_NAME', 'Art Of Ink'),
 'notify_email' => env('STUDIO_NOTIFY_EMAIL', env('ADMIN_EMAIL')), // receives every quote/consultation request
 'logo_url' => env('STUDIO_LOGO_URL'),
 'deposit_percent' => (int) env('DEPOSIT_PERCENT', 50),
 'rates' => ['U' => 1, 'B' => (float) env('RATE_BRL', 5.5), 'A' => (float) env('RATE_ARS', 1000)],
 'wallets' => ['BTC' => env('WALLET_BTC', '0x1d44a8a4ea451179395a13ffe331d7c9fdc031d2'), 'ETH' => env('WALLET_ETH', '0x1d44a8a4ea451179395a13ffe331d7c9fdc031d2'), 'USDT' => env('WALLET_USDT', '0x1d44a8a4ea451179395a13ffe331d7c9fdc031d2')],
 'styles' => ['Realism','Portrait','Black & Grey','Fine-Line','Minimalist','Lettering','Traditional','Neo-Traditional','Blackwork','Ornamental','Japanese','Color','Cover-up','Other'],
 'colors' => ['Black & Grey','Color','Blackwork'],
 // Premium menu: [label, starting price in USD | null = custom quote]
 'prices' => [
  'Small / Fine line' => [['Minimal & fine-line pieces',100],['Small lettering',120],['Custom small designs',150]],
  'Medium custom pieces' => [['Medium tattoo',250],['Detailed custom work',350],['Color pieces',400]],
  'Large / statement pieces' => [['Large custom tattoo',500],['Half sleeve',800],['Full sleeve',1500]],
  'Realism & portraits' => [['Black & grey realism',600],['Portrait work',750],['Full-color realism',900]],
  'Full back & bodysuits' => [['Full back / large-scale project',null],['Full bodysuit',null]],
 ],
 'placements' => [
  'Upper body' => ['Collarbone','Chest','Sternum','Shoulders','Upper back','Shoulder blades','Ribs','Side/obliques','Stomach'],
  'Arms & hands' => ['Upper arm','Inner/outer bicep','Forearm','Inner wrist','Outer wrist','Elbow','Hand','Fingers'],
  'Lower body' => ['Thigh','Hip','Calf'],
 ],
];
