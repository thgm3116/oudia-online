<div ckass="container">
    <div class="row">
        <div class="col-sm-12">
            <h1><?php echo $h1; ?></h1>
        </div>
        <div class="col-sm-12"><hr></div>
        <div class="col-sm-12">
            <div>ファイル名 : <?php echo $dia_file['filename'];?></div>
            <div>路線名 : <?php echo (empty($dia_file['linename'])) ? '(路線名なし)' : $dia_file['linename'] ;?></div>
        </div>
        <div class="col-sm-12"><hr></div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h2>
                <?php echo $station_name; ?>
                (<?php echo $distance_japanese; ?> / <?php echo $dia_group_name; ?>)
            </h2>
        </div>
        <div class="col-sm-12"><hr></div>
        <div class="col-sm-12">
            <h3>
                <?php
                    echo $this->Html->link(
                        $opposite_distance_japanese . 'の駅時刻表を見る',
                        [
                            'controller' => 'Dia',
                            'action' => 'viewStation',
                            'dia_group_id' => $dia_group_id,
                            'distance' => $opposite_distance,
                            'station_id' => $station_id,
                        ]
                    );
                ?>
            </h3>
        </div>
        <div class="col-sm-12">
            <table class="table table-condensed table-bordered table-striped" style="table-layout:fixed;">
                <th class="info" style="width:28px;">時</th>
                <th class="info" colspan="<?php echo $max_train_number; ?>">ダイヤ</th>
                <?php foreach ($dia_in_hour_array as $hour => $dia_array): ?>
                <tr>
                    <th class="warning text-right" style="width:28px;"><?php echo $hour; ?></th>
                    <?php foreach($dia_array as $dia): ?>
                        <td>
                            <div class="text-left text-nowrap">
                                <?php if (!empty($dia['departureTime'])): ?>
                                    <a href="<?php echo $this->Url->build([
                                        'controller' => 'Dia',
                                        'action' => 'viewTrain',
                                        'dia_group_id' => $dia_group_id,
                                        'distance' => $distance,
                                        'train_id' => $dia['train']['id'],
                                    ]); ?>">
                                <?php endif;?>
                                    <?php echo substr($dia['departureTime'], -2); ?>
                                    <?php if (!empty($dia['train']['train_type']['shortName'])): ?>
                                        ＜<?php echo $dia['train']['train_type']['shortName']; ?>＞
                                    <?php endif;?>
                                    <?php if (!empty($dia['isFirstDia']) && $dia['isFirstDia'] === true): ?>
                                        ●
                                    <?php endif; ?>
                                <?php if(!empty($dia['departureTime'])): ?>
                                </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    <?php endforeach; ?>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>
