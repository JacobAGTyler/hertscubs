<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AuthRole[]|\Cake\Collection\CollectionInterface $authRoles
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Auth Role'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="authRoles index large-9 medium-8 columns content">
    <h3><?= __('Auth Roles') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('auth_role') ?></th>
                <th scope="col"><?= $this->Paginator->sort('admin_access') ?></th>
                <th scope="col"><?= $this->Paginator->sort('champion_access') ?></th>
                <th scope="col"><?= $this->Paginator->sort('super_user') ?></th>
                <th scope="col"><?= $this->Paginator->sort('auth') ?></th>
                <th scope="col"><?= $this->Paginator->sort('parent_access') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_access') ?></th>
                <th scope="col"><?= $this->Paginator->sort('section_limited') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($authRoles as $authRole): ?>
            <tr>
                <td><?= $this->Number->format($authRole->id) ?></td>
                <td><?= h($authRole->auth_role) ?></td>
                <td><?= h($authRole->admin_access) ?></td>
                <td><?= h($authRole->champion_access) ?></td>
                <td><?= h($authRole->super_user) ?></td>
                <td><?= $this->Number->format($authRole->auth) ?></td>
                <td><?= h($authRole->parent_access) ?></td>
                <td><?= h($authRole->user_access) ?></td>
                <td><?= h($authRole->section_limited) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $authRole->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $authRole->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $authRole->id], ['confirm' => __('Are you sure you want to delete # {0}?', $authRole->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
