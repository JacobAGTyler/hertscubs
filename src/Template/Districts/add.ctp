<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('List Districts'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Scoutgroups'), ['controller' => 'Scoutgroups', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Scoutgroup'), ['controller' => 'Scoutgroups', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="districts form large-10 medium-9 columns">
    <?= $this->Form->create($district) ?>
    <fieldset>
        <legend><?= __('Add District') ?></legend>
        <?php
            echo $this->Form->input('id');
            echo $this->Form->input('county');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
