
<div id="video-<?=$model->id?>"></div>

<script type="text/javascript">
    $(document).ready(function() {
        jwplayer("video-<?=$model->id?>").setup({
            file: "<?=$model->video_source?>",
            image: "<?=Yii::app()->getBaseUrl().$model->photo_source; ?>"
        });
    });
</script>

<div class="description">
    <?php echo $model->description; ?>
</div>