<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
use dm\helpsystem\dmeditor\assets\DMEditorImageBrowseAsset;
DMEditorImageBrowseAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Digital Mesh Help System - Editor File Browser</title>
    <?php $this->head() ?>
</head>

<body>
<?php $this->beginBody() ?>

<?php print $content;?>

<?php  $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>