DIDIMO SMS - Web API
=========================

Clase para enviar sms con la plataforma DIDIMO


## Requerimientos mínimos

PHP 5.4.0 or superior

## Créditos

Clase creada por Eduardo Díaz, Madrid 2017

Twitter: @eduardo_dx


## Instalación y uso

### Vía Composer
```bash
composer require didimo/sms
```

## ¿Cómo usar la clase?

### Enviar un sms

```php
include_once('vendor/autoload.php');

use Didimo\Sms\Sms;

$sms = new Sms('USER','PASSWORD');
//Enviar sms desde producción
$sms->setEnviroment('live'); 

$response = $sms->createMessage('Prueba','34666666666','Esto es una prueba');
if($response->Status == 200) {
    if($response->ResponseCode == 0 && $response->ResponseMessage == 'Operation Success') {
        echo 'Enviado correctamnete';
    }
    else {
        echo 'Error, no se pudo enviar el sms';
    }
}
else {
    print_r($response);
}

```
> Tener en cuenta que para enviar sms de pruebas, tenéis que contactar por vuestro proveedor para que os de de alta. Bastará con cambiar setEnviorement a test

```php
$sms->setEnviroment('test'); 
```

> Nota: Podemos pasar un tercer parámetro para programar el envío del sms, dicho valor tiene que tener el siguiente formato Y-m-d\TH:i:s.

```php
    $now = date('Y-m-d H:i:s');
    $newdate = date('Y-m-d\TH:i:s', strtotime('+1 hour', strtotime($now)));
    $sms->createMessage('Prueba','34666666666','Mensaje con scheduler',$newdate);
```


#### Response

```php
stdClass Object
(
    [ResponseCode] => 0
    [ResponseMessage] => Operation Success
    [Id] => cb303162-ee35-4357-98xc-90025a69da00
    [Status] => 200
)
```


### Realizar un envío de 1 o varios mensajes en una sola llamada

```php
include_once('vendor/autoload.php');

use Didimo\Sms\Sms;

$sms = new Sms('USER','PASSWORD');
//Enviar sms desde producción
$sms->setEnviroment('live'); 

$messages = ['0034666666666' => 'Mensaje personalizado', '0034777777777' => 'Otro mensaje personalizado'];
$response = $sms->createSend('Prueba',$messages);

if($response->Status == 200) {
    if($response->ResponseCode == 0 && $response->ResponseMessage == 'Operation Success') {
        echo 'Enviado correctamente';        
    }
    else {
        echo 'Error, no se pudo enviar el sms'.;
        
    }
}
else {
    print_r($response);
}

```

> Nota: También podemos aplicar un envío programado del sms, como comentamos en el punto anterior.

#### Response

```php
stdClass Object
(
    [ResponseCode] => 0
    [ResponseMessage] => Operation Success
    [Output] => Array
        (
            [0] => stdClass Object
                (
                    [ResponseCode] => 0
                    [ResponseMessage] => Operation Success
                    [Id] => b9d4e771-82e7-40b0-a338-26653a4scf3h
                    [Mobile] => 0034666666666
                    [Text] => Mensaje personalizado
                )

            [1] => stdClass Object
                (
                    [ResponseCode] => 0
                    [ResponseMessage] => Operation Success
                    [Id] => 51423261-0a9c-41c6-8139-a097304aa240
                    [Mobile] => 0034777777777
                    [Text] => Otro mensaje personalizado
                )

        )
    [Status] => 200
)

```

### Consultar el estado de un mensaje
```php
include_once('vendor/autoload.php');

use Didimo\Sms\Sms;

$sms = new Sms('USER','PASSWORD');

//Consultar en producción
$sms->setEnviroment('live'); 

$id='c366018b-97ba-4a78-8183-0d975bd2620b';
$response = $sms->getMessageStatus($id);
if($response->Status == 200) {
    if($response->ResponseCode == 0 && $response->ResponseMessage == 'Operation Success') {
        echo "Estatus: ".$response->StatusDescription;        
    }
    else {
        echo 'Error al obtener estatus';
    }
}
else{
    print_r($response);
}


```

#### Response
```php
stdClass Object
(
    [ResponseCode] => 0
    [ResponseMessage] => Operation Success
    [StatusCode] => PT0001
    [StatusDescription] => Pendiente - En Bandeja de Salida
    [Status] => 200

)

```


### Consultar saldo disponible para enviar SMS

```php
include_once('vendor/autoload.php');

use Didimo\Sms\Sms;

$sms = new Sms('USER','PASSWORD');

//Consultar en producción
$sms->setEnviroment('live'); 

$response = $sms->getCredits();

if($response->Status == 200) {
    if($response->ResponseCode == 0 && $response->ResponseMessage == 'Operation Success') {
        echo "Total saldo: ".$response->Credits;        
    }
    else {
        echo 'Error al obtener saldo';
    }
}
else {
    print_r($response);
}

```

#### Response
```php
stdClass Object
(
    [ResponseCode] => 0
    [ResponseMessage] => Operation Success
    [Credits] => 8000
    [Status] => 200
)

```
## Documentación oficial
[Web API Didimo SMS - Manual de Integracion](https://goo.gl/j0yKRP)


## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information about what has changed recently.

## Licencia

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Donación

¿Te gustaría apoyarme?
¿Aprecias mi trabajo?
¿Lo usas en proyectos comerciales?

¡Siéntete libre de hacer una pequeña [donación](https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=ssh%2eeduardo%40gmail%2ecom&lc=ES&currency_code=EUR&bn=PP%2dDonationsBF%3abtn_donate_LG%2egif%3aNonHosted)! :wink:
