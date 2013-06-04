<?php

    $this->widget('zii.widgets.CMenu',array(
		'items'=>array(
			array('label'=>'На главную', 'url'=>'/'),
            array('label'=>'Категории', 'url'=>array('/category/admin')),
            array('label'=>'Анонсы', 'url'=>array('/announce/admin')),
            array('label'=>'Блог', 'url'=>array('/article/admin')),
            array('label'=>'Видео-курсы', 'url'=>array('/course/admin')),
            array('label'=>'Видеосессии', 'url'=>array('/lesson/admin')),
            array('label'=>'Пользователи', 'url'=>array('/user/admin/moderation')),
            array('label'=>'Промо-коды', 'url'=>array('/promoCode/admin')),
            //array('label'=>'Учебные материалы', 'url'=>array('/source/admin')),
            array('label'=>'Уведомления рассылки', 'url'=>array('/emailNotification/admin')),
            array('label'=>'Выход', 'url'=>array('/user/logout')),
        ),
	));
?>