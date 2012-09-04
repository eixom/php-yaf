--TEST--
Check for Yaf_Route_Simple::assemble
--SKIPIF--
<?php if (!extension_loaded("yaf")) print "skip"; ?>
--FILE--
<?php

$router = new Yaf_Router();

$route  = new Yaf_Route_Simple('m', 'c', 'a');

$router->addRoute("simple", $route);
echo 'assemble:';
echo assert("m=yafmodule&c=yafcontroller&a=yafaction&tkey1=tval1&tkey2=tval2" 
        == $router->getRoute('simple')
        ->assemble(
            array(
                'action'    => 'yafaction',
                'tkey' => 'tval',
                'controller'    => 'yafcontroller',
                'module'    => 'yafmodule'
                ),
            array(
                'tkey1' => 'tval1',
                'tkey2' => 'tval2'
                )
            ));

echo ',', assert("c=yafcontroller&a=yafaction" == $router->getRoute('simple')
        ->assemble(array(
                'action'    => 'yafaction',
                'tkey' => 'tval',
                'controller'    => 'yafcontroller',
                )
            )
        ), PHP_EOL;

echo 'assemble_exception:';
try{
    $router->getRoute('simple')
           ->assemble(array(
                'action'    => 'yafaction',
                'tkey' => 'tval',
                )
            );
    assert(0);
} catch(Exception $e){
    echo assert(strpos($e->getMessage(), 'controller') > 0);
}
 
try{
    $router->getRoute('simple')
           ->assemble(array(
                'tkey' => 'tval',
                'controller'    => 'yafcontroller',
                )
            );
    assert(0);
} catch(Exception $e){
    echo ',', assert(strpos($e->getMessage(), 'action') > 0);
}
 
?>
--EXPECT--
assemble:1,1
assemble_exception:1,1
