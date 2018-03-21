<!DOCTYPE html>
<html>
<head>
    <?php echo $this->Html->charset(); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <?php echo $this->Html->meta('icon'); ?>

    <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>

    <?php echo $this->Html->css('/bootstrap/css/bootstrap.css'); ?>
    <?php echo $this->Html->script('/bootstrap/js/bootstrap.js'); ?>
</head>
<body>
    <div class="container clearfix">
        <?php echo $this->element('menu_top'); ?>
        <?php echo $this->fetch('content'); ?>
        <?php echo $this->element('footer'); ?>
    </div>
</body>
</html>
