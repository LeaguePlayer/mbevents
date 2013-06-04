
<div class="white-box">
    <div class="reviews">
        <h2>Отзывы клиентов</h2>
        <div id="review-slider">
            <div class="slider-box">
                <ul class="slider" id="slider-for-review">
                    <?
                        foreach($model->getReviews() as $review) {
                            echo '<li>';
                            $this->renderPartial('_review', array('model'=>$review));
                            echo '</li>';
                        }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>