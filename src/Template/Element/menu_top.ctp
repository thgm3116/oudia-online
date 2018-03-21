
<header>
    <div class="container">
        <hr>
        <div class="row">
            <div class="col-sm-12">
                <p>
                    
                </p>
            </div>
        </div>
    </div>
</header>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li>
                    <?php 
                    echo $this->Html->link(
                            'Top',
                            [
                                'controller' => 'Dia',
                                'action' => 'index',
                            ]
                        );
                    ?>
                </li>
                <?php if($is_dia_view_link_enabled === true): ?>
                <li>
                    <?php 
                    echo $this->Html->link(
                            'DiaTop',
                            [
                                'controller' => 'Dia',
                                'action' => 'viewDefault',
                                'dia_group_id' => $dia_group_id,
                                'distance' => $distance,
                            ]
                        );
                    ?>
                </li>
                <?php endif; ?>
                <li>
                    <?php 
                    echo $this->Html->link(
                            'Info',
                            [
                                'controller' => 'Info',
                                'action' => 'index',
                            ]
                        );
                    ?>
                </li>
            </ul>
        </div>
    </div>
</nav>