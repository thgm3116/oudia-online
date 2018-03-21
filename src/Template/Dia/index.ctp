
<div class="container ">
    <div class="row">
        <div class="col-sm-12">
            <h1><?php echo $h1; ?></h1>
        </div>
    </div>
</div>
<hr>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h2><?php echo $h1; ?></h2>
        </div>
        <div class="col-sm-12">
            <table>
                <?php if ($dia_groups->count() === 0): ?>
                <tr>
                    <td>登録されている時刻表ファイルがありません。</td>
                </tr>
                <?php else: ?>
                    <?php foreach($dia_groups as $dia_group): ?>
                        <tr>
                            <td>
                                <?php
                                    echo $dia_group->dia_file->filename . ' - ' . $dia_group->name . ' => ';
                                    echo $this->Html->link(
                                        '(下り)',
                                        [
                                            'controller' => 'Dia',
                                            'action' => 'viewDefault',
                                            'dia_group_id' => $dia_group->id,
                                            'distance' => 'kudari'
                                        ]
                                    );
                                ?> |
                                <?php
                                    echo $this->Html->link(
                                        '(上り)',
                                        [
                                            'controller' => 'Dia',
                                            'action' => 'viewDefault',
                                            'dia_group_id' => $dia_group->id,
                                            'distance' => 'nobori'
                                        ]
                                    );
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </table>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <?php echo $this->Form->create($upload_form, ['type' => 'file']); ?>
            <?php echo $this->Form->file('diafile'); ?>
            <?php echo $this->Form->submit(); ?>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>
