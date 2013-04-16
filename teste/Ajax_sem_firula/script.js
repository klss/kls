// Método responsavel por criar o manipulador do Ajax
function objXMLHttp() 
{
    if (window.XMLHttpRequest)//Se for mozilla , safari...
    {
        var objXMLHttp = new XMLHttpRequest();//intancia o manipulador
        return objXMLHttp;//retorna o manipulador
    }
    else if (window.ActiveXObject) //Se for IE...
    {
        //seta vetor com versoes dos manipuladores do IE , na ordem decrescente de atualidade , ou seja 
        //os mais novos primeiro , para que na iteracao posterior o mais atual que der certo seja retornado.
        var versoes = ["MSXML2.XMLHttp.6.0",
        "MSXML2.XMLHttp.5.0",
        "MSXML2.XMLHttp.4.0",
        "MSXML2.XMLHttp.3.0",
        "MSXML2.XMLHttp",
        "Microsoft.XMLHttp"
        ];
        //Iteracao que verifica qual versao vai ser utilizada
        for (i =0 ; i< versoes.length; i++)
        {
            try
            {       
                var objXMLHttp = new ActiveXObject(versoes[i]);//intancia o manipulador
                return objXMLHttp;//retorna o manipulador e cai fora da funcao
            }
            catch(ex)
            {
            //nao faz nada, apenas deixa rolar a iteracao   
            }
            
        }
    }
    return false;//se nao conseguiu achar um objeto manipulador de ajax , retorna falso para parar por ai a brincadeira
}


function enviar_form(formulario){
    var dados = "departamento="+formulario.departamento.value;//pega o valor do campo departamento
    var oXMLHttp = objXMLHttp();// cria um objeto manipulador de ajax

    /*Atributos da assinatura da funcao 'open' do objeto manipulador de ajax chamado de oXMLHttp
     *oXMLHttp.open(string metodo,string url,boolean asynch);
     * metodo = se é GET ou POST
     * url = url do script que vai ser executado alguma requisicao do ajax.
     * async = true, caso seja uma conexao assincrona. false, caso seja sincrona.
     */

    oXMLHttp.open("POST","script_que_vai_tratar_requisicao_ajax.php", true);//indica como vai ser enviado o formulário

    /* Atributos da assinatura da funcao 'setRequestHeader' do objeto manipulador de ajax chamado de oXMLHttp
     * setRequestHeader(cabecalho, valor)
     * cabecalho = nome do cabecalho a ser adicionado
     * valor = respectivo valor que sera adicionado para este cabecalho 

     */   
    oXMLHttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    /*
     * Na linha de codigo acima estou dizendo o seguinte : 
     *"Quando um formulario for postado para o servidor, o Content-Type do mesmo deve ser application/x-www-form-urlencoded"
     * Porque application/x-www-form-urlencoded ? : 
     * Porque a maioria das linguagens de servidor utiliza essa codificacao para analisar os dados enviados para o mesmo. 
     */    
    function mensagem (msg)// esta funcao mostra uma mensagem no span de id='msg' da pagina index.html
    {
        document.getElementById('msg').innerHTML = msg;
    }
    oXMLHttp.onreadystatechange = function () //toda vez que o atributo 'onreadystatechange' mudar ...
    {
        /*Verifica o readyState :
         * NOTA sobre os valores do readyState :
         * 0 (Nao iniciado) - O objeto manipulador de ajax foi criado, no entanto o metodo open() ainda nao foi chamado
         * 1 (Carregando) - O metodo open() ja foi chamado, mas ainda nao foi enviado
         * 2 (Carregado) - O pedido foi enviado
         * 3 (Interativo) - Uma parte da resposta foi recebida
         * 4 (Completo) - Todos os dados da resposta foram recebidos e a conexao com o servidor foi fechada.
         */ 
        if (oXMLHttp.readyState == 4 ) //Se requisicao foi completamente retornada 
        {
            /* oXMLHttp.status , identifica qual o status da resposta recebida pela requisicao do servidor
             * Valores :200(ok) ou 404 (nao encontrado)
             */
            if (oXMLHttp.status == 200 ) // verifica se a resposta esta ok.
            {   

                /* NOTA sobre o atributo responseText
                 * Existe o atributo 'responseText' e o atributo 'responseXML', ambos sao uma resposta dada pelo servidor,
                 * mas existe uma diferenca entre os dois
                 * responseText = Resposta de texto simples , sem nenhuma formatacao
                 * responseXML  = Resposta em formato XML , requer um tratamento adicional. 
                 */         
                mensagem(oXMLHttp.responseText); //executa mensagem com a resposta simples retornada pelo servidor.
            }
            else
            {
                //Atributo statusText é uma string de texto com o status da resposta dada pelo servidor
                mensagem("Ocorreu o erro " + oXMLHttp.statusText); //executa funcao mensagem passando o statusText do erro.                
            }
        }
    };

    //envia os dados atraves do metodo send
    oXMLHttp.send(dados);
    //retorna false por causa da chamada do onSubmit do form1 que esta criado no arquivo index.html
    //retornando false garante que o formulario nao seja submetido.
    return false;
}



