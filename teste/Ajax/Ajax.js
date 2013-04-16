/** 		
 * 	Nome: myAjax 2.0
 *	Autor: Henrique J. P. Barcelos
 *	Data: 08/11/2009
 
 * 	Este código é livre: você pode redistribuí-lo e/ou modificá-lo
 	sob os termos da GNU General Public License (GPL) como foi publicada pela
 	Free Software Foundation, tanto na versão 3 da Licença, ou
 	(a seu gosto) qualquer versão posterior.

 * 	Este código é distribuido na esperança que ele seja útil,
 	mas SEM QUALQUER GARANTIA.
 
 *	Veja GNU General Public License para mais detalhes.
 	http://www.gnu.org/licenses/gpl.html
 */

var Ajax = function(preferences){
    this.complete = null; //Função ou Array de funções para executar após o carregamento da página
    this.contentLoading = "Carregando..."; //Texto exibido enquanto a página carrega
    this.headers = new Array(); //Headers da requisição HTTP
    this.HTMLObject = null; //objeto HTML que vai receber a resposta da requisição
    this.method = "GET"; //Método da requisição HTTP [GET ou POST]
    this.mode = "TEXT"; //Modo de resposta ['TEXT' = Texto, 'XML' = XML, 'JSON' = JSON]
    this.page = null; //página para a requisição
    this.params = null; //parâmetros passados pela requisição (query string), obrigatório caso o método seja POST
    this.showLoading = true; //Opção de exibir "Carregando" na tela
    this.showResponse = true; //Opção de exibir a resposta no conteúdo do elemento
    this.xmlHttpRequest = null; //variável que vai receber o objeto XMLxmlHttpRequest
	
    //Fazendo as configuracoes
    this.config(preferences);
};

