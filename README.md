# helper-simple-xml
Класс для преобразования php массива в SimpleXmlElement или в XML структуру

# Пример использования

## Получение объекта SimpleXmlElement
~~~
$data = [
    'request' => [
        '@attributes' => [
            'date' => '25.12.2015',
            'type' => 'get_code'
        ],
    ],
    'phone'   => '+79992223344',
    'code'    => '1234'
];
$xml = HelperSimpleXml::array2xml($data);
~~~

## Получение красивого xml
действует по аналогии JSON флага JSON_PRETTY_PRINT
~~~
$data = [
    'request' => [
        '@attributes' => [
            'date' => '25.12.2015',
            'type' => 'get_code'
        ],
    ],
    'phone'   => '+79992223344',
    'code'    => '1234'
];
$xml = HelperSimpleXml::array2BeautyXml($data);
~~~

## В результате получим xml:
~~~
<?xml version="1.0" encoding="UTF-8"?>
<root>
  <request date="25.12.2015" type="get_code"/>
  <phone>+79992223344</phone>
  <code>1234</code>
</root>
~~~

## Преобразование объекта SimpleXmlElement в красивый xml
~~~
$beautyXml = HelperSimpleXml::beautyXml($xml_element);
~~~