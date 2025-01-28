<?php


function formatetoile($nbEtoile) {
    $nbEtoile = max(0, min(5, $nbEtoile));

    $etoilesDorees = str_repeat('★', $nbEtoile);

    $etoilesVides = str_repeat('☆', 5 - $nbEtoile);

    return '<span class="colorEtoile">' . $etoilesDorees . '</span>' . $etoilesVides;
}