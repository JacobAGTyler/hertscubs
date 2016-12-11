<div class="row">
    <div class="col-lg-12">
        <h3><i class="fa fa-tasks fa-fw"></i> All Applications</h3>
        <div class="table-responsive">   
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th><?= $this->Paginator->sort('Application') ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                        <th><?= $this->Paginator->sort('User') ?></th>
                        <th><?= $this->Paginator->sort('Scoutgroup') ?></th>
                        <th><?= $this->Paginator->sort('Section') ?></th>
                        <th><?= $this->Paginator->sort('permitholder') ?></th>
                        <th><?= $this->Paginator->sort('modified') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($applications as $application): ?>
                        <tr>
                            <td><?= h($application->display_code) ?></td>
                            <td class="actions">
                                <div class="dropdown btn-group">
                                    <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown">
                                        <i class="fa fa-gear"></i>  <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu " role="menu">
                                        <li><?= $this->Html->link(__('View'), ['action' => 'view', $application->id]) ?></li>
                                        <li><?= $this->Html->link(__('Edit'), ['action' => 'edit', $application->id]) ?></li>
                                        <li class="divider"></li>
                                        <li><?= $this->Html->link(__('Add Note'), ['controller' => 'Notes', 'action' => 'new_application', $application->id]) ?></li>
                                    </ul>
                                </div>
                            </td>
                            <td><?= $application->has('user') ? $this->Html->link($application->user->full_name, ['controller' => 'Users', 'action' => 'view', $application->user->id]) : '' ?></td>
                            <td><?= $application->has('scoutgroup') ? $this->Html->link($this->Text->truncate($application->scoutgroup->scoutgroup,18), ['controller' => 'Scoutgroups', 'action' => 'view', $application->scoutgroup->id]) : '' ?></td>
                            <td><?= h($application->section) ?></td>
                            <td><?= $this->Text->truncate($application->permitholder,18) ?></td>
                            <td><?= $this->Time->i18nFormat($application->modified, 'dd-MMM-yy HH:mm') ?></td>
                        </tr>

                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="paginator">
                <ul class="pagination">
                    <?= $this->Paginator->prev('< ' . __('previous')) ?>
                    <?= $this->Paginator->numbers() ?>
                    <?= $this->Paginator->next(__('next') . ' >') ?>
                </ul>
                <p><?= $this->Paginator->counter() ?></p>
            </div>
        </div>
    </div>
</div>
