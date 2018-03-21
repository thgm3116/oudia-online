<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
?>
<!DOCTYPE html>
<html>
<head>
    <?php echo $this->Html->charset() ?>
    <title>
        <?php echo $this->fetch('title') ?>
    </title>
    <?php echo $this->Html->meta('icon') ?>

    <?php echo $this->Html->css('base.css') ?>
    <?php echo $this->Html->css('cake.css') ?>

    <?php echo $this->fetch('meta') ?>
    <?php echo $this->fetch('css') ?>
    <?php echo $this->fetch('script') ?>
</head>
<body>
    <div id="container">
        <div id="header">
            <h1><?php echo __('Error') ?></h1>
        </div>
        <div id="content">
            <?php echo $this->Flash->render() ?>

            <?php echo $this->fetch('content') ?>
        </div>
        <div id="footer">
            <?php echo $this->Html->link(__('Back'), 'javascript:history.back()') ?>
        </div>
    </div>
</body>
</html>
