
<?php $container_id = (isset($feed_id)) ? $feed_id : 'feed_content'; ?>
<div id="<?=$container_id?>">
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
</div>

<?php if ($dataProvider->totalItemCount > $dataProvider->pagination->pageSize): ?>

    <p id="loading" style="display:none"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/loading.gif" alt="" /></p>
    <p class="showMore" style="cursor: pointer; margin-top: 20px; color: #0066CC;">Показать ещё</p>
 
    <script type="text/javascript">
    /*<![CDATA[*/
        (function($) {
            $('.paginator').hide();
            var page = <?php echo (int)Yii::app()->request->getParam('page', 1); ?>;
            var pageCount = <?php echo (int)$dataProvider->pagination->pageCount; ?>;
 
            var loadingFlag = false;
            var moreButton = $('#<?=$container_id?>').next().next('.showMore');
 
            moreButton.click(function()
            {
                if (!loadingFlag) {
                    loadingFlag = true;
                    $('#loading').show();
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
 
                            $('#loading').hide();
                            $('#<?=$container_id?>').append(data);
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
            })
        })(jQuery);
    /*]]>*/
    </script>
 
<?php endif; ?>