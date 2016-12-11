<div class="row">
    <div class="col-xs-12">
        <h1 class="page-header"><i class="fa fa-tasks fa-fw"></i> Application <?= h($application->display_code) ?></h1>
    </div>
</div>
<div class="row">
    <div class="col-xs-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <span><?= __('User') ?>: <?= $application->has('user') ? $this->Html->link($application->user->full_name, ['controller' => 'Users', 'action' => 'view', $application->user->id]) : '' ?></span>
                </br>
                <span><?= __('Scoutgroup') ?>: <?= $application->has('scoutgroup') ? $this->Html->link($application->scoutgroup->scoutgroup, ['controller' => 'Scoutgroups', 'action' => 'view', $application->scoutgroup->id]) : '' ?></span>
                </br>
                <span><?= __('Team') ?>: <?= h($application->section) ?></span>
                </br>
                <span><?= __('Permitholder') ?>: <?= h($application->permitholder) ?></span>

            </div>
        </div>
    </div>
    <div class="col-xs-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <span><?= __('Event') ?>: <?= $application->has('event') ? $this->Html->link($application->event->full_name, ['controller' => 'Events', 'action' => 'view', $application->event->id]) : '' ?></span>
                </br>
                <span><?= __('App Number') ?>: <?= $this->Number->format($application->id) ?></span>
                </br>
                <span><?= __('Date Created') ?>: <?= $this->Time->i18nFormat($application->created, 'dd-MMM-yy HH:mm') ?></span>
                </br>
                <span><?= __('Last Modified') ?>: <?= $this->Time->i18nFormat($application->modified, 'dd-MMM-yy HH:mm') ?></span>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-tasks fa-fw"></i> Application Completion Progress
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div>   
                    <div class="progress progress-striped active">
                        <div class="progress-bar progress-bar-<?= h($status) ?>" role="progressbar" aria-valuenow="<?php echo ($done * 100); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $this->Number->toPercentage($done,1,['multiply' => true]); ?>">
                            <span class="sr-only"><?= $this->Number->toPercentage($done,1,['multiply' => true]); ?> Complete</span>
                        </div>
                    </div>
                </div>
                <h4><?= $this->Number->toPercentage($done,1,['multiply' => true]); ?></h4>
                <table class="table table-condensed">
                    <tr>
                        <th><?= __('Area') ?></th>
                        <th><?= __('Percentage') ?></th>
                        <th><?= __('Detail') ?></th>
                    </tr>
                    <tr>
                        <td><span>Invoice</span></td> 
                        <td><span><?= $this->Number->toPercentage($invDone,1,['multiply' => true]); ?></span></td>
                        <td><span class="text-muted"><?= $this->Number->format($invCount); ?> <?php if ($invCount == 1) : ?>Invoice<?php else : ?>Invoices<?php endif ?></span></td>
                    </tr>
                    <tr>
                        <td><span>Cubs</span></td>
                        <td><span><?= $this->Number->toPercentage($cubsDone,1,['multiply' => true]); ?></span></td>
                        <td><span class="text-muted"><?= $this->Number->format($attCubs); ?> Cubs of <?= $this->Number->format($invCubs); ?> on Invoice</span></td>
                    </tr>
                    <tr>
                        <td><span>Leaders &amp; YLs</span></td> 
                        <td><span><?= $this->Number->toPercentage($cubsNotDone,1,['multiply' => true]); ?></span></td>
                        <td><span class="text-muted"><?= $this->Number->format($attNotCubs); ?> Leaders of <?= $this->Number->format($invNotCubs); ?> on Invoice</span></td>
                    </tr>
                    <tr>
                        <td><span>Payments</span></td>
                        <td><span><?= $this->Number->toPercentage($payDone,1,['multiply' => true]); ?></span></td>
                        <td><span class="text-muted"><?= $this->Number->currency($sumPayments,'GBP'); ?> of <?= $this->Number->currency($sumValues,'GBP'); ?></span></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <?php if (!empty($application->attendees)): ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-group fa-fw"></i> Attendees on this Application
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table class="table table-hover">
                        <tr>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Role') ?></th>
                            <th><?= __('Contact Number') ?></th>
                            <th><?= __('Allergies') ?></th>
                        </tr>
                        <?php foreach ($application->attendees as $attendees): ?>
                        <tr>
                            <td><span><?= h($attendees->firstname) ?> <?= h($attendees->lastname) ?></span></td> 
                            <td><span><?= $attendees->has('role') ? $this->Text->truncate($attendees->role->role,10) : '' ?></span></td>
                            <td><span><?= $attendees->phone?></span></td>
                            <td><span>
                                <?php if (!empty($attendees->allergies)): ?>
                                    <?php foreach ($attendees->allergies as $allergies): ?>
                                        <?= h($allergies->allergy) . ' '?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </span></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>   
        <?php endif; ?>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <?php if (!empty($application->invoices)): ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-files-o fa-fw"></i> Invoices on this Application
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table class="table table-condensed">
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Sum Value') ?></th>
                            <th><?= __('Received') ?></th>
                            <th><?= __('Balance') ?></th>
                            <th><?= __('Date Created') ?></th>
                        </tr>
                        <?php foreach ($application->invoices as $invoices): ?>
                        <tr>
                            <td><span><?= h($invoices->id) ?></span></td>
                            <td><span><?= $this->Number->currency($invoices->initialvalue,'GBP') ?></span></td>
                            <td><span><?= $this->Number->currency($invoices->value,'GBP') ?></span></td>
                            <td><span><?= $this->Number->currency($invoices->balance,'GBP') ?></span></td>
                            <td><span><?= $this->Time->i18nformat($invoices->created,'dd-MMM-yy HH:mm') ?></span></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>      
        <?php endif; ?>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <?php if (!empty($application->notes)) : ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-pencil-square-o fa-fw"></i> Application Notes
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table class="table table-condensed">
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Note') ?></th>
                            <th><?= __('Date Modified') ?></th>
                        </tr>
                        <?php foreach ($application->notes as $notes): ?>
                            <tr>
                                <td><?= h($notes->id) ?></td>
                                <td><?= $this->Text->autoParagraph($notes->note_text) ?></td>
                                <td><?= $this->Time->i18nformat($notes->modified,'dd-MMM-yy HH:mm') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>