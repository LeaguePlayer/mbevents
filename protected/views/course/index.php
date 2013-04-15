<?php
    $this->renderPartial('/site/_loop', array(
        'dataProvider'=>$dataProvider,
        'itemView'=>'/course/_view',
        'successAjaxLoad'=>"
            var manager = new PlayersManager;
            manager.initPlayersInHtml(data);
        ",
    ));
?>