<?php

if ( isset($_POST['departamento']) && $_POST['departamento'] )//Se foi passado o departamento por parametro
{
    $departamento = $_POST['departamento'];//Atribui para a variável $departamento
    echo $departamento; //Da um echo do departamento , que irá ser recebido no script.js , atributo do objeto oXMLHttp.responseText
}
else
{
    echo "Nada Foi passado !!!"; //Diz que não foi passado nada.  
}

?>
