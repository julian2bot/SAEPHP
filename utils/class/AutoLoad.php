<?php
    spl_autoload_register(static function(string $fqcn) {
    // $fqcn contient Model\Thread\Message par exemple
    // remplaçons les \ par des / et ajoutons .php à la fin.
    // on obtient Model/Thread/Message.php
    $path = str_replace('\\', '/', $fqcn).'.php';
    // echo __DIR__."/../../$path";

    // puis chargeons le fichier
    // echo __DIR__."./".''.$path.'';
    require_once(__DIR__."/../../".$path);
    });

?>