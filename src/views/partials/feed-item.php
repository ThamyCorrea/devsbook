<div class="box feed-item">
    <div class="box-body">
        <div class="feed-item-head row mt-20 m-width-20">
            <div class="feed-item-head-photo">
                <a href="<?=$base;?>"><img src="<?=$base;?>/media/avatars/<?=$data->usuario->fotoPerfil;?>" /></a>
            </div>
            <div class="feed-item-head-info">
                <a href=""><span class="fidi-name"><?=$data->usuario->nome;?></span></a>
                <span class="fidi-action"><?php
                switch($data->tipo){
                    case 'text':
                        echo 'Fez um post';
                        break;
                    case 'foto':
                        echo 'Postou uma foto';
                        break;  
                }
                ?></span>
                <br />
                <span class="fidi-date"><?=date('d/m/Y', strtotime($data->data_post));?></span>
            </div>
            <div class="feed-item-head-btn">
                <img src="<?=$base;?>/assets/images/more.png" />
            </div>
        </div>
        <div class="feed-item-body mt-10 m-width-20">
            <?=nl2br($data->body);?>
        </div>
        <div class="feed-item-buttons row mt-20 m-width-20">
            <div class="like-btn <?=($data->liked ? 'on' : '');?>"><?=$data->qntLike;?></div>
            <div class="msg-btn"><?=count($data->comentarios);?></div>
        </div>
        <div class="feed-item-comments">

            <!--
            <div class="fic-item row m-height-10 m-width-20">
                <div class="fic-item-photo">
                    <a href="<?=$base;?>"><img src="<?=$base;?>/media/avatars/<?=$data->usuario->fotoPerfil;?>" /></a>
                </div>
                <div class="fic-item-info">
                    <a href="">Bonieky Lacerda</a>
                    Comentando no meu próprio post
                </div>
            </div>
            -->

            <div class="fic-answer row m-height-10 m-width-20">
                <div class="fic-item-photo">
                    <a href="<?=$base;?>"><img src="<?=$base;?>/media/avatars/<?=$loginUsuario->fotoPerfil;?>" /></a>
                </div>
                <input type="text" class="fic-item-field" placeholder="Escreva um comentário" />
            </div>

        </div>
    </div>
</div>