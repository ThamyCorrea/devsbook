<?= $render('header', ['loginUsuario' => $loginUsuario]); ?>

<section class="container main">
    <?= $render('sidebar', ['activeMenu'=>'profile']); ?>

    <section class="feed">

        <div class="row">
            <div class="box flex-1 border-top-flat">
                <div class="box-body">
                    <div class="profile-cover" style="background-image: url('<?=$base;?>/media/covers/<?=$usuario->fotoCapa;?>');"></div>
                    <div class="profile-info m-20 row">
                        <div class="profile-info-avatar">
                            <img src="<?=$base;?>/media/avatars/<?=$usuario->fotoPerfil;?>" />
                        </div>
                        <div class="profile-info-name">
                            <div class="profile-info-name-text"><?=$usuario->nome;?></div>
                            <div class="profile-info-location"><?=$usuario->cidade;?></div>
                        </div>
                        <div class="profile-info-data row">
                            <div class="profile-info-item m-width-20">
                                <div class="profile-info-item-n"><?=count($usuario->seguidores);?></div>
                                <div class="profile-info-item-s">Seguidores</div>
                            </div>
                            <div class="profile-info-item m-width-20">
                                <div class="profile-info-item-n"><?=count($usuario->seguindo);?></div>
                                <div class="profile-info-item-s">Seguindo</div>
                            </div>
                            <div class="profile-info-item m-width-20">
                                <div class="profile-info-item-n"><?=count($usuario->fotos);?></div>
                                <div class="profile-info-item-s">Fotos</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="column side pr-5">

                <div class="box">
                    <div class="box-body">

                        <div class="user-info-mini">
                            <img src="<?=$base;?>/assets/images/calendar.png" />
                            <?=date('d/m/Y', strtotime($usuario->datanasc));?> (<?=$usuario->idade;?> anos)
                        </div>
                        
                        <?php if(!empty($usuario->cidade)):?>
                        <div class="user-info-mini">
                            <img src="<?=$base;?>/assets/images/pin.png" />
                            <?=$usuario->cidade;?>
                        </div>
                        <?php endif;?>
                        
                        <?php if(!empty($usuario->trabalho)):?>
                        <div class="user-info-mini">
                            <img src="<?=$base;?>/assets/images/work.png" />
                            <?=$usuario->trabalho;?>
                        </div>
                        <?php endif;?>

                    </div>
                </div>

                <div class="box">
                    <div class="box-header m-10">
                        <div class="box-header-text">
                            Seguindo
                            <span>(<?=count($usuario->seguindo);?>)</span>
                        </div>
                        <div class="box-header-buttons">
                            <a href="">ver todos</a>
                        </div>
                    </div>
                    <div class="box-body friend-list">
                    
                        <?php for($q=0;$q<9;$q++):?>
                            <?php if(isset($usuario->seguindo[$q])): ?>
                                
                                <div class="friend-icon">
                                    <a href="<?=$base;?>/perfil/<?=$usuario->seguindo[$q]->id;?>">
                                        <div class="friend-icon-avatar">
                                            <img src="<?$base;?>/media/avatars/<?=$usuario->seguindo[$q]->fotoPerfil;?>" />
                                        </div>
                                        <div class="friend-icon-name">
                                        <?=$usuario->seguindo[$q]->nome;?>
                                        </div>
                                    </a>
                                </div>
                            <?php endif;?>
                        <?php endfor;?>                       
                       
                    </div>
                </div>

            </div>
            <div class="column pl-5">

                <div class="box">
                    <div class="box-header m-10">
                        <div class="box-header-text">
                            Fotos
                            <span>(<?=count($usuario->fotos);?>)</span>
                        </div>
                        <div class="box-header-buttons">
                            <a href="">ver todos</a>
                        </div>
                    </div>
                    <div class="box-body row m-20">

                        <?php for($q=0;$q<4;$q++):?>
                            <?php if(isset($usuario->fotos[$q])) : ?>
                                <div class="user-photo-item">
                                    <a href="#modal-1<?=$usuario->fotos[$q]->id;?>" rel="modal:open">
                                        <img src="<?=$base;?>/media/uploads/<?=$usuario->fotos[$q]->body;?>" />
                                    </a>
                                    <div id="modal-1<?=$usuario->fotos[$q]->id;?>" style="display:none">
                                    <img src="<?=$base;?>/media/uploads/<?=$usuario->fotos[$q]->body;?>" />
                                    </div>
                                </div>
                            <?php endif;?>  
                        <?php endfor;?>

                     </div>
                </div>
                
                <?php if($usuario->id == $loginUsuario->id) :?>
                    <?=$render('feed-editor', ['usuario'=>$loginUsuario]);?>
                <?php endif;?>                
               
                <?php foreach($feed['posts'] as $feedItem): ?>
                <?=$render('feed-item', [
                    'data' => $feedItem,
                    'loginUsuario' => $loginUsuario
                ]);?>
            <?php endforeach; ?>

            <div class="feed-pagination">
                <?php for($q=0;$q<$feed['totalPagina'];$q++): ?>
                    <a class="<?=($q==$feed['currentPage'] ? 'active' : '' );?>"href="<?=$base;?>/perfil/<?=$usuario->id;?>?page=<?=$q;?>"><?=$q+1;?></a>                
                <?php endfor;?>
            </div>            
            </div>

        </div>

    </section>

</section>
<?= $render('footer'); ?>