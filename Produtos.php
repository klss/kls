<?php
define("PATH", "");
require('lib/aplicacao.php');
$link = '<link rel="stylesheet" href="css/produtos.css" type="text/css" />';
$titulo = "Produtos";
Template::exibe_cabecalho($titulo, $link);
?>
<div class="container">
    <div class="slider">
        <ul class="screen">
            <li>
                <a id='show-modal' href='javascript:;'>
                    <div class="module yellow double img w">
                        <h2 class="title">X-Bacon</h2>
                        <p class="sub-heading">Uma mordida do paraiso.</p>
                    </div>
                </a>
                <a id='show-modal' href='javascript:;'>
                    <div class="module yellow double img w">
                        <h2 class="title">X-Bacon</h2>
                        <p class="sub-heading">Uma mordida do paraiso.</p>
                    </div>
                </a>
            </li>

            <li>
            </li>

            <li>
            </li>
        </ul>
    </div>
    <div id="screen-nav">
        <button data-dir="prev"><</button>
        <button data-dir="next">></button>
    </div>
    <div class='notice'>
        <h2>Atenção</h2>
        <p>Aqui você pode exibir alguma mensagem importante, que ela irá
            sobrepor todo o conteúdo do seu site.</p>
        <p>Aqui você pode exibir alguma mensagem importante, que ela irá
            sobrepor todo o conteúdo do seu site.</p>
        <p>Aqui você pode exibir alguma mensagem importante, que ela irá
            sobrepor todo o conteúdo do seu site.</p>
        <p>Aqui você pode exibir alguma mensagem importante, que ela irá
            sobrepor todo o conteúdo do seu site.</p>
        <p>Aqui você pode exibir alguma mensagem importante, que ela irá
            sobrepor todo o conteúdo do seu site.</p>
        <p>Aqui você pode exibir alguma mensagem importante, que ela irá
            sobrepor todo o conteúdo do seu site.</p>
        <a href='javascript:;' class='close'>Fechar</a>
    </div>
    <div class='overlay'></div>

    <script>
        $('#show-modal').on('click', function() {
            $('.overlay, .notice').show();
        });
        $('.overlay, .close').on('click', function() {
            $('.overlay, .notice').hide();
        });
    </script>

    <script>
        (function(){

            var sliderUL = $('div.slider').children('ul'),
            screens = sliderUL.find('li'),
            screenWidth = screens.width(), 
            screenLength = screens.length, 
            current = 1,
            totalScreenWidth = screenLength * screenWidth;

            var h1 = $('div.header').children('h1');

            $('#screen-nav').find('button').on('click', function() {
                var direction = $(this).data('dir'),
                loc = screenWidth;

                (direction === 'next') ? ++current : --current;

                if(current === 0) {
                    current = screenLength;
                    loc = totalScreenWidth - screenWidth;
                    direction = 'next';
                } else if (current - 1 === screenLength) { 
                    current = 1;
                    loc = 0;
                }

                transition(sliderUL, loc, direction);

            });

            function transition(container, loc, direction) {
                var unit; 

                if(direction && loc !== 0) {
                    unit = (direction === 'next') ? '-=' : '+=';
                }

                container.animate({
                    'margin-left': unit ? (unit + loc) : loc 
                });
            }

        })();
    </script>
</div>
<?php
Template::exibe_rodape();
?>
