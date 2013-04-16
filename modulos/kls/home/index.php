<?php
KLS::check_access('kls.home');
try {
    THome::exibe_cabecalho();
} catch (Exception $e) {
    Template::display_exception($e);
}
?>