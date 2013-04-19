
<?php $container_id = (isset($feed_id)) ? $feed_id : 'feed_content'; ?>
<section id="<?=$container_id?>">
    <? if ($totalCount!==null): ?>
        <div class="counter"><?=$totalCount;?></div>
    <? endif; ?>
    <?php
        $this->widget('zii.widgets.CListView', array(
            'dataProvider'=>$dataProvider,
            'itemView'=>$itemView,
            'ajaxUpdate'=>false,
            'template'=>"{items}\n{pager}",
            'pager' =>array(
                'header'=>'',
                'htmlOptions'=>array(
                    'class'=>'paginator'
                ),
            )
        ));
    ?>

<?php if ($dataProvider->totalItemCount > $dataProvider->pagination->pageSize): ?>

    <div class="progress">
		<img class="loop" src="/images/post_progress.gif" alt="">
		<a href="#more" class="showMore">Хочу еще!</a>
	</div>
 
    <script type="text/javascript">
    /*<![CDATA[*/
        (function($) {
            $('.paginator').hide();
            var page = <?php echo (int)Yii::app()->request->getParam('page', 1); ?>;
            var pageCount = <?php echo (int)$dataProvider->pagination->pageCount; ?>;
 
            var loadingFlag = false;
            var moreButton = $('#<?=$container_id?>').find('.showMore');
            var loader = $('#<?=$container_id?>').find('.loop').hide();
 
            moreButton.click(function()
            {
                if (!loadingFlag) {
                    loadingFlag = true;
                    loader.show();
                    $.ajax({
                        type: 'POST',
                        url: window.location.href,
                        data: {
                            'page': page + 1,
                            '<?php echo Yii::app()->request->csrfTokenName; ?>': '<?php echo Yii::app()->request->csrfToken; ?>'
                        },
                        success: function(data)
                        {
                            page++;                            
                            loadingFlag = false;                            
 
                            loader.hide();
                            moreButton.parents('.progress').before(data);
                            if (page >= pageCount)
                                moreButton.hide();
                            
                            <?php
                                if ( isset($successAjaxLoad) ) {
                                    echo CJavaScript::encode(new CJavaScriptExpression($successAjaxLoad), true);
                                }
                            ?>
                        }
                    });
                }
                return false;
            });
        })(jQuery);
    /*]]>*/
    </script>
 
<?php endif; ?>
</section>