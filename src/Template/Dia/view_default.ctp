
<div ckass="container">
    <div class="row">
        <div class="col-sm-12">
            <h1><?php echo $h1; ?></h1>
        </div>
        <div class="col-sm-12"><hr></div>
        <div class="col-sm-12">
            <div>ファイル名 : <?php echo $dia_file['filename'];?></div>
            <div>路線名 : <?php echo (empty($dia_file['linename'])) ? '(路線名なし)' : $dia_file['linename'] ;?></div>
            <div>ダイヤ名 : <?php echo $dia_group_name; ?></div>
            <div>方向 : <?php echo $distance_japanese; ?></div>
        </div>
        <div class="col-sm-12"><hr></div>
        <div class="col-sm-12">
            <h3>
                <?php
                    echo $this->Html->link(
                        $opposite_distance_japanese . 'の時刻表を見る',
                        [
                            'controller' => 'Dia',
                            'action' => 'viewDefault',
                            'dia_group_id' => $dia_group_id,
                            'distance' => $opposite_distance
                        ]
                    );
                ?>
            </h3>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <table class="table table-condensed table-bordered table-striped">
                <tr>
                    <th><div class="text-nowrap">駅名</div></th>
                    <?php foreach($dia_and_trains as $dia_and_train): ?>
                        <td class="text-center text-nowrap">
                            <?php echo $dia_and_train['train_type']['shortName']; ?>
                        </td>
                    <?php endforeach; ?>
                </tr>
                <?php $station_key = 1; ?>
                <?php foreach($stations as $key => $station): ?>
                    <tr>
                        <th>
                            <div class="text-nowrap">
                                <?php if ($station_key === count($stations)): ?>
                                    <?php echo $station->name; ?>
                                <?php else: ?>
                                    <?php echo $this->Html->link(
                                        $station->name,
                                        [
                                            'controller' => 'Dia',
                                            'action' => 'viewStation',
                                            'dia_group_id' => $dia_group_id,
                                            'distance' => $distance,
                                            'station_id' => $station['id'],
                                        ]
                                    ); ?>
                                <?php endif; ?>
                                <?php $station_key++;?>
                            </div>
                        <?php if($station['type'] === 'Jikokukeisiki_Hatsuchaku'): ?>
                            <div class="text-nowrap">(着 / 発)</div>
                        <?php endif; ?>
                        </th>
                        <?php foreach($dia_and_trains as $dia_and_train): ?>
                            <td class="text-center">
                                <?php if (empty($dia_and_train->dia[$key]->departureTime)): ?>
                                    <?php if (!empty($dia_and_train->dia[$key]->arrivalTime)): ?>
                                        <div><?php echo $dia_and_train->dia[$key]->arrivalTime; ?></div>
                                    <?php elseif (!empty($dia_and_train->dia[$key - 1]->departureTime) && $stations[$key - 1]['type'] !== 'Jikokukeisiki_Hatsuchaku'): ?>
                                        ===
                                    <?php else: ?>
                                        <?php if($station['type'] === 'Jikokukeisiki_Hatsuchaku'): ?>
                                            <div class="text-nowrap">----</div>
                                            <hr style="margin-top:0px;margin-bottom:0px;">
                                            <div class="text-nowrap">----</div>
                                        <?php else: ?>
                                            <div class="text-nowrap">----</div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php elseif ($dia_and_train->dia[$key]->departureTime === '2'): ?>
                                    <?php if($station['type'] === 'Jikokukeisiki_Hatsuchaku'): ?>
                                        <div class="text-nowrap">ﾚ</div>
                                        <hr style="margin-top:0px;margin-bottom:0px;">
                                        <div class="text-nowrap">ﾚ</div>
                                    <?php else: ?>
                                        <div class="text-nowrap">ﾚ</div>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <?php if ($station['type'] === 'Jikokukeisiki_Hatsuchaku'): ?>
                                        <?php if (!empty($dia_and_train->dia[$key]->arrivalTime)): ?>
                                            <div><?php echo $dia_and_train->dia[$key]->arrivalTime; ?></div>
                                            <hr style="margin-top:0px;margin-bottom:0px;">
                                            <div><?php echo $dia_and_train->dia[$key]->departureTime; ?></div>
                                        <?php elseif (empty($dia_and_train->dia[$key + 1]->departureTime)): ?>
                                            <div><?php echo $dia_and_train->dia[$key]->departureTime; ?></div>
                                            <div>===</div>
                                        <?php else: ?>
                                            <div>　　</div>
                                            <hr style="margin-top:0px;margin-bottom:0px;">
                                            <div><?php echo $dia_and_train->dia[$key]->departureTime; ?></div>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <div><?php echo $dia_and_train->dia[$key]->departureTime; ?></div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>
