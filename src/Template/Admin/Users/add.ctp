<div class="users form large-10 medium-9 columns">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Add User') ?></legend>
        <?php
            echo $this->Form->input('role_id', ['options' => $roles]);
            echo $this->Form->input('scoutgroup_id', ['options' => $scoutgroups]);
            echo $this->Form->input('authrole', ['options' => ['user' => 'USER','admin' => 'ADMIN','champion' => 'CHAMPION']]);
            echo $this->Form->input('section');
            echo $this->Form->input('firstname');
            echo $this->Form->input('lastname');
            echo $this->Form->input('email');
            echo $this->Form->input('username');
            echo $this->Form->input('password');
            echo $this->Form->input('phone');
            echo $this->Form->input('address_1');
            echo $this->Form->input('address_2');
            echo $this->Form->input('city');
            echo $this->Form->input('county');
            echo $this->Form->input('postcode');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>