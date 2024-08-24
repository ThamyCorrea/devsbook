<?=$render('header', ['loginUsuario'=>$loginUsuario]); ?>

<section class="container main">
    <?= $render('sidebar', ['activeMenu'=>'home']); ?>
    
    <section class="feed mt-10">

        <div class="row">
            <div class="column pr-5">

                
            <?=$render('feed-editor', ['usuario'=>$loginUsuario]);?>

            <?php foreach($feed['posts'] as $feedItem): ?>
                <?=$render('feed-item', [
                    'data' => $feedItem,
                    'loginUsuario' => $loginUsuario
                ]);?>
            <?php endforeach; ?>

            <div class="feed-pagination">
                <?php for($q=0;$q<$feed['totalPagina'];$q++): ?>
                    <a class="<?=($q==$feed['currentPage'] ? 'active' : '' );?>"href="<?=$base;?>/?page=<?=$q;?>"><?=$q+1;?></a>                
                <?php endfor;?>
            </div>            

            </div>
            <div class="column side pl-5">
                <div class="box banners">
                    <div class="box-header">
                        <div class="box-header-text">Patrocinios</div>
                        <div class="box-header-buttons">

                        </div>
                    </div>
                    <div class="box-body">
                        <a href=""><img src="data:image/jpeg;base64,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" /></a>
                        <a href=""><img src="https://www2.decom.ufop.br/imobilis/wp-content/uploads/2015/03/php-elephant.png" /></a>
                    </div>
                </div>
                <div class="box">
                    <div class="box-body m-10">
                        Criado com ❤️ por B7Web
                    </div>
                </div>
            </div>
        </div>

    </section>
</section>
<?= $render('footer'); ?>