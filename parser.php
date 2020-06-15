<?php
   require_once __DIR__ . "/Config.php";
   require_once __DIR__ . "/Entity/Product.php";
   require_once __DIR__ . "/Entity/InterChangeAbility.php";
   require_once __DIR__ . "/Repository/ArrayProductRepository.php";
   require_once __DIR__ . "/Repository/MysqlProductRepository.php";

   $config = new Config();
   $arrayProductRepository = new ArrayProductRepository();

   $dirFiles = scandir(__DIR__ . "/" .$config->get('DATA_FOLDER'));
   $importFiles = preg_grep('/^import[\d]+_1.xml$/', $dirFiles);

   foreach ($importFiles as $file) {
       echo "Parsing file: " . $file . "\n";

       preg_match('/^import(\d+)_1.xml$/', $file, $city_code);
       $city_code = $city_code[1];

       $importXml = simplexml_load_file(__DIR__ . "/" .$config->get('DATA_FOLDER') . "/" . $file);
       $offersXml = simplexml_load_file(__DIR__ . "/" .$config->get('DATA_FOLDER') . "/offers{$city_code}_1.xml");

       foreach ($importXml->{'Каталог'}->{'Товары'}->{'Товар'} as $xmlProduct) {
           if (!$arrayProductRepository->exists((int)$xmlProduct->{'Код'})) {
               $product = new Product();

               $product->code = (int)$xmlProduct->{'Код'};
               $product->name = (string)$xmlProduct->{'Наименование'};
               $product->weight = (string)$xmlProduct->{'Вес'};

               if ($xmlProduct->{'Взаимозаменяемости'}->{'Взаимозаменяемость'} != null) {
                   foreach ($xmlProduct->{'Взаимозаменяемости'}->{'Взаимозаменяемость'} as $ability) {
                       $new_ability = new InterChangeAbility();

                       $new_ability->mark = $ability->{'Марка'};
                       $new_ability->model = $ability->{'Модель'};
                       $new_ability->category = $ability->{'КатегорияТС'};

                       $product->addInterchangeability($new_ability);
                   }
               }

               $arrayProductRepository->put($product);
           }
       }

       foreach ($offersXml->{'ПакетПредложений'}->{'Предложения'}->{'Предложение'} as $xmlOffer) {
           $product = $arrayProductRepository->get((int)$xmlOffer->{'Код'});

           if ($product !== null) {
               $product->addCityInfo($city_code, (string)$xmlOffer->{'Количество'}, (string)$xmlOffer->{'Цены'}->{'Цена'}[0]->{'ЦенаЗаЕдиницу'});
           }
       }
   }

   echo "Finished with parsing. Starting to insert.\n";

   MysqlProductRepository::addProducts($arrayProductRepository->getAll());