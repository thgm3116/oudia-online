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
                列車ビュー
            </h2>
        </div>
        <div class="col-sm-12"><hr></div>
        <div class="col-sm-12">
            <ul>
                <li>列車番号 : <?php echo (empty($train_dia_array['identification_id'])) ? '(なし)' : $train_dia_array['identification_id']; ?></li>
                <li>備考 : <?php echo (empty($train_dia_array['bikou'])) ? '(なし)' : $train_dia_array['bikou']; ?></li>
            </ul>
        </div>
        <div class="col-sm-4">
            <table class="table table-condensed table-bordered table-striped" style="table-layout:fixed;">
                <tr>
                    <th class="info">駅名</th>
                    <th class="info">時刻</th>
                </tr>
                <?php $station_key = 1; ?>
                <?php foreach ($stations as $key => $station): ?>
                    <tr>
                        <th class="warning text-left">
                            <?php if ($station_key === count($stations)): ?>
                                <?php echo $station->name; ?>
                            <?php else: ?>
                                <?php echo $this->Html->link(
                                    $station['name'],
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
                        </th>
                        <td>
                            <div class="text-left text-nowrap">
                                <?php if ($train_dia_array['dia'][$key]['departureTime'] === '2'): ?>
                                    ﾚ
                                <?php elseif(!empty($train_dia_array['dia'][$key]['arrivalTime'])): ?>
                                    <?php echo $train_dia_array['dia'][$key]['arrivalTime']; ?>
                                    <hr style="margin-top:0px;margin-bottom:0px;">
                                    <?php echo $train_dia_array['dia'][$key]['departureTime']; ?>
                                <?php else: ?>
                                    <?php echo $train_dia_array['dia'][$key]['departureTime']; ?>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>