Ajax.prototype = {
    //customização da chamada da função 
    config: function(preferences){
        if (typeof preferences == "object") {
            for (atributo in preferences) {
                if (atributo in this) {
                    this["" + atributo.toString() + ""] = preferences[atributo];
                }
            }
        }
    },
	
    //inicialização do objeto XMLxmlHttpRequest
    init: function(){
        //cria o objeto XMLxmlHttpRequest pra Firefox, Chrome, Opera, Safari, etc.
        try {
            this.xmlHttpRequest = new XMLHttpRequest();
        } 
		
        //cria o objeto XMLHttpRequest pra IE 6.0 e posteriormente para IE7+
        catch (e) {
            try {
                this.xmlHttpRequest = new ActiveXObject("Msxml2.XMLHTTP");
            } 
			
            catch (e) {
                this.xmlHttpRequest = new ActiveXObject("Microsoft.XMLHTTP");
            }
        }
		
    },
	
    //Envia os headers da requisição
    setHeaders: function(){
        if (this.headers != null) {
            for (var i = 0; i < this.headers.length; i++) {
                var header = this.headers[i].header;
                var value = this.headers[i].value;
                this.xmlHttpRequest.setRequestHeader(header, value);
            }
        }
    },
	
    //Faz uma requisição
    load: function(page, element){
        this.init();
        this.page = page;
		
        this.xmlHttpRequest.open(this.method, page, true);
		
        //Se o método for POST, é necessário o header Content-Type, adicionado ao array headers aqui...
        if (this.method == "POST") {
            if (this.params == null) {
                Ajax.handExceptions("config", "Faltam os parâmetros da requisição POST!");
            }
            this.headers.push({
                header: "Content-Type",
                value: "application/x-www-form-urlencoded"
            });
        }
		
        this.setHeaders();
        this.xmlHttpRequest.send(this.params);
		
        if (element) {
            if (typeof element == "string") {
                this.HTMLObject = document.getElementById(element);
            }
            else {
                this.HTMLObject = element;
            }
        }
        else {
            this.showResponse = false;
        }
		
        var obj = this;
		
        this.xmlHttpRequest.onreadystatechange = function(){
            obj.stateChange.call(obj);
        }
    },
	
    //Método chamado quando a requisição muda de estado
    stateChange: function(){
        if (this.xmlHttpRequest.readyState == 4) {
            this.loading(false);
            if (this.xmlHttpRequest.status == 200) {
                if (this.showResponse) {
                    this.loadResponse();
                }
                this.callFunctions();
            }
            else {
                Ajax.handExceptions("request", this.xmlHttpRequest.status);
            }
        }
        else {
            if (this.showLoading) this.loading(true);
        }
		
    },
	
    loading: function(opt){
        //Exibe o loading na tela
        if (opt) {
            var tagBody = document.getElementsByTagName("body")[0];
            var divLoading = document.getElementById("myAjaxLoading");
            if (!divLoading) {
                divLoading = document.createElement("div");
                divLoading.setAttribute("id", "myAjaxLoading");
                divLoading.innerHTML = this.contentLoading;
                tagBody.insertBefore(divLoading, tagBody.firstChild);
            }
        }
        //Remove o loading da tela
        else {
            setTimeout(function(){
                var divLoading = document.getElementById("myAjaxLoading");
                if (divLoading) {
                    divLoading.parentNode.removeChild(divLoading);
                }
            }, 500);
        }
    },
	
    //Exibe a resposta
    loadResponse: function(){
        var response = null;
        if (this.showResponse) {
            switch (this.mode.toUpperCase()) {
                case "TEXT":
                    response = this.getText();
                    break;
                case "JSON":
                    break;
                case "XML":
                    break;
                default:
                    Ajax.handExceptions("config", "Modo Inválido! Deve ser \"TEXT\" ou \"XML\"");
            }
            if (response) {
                if (this.HTMLObject) {
                    if (this.HTMLObject.nodeName == "INPUT" || this.HTMLObject.nodeName == "OPTION") {
                        this.HTMLObject.value = response;
                    }
                    else {
                        this.HTMLObject.innerHTML = response;
                    }
                }
                else {
                    Ajax.handExceptions("DOM", "Elemento inválido ou inexistente!");
                }
            }
        }
    },
	
    //Faz a chamada das funções quando a requisição for completada
    callFunctions: function(){
        var complete = this.complete;
        if (complete != null) {
            if (typeof complete == "object") {
                for (var i = 0; i < complete.length; i++) {
                    if (typeof complete[i] == "function") {
                        complete[i].call(this);
                    }
                    else {
                        Ajax.handExceptions("DOM", "Função Inválida!");
                    }
                }
            }
            else if (typeof complete == "function") {
                complete.call(this);
            }
            else {
                Ajax.handExceptions("DOM", "Função inválida ou inexistente!");
            }
        }
    },
	
    getXML: function(){
        return this.xmlHttpRequest.responseXML;
    },
	
    getText: function(){
        return this.xmlHttpRequest.responseText;
    },
	
    abort: function(){
        this.xmlHttpRequest.abort();
        return false;
    }
};

//Tratamento de Exceções
//Obs.: Não quero que este método seja acessado fora da classe, então eu o declaro como privado (fora do prototype)
Ajax.handExceptions = function(type, error){
    if (type == undefined) type = "request";
    if (error == undefined) error = "Erro desconhecido!";
	
    switch (type) {
        case "request":
            switch (error) {
                case 400:
                    throw new Error("Erro #400: Bad Request!");
                    break;
                case 403:
                    throw new Error("Erro #403: Acesso proibido!");
                    break;
                case 404:
                    throw new Error("Erro #404: Arquivo não encontrado!");
                    break;
                case 408:
                    throw new Error("Erro #408: Atingiu o tempo limite de conexão!");
                    break;
                case 500:
                    throw new Error("Erro #500: Internal Server new Error!");
                    break;
                case 504:
                    throw new Error("Erro #504: Gateway offline!");
                    break;
                default:
                    throw new Error("Erro de requisição desconhecido!");
                    break;
            }
            break;
			
        case "DOM":
            throw new Error("Erro DOM: " + error);
            break;
			
        case "config":
            throw new Error("Error de configuração: " + error);
            break;
			
        default:
            throw new Error("Erro desconhecido!");
    }
}