<?php

namespace App\Controller\Champion;

use App\Controller\Champion\AppController;
use Cake\Mailer\MailerAwareTrait;
use Cake\ORM\TableRegistry;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    use MailerAwareTrait;
    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $user = $this->Users->get($this->Auth->user('id'), ['contain' => 'Sections.Scoutgroups.Districts']);

        $champD = $user->section->scoutgroup;

        //$champD->district_id;

        $this->paginate = [
            'contain' => ['Roles', 'Sections.Scoutgroups'],
            'conditions' => [
                'Scoutgroups.district_id' => $champD->district_id]];
        $this->set('users', $this->paginate($this->Users));
        $this->set('_serialize', ['users']);
    }
    
    /**
     * View method
     *
     * @param string|null $id User id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Roles', 'Sections.Scoutgroups', 'Applications', 'Attendees']
        ]);
        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->get($this->Auth->user('id'), ['contain' => 'Sections.Scoutgroups.Districts']);

        $champD = $user->section->scoutgroup;

        $user = $this->Users->newEntity();
        
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            $newData = ['authrole' => 'user'];
            $user = $this->Users->patchEntity($user, $newData);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $roles = $this->Users->Roles->find('list', ['limit' => 200]);
        $scoutgroups = $this->Users->Sections->Scoutgroups->find('list', ['limit' => 200, 'conditions' => ['district_id' => $champD->district_id]]);
        $this->set(compact('user', 'roles', 'scoutgroups'));
        $this->set('_serialize', ['user']);
    }
    
    public function register()
    {
        $user = $this->Users->get($this->Auth->user('id'), ['contain' => 'Sections.Scoutgroups.Districts']);

        $champD = $user->section->scoutgroup;

        $user = $this->Users->newEntity();

        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->data);

            $newData = ['section' => 'Cubs', 'auth_role_id' => 1];
            $user = $this->Users->patchEntity($user, $newData);

            if ($this->Users->save($user)) {
                $this->Flash->success(__('You have successfully registered!'));
                return $this->redirect(['controller' => 'Users', 'action' => 'login', 'prefix' => false]);
            } else {
                $this->Flash->error(__('The user could not be registered. There may be an error. Please, try again.'));
            }
        }
        $roles = $this->Users->Roles->find('list', ['limit' => 200]);
        $scoutgroups = $this->Users->Sections->Scoutgroups->find('list', ['limit' => 200, 'conditions' => ['district_id' => $champD->district_id]]);
        $this->set(compact('user', 'roles', 'scoutgroups'));
        $this->set('_serialize', ['user']);

    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($this->Auth->user('id'), ['contain' => 'Sections.Scoutgroups.Districts']);

        $champD = $user->section->scoutgroup;

        $user = $this->Users->get($id, [
            'contain' => []
        ]);

        $usrRole = $user->authrole;

        if ($usrRole !== 'user' && $user->id !== $this->Auth->user('id')) {
            $this->Flash->error(__('The user could not be edited.'));
            return $this->redirect(['action' => 'index']);
        }
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $roles = $this->Users->Roles->find('list', ['limit' => 200]);
        $scoutgroups = $this->Users->Sections->Scoutgroups->find('list', ['limit' => 200, 'conditions' => ['district_id' => $champD->district_id]]);
        $this->set(compact('user', 'roles', 'scoutgroups'));
        $this->set('_serialize', ['user']);
    }

    public function update($id = null)
    {
        $user = $this->Users->get($id);

        $upperUser = ['firstname' => ucwords(strtolower($user->firstname))
            , 'lastname' => ucwords(strtolower($user->lastname))
            , 'address_1' => ucwords(strtolower($user->address_1))
            , 'address_2' => ucwords(strtolower($user->address_2))
            , 'city' => ucwords(strtolower($user->city))
            , 'county' => ucwords(strtolower($user->county))
            , 'postcode' => strtoupper($user->postcode)
            , 'section' => ucwords(strtolower($user->section))];

        $user = $this->Users->patchEntity($user, $upperUser);

        if ($this->Users->save($user)) {
            $this->Flash->success(__('The user has been updated.'));
            return $this->redirect(['action' => 'view', $user->id]);
        } else {
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
            return $this->redirect(['action' => 'view', $user->id]);
        }
    }

    public function login()
    {
        return $this->redirect([
            'controller' => 'Users',
            'action' => 'login',
            'prefix' => false
        ]);
    }

    public function logout()
    {
        $this->Flash->success('You are now logged out.');
        return $this->redirect($this->Auth->logout());
    }
}
