<?php
  return [
    'credential' => [
      'username' => env('BKASH_USERNAME'),
      'password' => env('BKASH_PASSWORD'),
    ],
    'checkout' => [
      'sandbox1' => [
        'baseUrl' => 'https://checkout.sandbox.bka.sh/v1.2.0-beta',
        'username' => 'sandboxTestUser',
        'password' => 'hWD@8vtzw0',
        'appKey' => '5tunt4masn6pv2hnvte1sb5n3j',
        'appSecret' => '1vggbqd4hqk9g96o9rrrp2jftvek578v7d2bnerim12a87dbrrka',
      ],
      'sandbox2' => [
        'baseUrl' => 'https://checkout.sandbox.bka.sh/v1.2.0-beta',
        'username' => 'testdemo',
        'password' => 'test%#de23@msdao',
        'appKey' => '5nej5keguopj928ekcj3dne8p',
        'appSecret' => '1honf6u1c56mqcivtc9ffl960slp4v2756jle5925nbooa46ch62',
      ],
      'production' => [
        'baseUrl' => 'https://checkout.pay.bka.sh/v1.2.0-beta',
        'username' => '01907888909',
        'password' => 'y$*A[4*N1ne',
        'appKey' => 'EXXlnOmp0fJ0HFyyFOwb6pltch',
        'appSecret' => '19oGSvSkHd2OmYOCu46913NLFIutiB5F31byt2PusYQTN4t4p3p6',
      ],
    ],
    'tokenized' => [
      'sandbox1' => [
        'baseUrl' => 'https://tokenized.sandbox.bka.sh/v1.2.0-beta',
        'username' => 'sandboxTokenizedUser01',
        'password' => 'sandboxTokenizedUser12345',
        'appKey' => '7epj60ddf7id0chhcm3vkejtab',
        'appSecret' => '18mvi27h9l38dtdv110rq5g603blk0fhh5hg46gfb27cp2rbs66f',
      ],
      'sandbox2' => [
        'baseUrl' => 'https://tokenized.sandbox.bka.sh/v1.2.0-beta',
        'username' => 'sandboxTokenizedUser02',
        'password' => 'sandboxTokenizedUser02@12345',
        'appKey' => '4f6o0cjiki2rfm34kfdadl1eqq',
        'appSecret' => '2is7hdktrekvrbljjh44ll3d9l1dtjo4pasmjvs5vl5qr3fug4b',
      ],
       'production' => [
        'baseUrl' => 'https://tokenized.pay.bka.sh/v1.2.0-beta',
        'username' => '01907888909',
        'password' => '-sNOg_4+L(m',
        'appKey' => 'pIwi4BGP0Eem169ajNdyvHpatc',
        'appSecret' => '2arsaoVqobouYQsH6Hgvk7zb9ueDfPjcsNzKe02yEnJUFJqV731M',
      ],
    ],
  ];
?>
