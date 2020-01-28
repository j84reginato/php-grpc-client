<?php

require dirname(__FILE__).'/vendor/autoload.php';

@include_once dirname(__FILE__).'/src/Protofile/GreeterClient.php';
@include_once dirname(__FILE__).'/src/Protofile/HelloReply.php';
@include_once dirname(__FILE__).'/src/Protofile/HelloRequest.php';
@include_once dirname(__FILE__).'/src/GPBMetadata/Protofile.php';

/**
 * @param $name
 *
 * @return mixed
 */
function greet($name)
{
    $client = new Protofile\GreeterClient('172.17.0.1:50051', [
        'credentials' => Grpc\ChannelCredentials::createInsecure(),
    ]);
    $request = new Protofile\HelloRequest();
    $request->setName($name);
    [$reply, $status] = $client->SayHello($request)->wait();
    $message = $reply->getMessage();
    // list($reply, $status) = $client->SayHelloAgain($request)->wait();
    // $message = $reply->getMessage();

    return $message;
}

$time = microtime(1);
$mem = memory_get_usage();

$name = !empty($argv[1]) ? $argv[1] : 'World';
echo greet($name)."\n";
echo 'Tempo: ', 1000 * (microtime(1) - $time), "ms\n";
echo 'Memória: ', (memory_get_usage() - $mem) / (1024 * 1024) . "\n";